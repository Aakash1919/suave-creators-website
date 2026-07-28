(function attachTheSuaveStarPearl(global) {
  "use strict";

  const doc = global.document;
  const ROOT_SELECTOR = "[data-the-suave-emblem]";
  const DEFAULT_ASSET_BASE = "./the-suave-star-pearl/assets/";
  const controllers = new Set();
  const controllersByRoot = new WeakMap();
  let removalObserver = null;

  function normalizeAssetBase(value) {
    const trimmed = String(value || "").trim();
    const base = trimmed || DEFAULT_ASSET_BASE;
    return base.endsWith("/") ? base : `${base}/`;
  }

  function cssUrl(value) {
    return `url(${JSON.stringify(value)})`;
  }

  function pageIsHidden() {
    return Boolean(doc && typeof doc.hidden === "boolean" && doc.hidden);
  }

  function ensureRemovalObserver() {
    if (
      removalObserver ||
      !doc ||
      !doc.documentElement ||
      typeof global.MutationObserver !== "function"
    ) return;

    removalObserver = new global.MutationObserver(() => {
      for (const controller of Array.from(controllers)) {
        if (!controller.root.isConnected) controller.destroy();
      }
    });
    removalObserver.observe(doc.documentElement, {
      childList: true,
      subtree: true,
    });
  }

  class EmblemController {
    constructor(root) {
      this.root = root;
      this.stage = root.querySelector("[data-tsp-stage]");
      this.starImage = root.querySelector("[data-tsp-star-image]");
      this.pearlImage = root.querySelector("[data-tsp-pearl-image]");
      if (!this.stage || !this.starImage || !this.pearlImage) {
        throw new Error("Malformed the.Suave star-and-pearl markup");
      }

      this.destroyed = false;
      this.manuallyPaused = false;
      this.inView = true;
      this.sync = this.sync.bind(this);
      this.updateAssets();
      this.installLifecycle();
      this.root.setAttribute("data-tsp-ready", "");
      this.sync();
    }

    updateAssets() {
      const base = normalizeAssetBase(
        this.root.getAttribute("data-asset-base"),
      );
      const starUrl = `${base}the-suave-metallic-star.png`;
      const pearlUrl = `${base}the-suave-white-pearl.png`;
      this.starImage.setAttribute("src", starUrl);
      this.pearlImage.setAttribute("src", pearlUrl);
      this.root.style.setProperty("--tsp-star-mask", cssUrl(starUrl));
      this.root.style.setProperty("--tsp-pearl-mask", cssUrl(pearlUrl));
    }

    installLifecycle() {
      if (doc && typeof doc.addEventListener === "function") {
        doc.addEventListener("visibilitychange", this.sync);
      }

      if (typeof global.IntersectionObserver === "function") {
        this.intersectionObserver = new global.IntersectionObserver(
          (entries) => {
            this.inView = Boolean(entries[0] && entries[0].isIntersecting);
            this.sync();
          },
          { threshold: 0.08 },
        );
        this.intersectionObserver.observe(this.root);
      } else {
        this.intersectionObserver = null;
      }
    }

    sync() {
      if (this.destroyed) return;
      const paused = this.manuallyPaused || !this.inView || pageIsHidden();
      this.root.toggleAttribute("data-tsp-paused", paused);
    }

    pause() {
      this.manuallyPaused = true;
      this.sync();
    }

    resume() {
      this.manuallyPaused = false;
      this.sync();
    }

    destroy() {
      if (this.destroyed) return;
      this.destroyed = true;
      if (this.intersectionObserver) this.intersectionObserver.disconnect();
      if (doc && typeof doc.removeEventListener === "function") {
        doc.removeEventListener("visibilitychange", this.sync);
      }
      this.root.removeAttribute("data-tsp-ready");
      this.root.removeAttribute("data-tsp-paused");
      this.root.style.removeProperty("--tsp-star-mask");
      this.root.style.removeProperty("--tsp-pearl-mask");
      controllers.delete(this);
      controllersByRoot.delete(this.root);
      if (controllers.size === 0 && removalObserver) {
        removalObserver.disconnect();
        removalObserver = null;
      }
    }
  }

  function init(root) {
    if (!root || controllersByRoot.has(root)) {
      return root ? controllersByRoot.get(root) : null;
    }
    try {
      const controller = new EmblemController(root);
      controllers.add(controller);
      controllersByRoot.set(root, controller);
      ensureRemovalObserver();
      return controller;
    } catch (_error) {
      return null;
    }
  }

  function initAll(scope) {
    const searchRoot = scope || doc;
    if (!searchRoot || typeof searchRoot.querySelectorAll !== "function") {
      return [];
    }
    const roots = Array.from(searchRoot.querySelectorAll(ROOT_SELECTOR));
    if (
      typeof searchRoot.matches === "function" &&
      searchRoot.matches(ROOT_SELECTOR)
    ) {
      roots.unshift(searchRoot);
    }
    return roots.map(init).filter(Boolean);
  }

  const api = Object.freeze({
    version: "1.0.0",
    initAll,
    pauseAll() {
      controllers.forEach((controller) => controller.pause());
    },
    resumeAll() {
      controllers.forEach((controller) => controller.resume());
    },
    destroyAll() {
      Array.from(controllers).forEach((controller) => controller.destroy());
    },
  });

  global.TheSuaveStarPearl = api;
  if (doc) {
    if (doc.readyState === "loading") {
      doc.addEventListener("DOMContentLoaded", () => api.initAll(), {
        once: true,
      });
    } else {
      api.initAll();
    }
  }
})(window);
