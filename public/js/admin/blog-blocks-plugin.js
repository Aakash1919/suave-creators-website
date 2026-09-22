/**
 * Blog visual-block toolbar commands for RichTextEditor.
 * Inserts the same HTML the public single-blog page styles.
 */
(function () {
  if (!window.RTE_DefaultConfig) {
    window.RTE_DefaultConfig = {};
  }

  var icon = function (path) {
    return '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">' + path + '</svg>';
  };

  var labels = {
    insertfeaturedimage: 'Featured image',
    inserttakeaways: 'Takeaways',
    insertresults: 'Results',
    insertchecklist: 'Checklist',
    insertstats: 'Stat boxes',
    insertchart: 'Completion bars',
    insertinsight: 'Insight',
    insertblogtable: 'Comparison table',
  };

  var icons = {
    insertfeaturedimage: icon('<rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><path d="M21 15l-5-5L5 21"/>'),
    inserttakeaways: icon('<path d="M8 6h13"/><path d="M8 12h13"/><path d="M8 18h13"/><path d="M3 6h.01"/><path d="M3 12h.01"/><path d="M3 18h.01"/>'),
    insertresults: icon('<path d="M4 19V5"/><path d="M4 19h16"/><path d="M8 16v-5"/><path d="M12 16V8"/><path d="M16 16v-3"/>'),
    insertchecklist: icon('<path d="M9 11l3 3L22 4"/><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/>'),
    insertstats: icon('<rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/><rect x="3" y="14" width="7" height="7" rx="1"/><rect x="14" y="14" width="7" height="7" rx="1"/>'),
    insertchart: icon('<path d="M4 19h16"/><path d="M7 16V9"/><path d="M12 16V5"/><path d="M17 16v-7"/>'),
    insertinsight: icon('<path d="M4 7h16"/><path d="M4 12h10"/><path d="M4 17h13"/><path d="M19 11v8"/>'),
    insertblogtable: icon('<rect x="3" y="5" width="18" height="14" rx="1"/><path d="M3 10h18"/><path d="M9 5v14"/><path d="M15 5v14"/>'),
  };

  Object.keys(labels).forEach(function (cmd) {
    window.RTE_DefaultConfig['text_' + cmd] = labels[cmd];
    window.RTE_DefaultConfig['svgCode_' + cmd] = icons[cmd];
  });

  function sidebarFeaturedPreviewSrc() {
    try {
      var previewImg = document.querySelector('.admin-blog-form__image-preview');
      if (previewImg && previewImg.src) {
        return previewImg.src;
      }
    } catch (e) {
      /* ignore */
    }

    return '';
  }

  /**
   * Remove legacy / duplicate preview thumbs inside a featured-image box.
   * Keeps at most one `.blog-featured-image-box__preview` wrapper.
   */
  function normalizeFeaturedImagePreviews(box) {
    if (!box) {
      return null;
    }

    var kept = null;
    var previews = box.querySelectorAll('.blog-featured-image-box__preview');
    for (var p = 0; p < previews.length; p++) {
      if (!kept) {
        kept = previews[p];
      } else {
        previews[p].remove();
      }
    }

    var imgs = box.querySelectorAll('img');
    for (var i = 0; i < imgs.length; i++) {
      var img = imgs[i];
      if (kept && kept.contains(img)) {
        continue;
      }
      var alt = (img.getAttribute('alt') || '').toLowerCase();
      if (alt === 'featured image preview' || img.classList.contains('blog-featured-image-box__thumb')) {
        var wrap = img.parentElement;
        if (wrap && wrap !== box && !wrap.classList.contains('blog-featured-image-box__preview') && wrap.childNodes.length === 1) {
          wrap.remove();
        } else {
          img.remove();
        }
      }
    }

    return kept;
  }

  /**
   * Live-paint the sidebar featured image into editor markers.
   * Do not bake preview URLs into insert HTML — blob: srcs die after reload.
   */
  function paintFeaturedImagePreviews(editor) {
    if (!editor) {
      return;
    }

    try {
      var editdoc = typeof editor.getDocument === 'function' ? editor.getDocument() : null;
      var editable = typeof editor.getEditable === 'function' ? editor.getEditable() : (editdoc && editdoc.body);
      if (!editdoc || !editable) {
        return;
      }

      var src = sidebarFeaturedPreviewSrc();
      var boxes = editable.querySelectorAll('.blog-featured-image-box');
      for (var i = 0; i < boxes.length; i++) {
        var box = boxes[i];

        // Drop stray imgs/divs that sat beside the box inside the figure (old markup).
        var figure = box.closest('figure[data-featured-image]');
        if (figure) {
          var child = figure.firstElementChild;
          while (child) {
            var next = child.nextElementSibling;
            if (child !== box) {
              if (child.tagName === 'IMG') {
                child.remove();
              } else if (
                child.tagName === 'DIV' &&
                !child.classList.contains('blog-featured-image-box') &&
                child.querySelector('img[alt="Featured image preview"]')
              ) {
                child.remove();
              }
            }
            child = next;
          }
        }

        var preview = normalizeFeaturedImagePreviews(box);

        if (!src) {
          if (preview) {
            preview.remove();
          }
          continue;
        }

        if (!preview) {
          preview = editdoc.createElement('div');
          preview.className = 'blog-featured-image-box__preview';
          var img = editdoc.createElement('img');
          img.className = 'blog-featured-image-box__thumb';
          img.alt = 'Featured image preview';
          preview.appendChild(img);
          box.insertBefore(preview, box.firstChild);
        }

        var thumb = preview.querySelector('img');
        if (!thumb) {
          thumb = editdoc.createElement('img');
          thumb.className = 'blog-featured-image-box__thumb';
          thumb.alt = 'Featured image preview';
          preview.appendChild(thumb);
        }

        if (thumb.getAttribute('src') !== src) {
          thumb.setAttribute('src', src);
        }
      }
    } catch (e) {
      /* best-effort */
    }
  }

  function htmlFeaturedImage() {
    // Marker only — preview thumb is painted live via paintFeaturedImagePreviews().
    return ''
      + '<figure class="single-blog-main__image single-blog-main__image--inline" data-featured-image="true" contenteditable="false">'
      + '<div class="blog-featured-image-box">'
      + '<span class="blog-featured-image-box__badge">FEATURED IMAGE</span>'
      + '<p class="blog-featured-image-box__title">Post Featured Image</p>'
      + '<p class="blog-featured-image-box__hint">The featured image set in the sidebar will appear here on the published page.</p>'
      + '</div>'
      + '</figure><p><br></p>';
  }

  function htmlTakeaways() {
    return ''
      + '<div class="blog-takeaways">'
      + '<p class="blog-takeaways__title">Key takeaways</p>'
      + '<ul>'
      + '<li>Replace this with the first specific takeaway</li>'
      + '<li>Replace this with the second specific takeaway</li>'
      + '<li>Replace this with the third specific takeaway</li>'
      + '</ul>'
      + '</div><p><br></p>';
  }

  function htmlResults() {
    return ''
      + '<div class="blog-results">'
      + '<p class="blog-results__title">Results at a glance</p>'
      + '<ul>'
      + '<li>Replace this with the first qualitative outcome</li>'
      + '<li>Replace this with the second qualitative outcome</li>'
      + '<li>Replace this with the third qualitative outcome</li>'
      + '</ul>'
      + '</div><p><br></p>';
  }

  function htmlChecklist() {
    return ''
      + '<div class="blog-checklist">'
      + '<p class="blog-checklist__title">Implementation checklist</p>'
      + '<ul>'
      + '<li>Name the workflow this work will change</li>'
      + '<li>List the systems that must talk to each other</li>'
      + '<li>Agree the first two-week slice</li>'
      + '<li>Decide who owns data export</li>'
      + '<li>Schedule the first ops review</li>'
      + '</ul>'
      + '</div><p><br></p>';
  }

  function htmlStats() {
    return ''
      + '<div class="blog-stats">'
      + '<div class="blog-stat"><p class="blog-stat__value">Two-week pilot</p><p class="blog-stat__label">Replace with a concrete timebox</p></div>'
      + '<div class="blog-stat"><p class="blog-stat__value">One shared backlog</p><p class="blog-stat__label">Replace with the operating change</p></div>'
      + '<div class="blog-stat"><p class="blog-stat__value">Weekly ops review</p><p class="blog-stat__label">Replace with who meets and why</p></div>'
      + '</div><p><br></p>';
  }

  function chartRow(label, width, level) {
    return ''
      + '<div class="blog-chart__row">'
      + '<span class="blog-chart__label">' + label + '</span>'
      + '<span class="blog-chart__track"><span class="blog-chart__bar blog-chart__bar--' + level + '" data-width="' + width + '" style="width: ' + width + '%;"></span></span>'
      + '<span class="blog-chart__value">' + width + '%</span>'
      + '</div>';
  }

  function htmlChart() {
    return ''
      + '<figure class="blog-chart">'
      + '<figcaption>Edit each label and percent in this article. The bar fill follows the percent.</figcaption>'
      + chartRow('Assess', 90, 'high')
      + chartRow('Pilot', 62, 'mid')
      + chartRow('Harden', 48, 'mid')
      + chartRow('Measure', 34, 'low')
      + '</figure><p><br></p>';
  }

  function htmlInsight() {
    return '<aside class="blog-insight"><p><strong>Suave Creators take:</strong> Replace this with one specific recommendation.</p></aside><p><br></p>';
  }

  function htmlTable() {
    return ''
      + '<div class="blog-table-wrap"><table>'
      + '<thead><tr><th>Phase</th><th>Focus</th><th>Outcome</th></tr></thead>'
      + '<tbody>'
      + '<tr><td>Assess</td><td>Name the stuck workflow</td><td>A shared picture of today</td></tr>'
      + '<tr><td>Pilot</td><td>Ship one slice</td><td>Proof the handoff works</td></tr>'
      + '<tr><td>Harden</td><td>Integrations and access</td><td>The new path is the default</td></tr>'
      + '<tr><td>Measure</td><td>Ops review cadence</td><td>The team can see what changed</td></tr>'
      + '</tbody></table></div><p><br></p>';
  }

  var commands = {
    insertfeaturedimage: { html: htmlFeaturedImage, focus: 'blog-featured-image-box', slash: ['featured', 'image', 'banner'] },
    inserttakeaways: { html: htmlTakeaways, focus: 'blog-takeaways', slash: ['takeaways', 'bullets', 'summary'] },
    insertresults: { html: htmlResults, focus: 'blog-results', slash: ['results', 'outcomes'] },
    insertchecklist: { html: htmlChecklist, focus: 'blog-checklist', slash: ['checklist', 'todo', 'steps'] },
    insertstats: { html: htmlStats, focus: 'blog-stats', slash: ['stats', 'metrics', 'boxes'] },
    insertchart: { html: htmlChart, focus: 'blog-chart', slash: ['chart', 'bars', 'completion', 'progress'] },
    insertinsight: { html: htmlInsight, focus: 'blog-insight', slash: ['insight', 'callout', 'aside'] },
    insertblogtable: { html: htmlTable, focus: 'blog-table-wrap', slash: ['table', 'comparison', 'grid'] },
  };

  var BLOCK_SELECTOR = '.blog-takeaways, .blog-results, .blog-checklist, .blog-stats, .blog-chart, .blog-insight, .blog-table-wrap, .blog-featured-image-box, figure[data-featured-image="true"]';

  function ensureEditorSelection(editor) {
    try {
      if (typeof editor.focus === 'function') {
        editor.focus();
      }
      var editdoc = typeof editor.getDocument === 'function' ? editor.getDocument() : null;
      var editable = typeof editor.getEditable === 'function' ? editor.getEditable() : (editdoc && editdoc.body);
      if (!editdoc || !editable) {
        return;
      }
      var sel = typeof editor.getSelection === 'function' ? editor.getSelection() : (editdoc.defaultView ? editdoc.defaultView.getSelection() : editdoc.getSelection());
      if (!sel || sel.rangeCount === 0) {
        var range = editdoc.createRange();
        range.selectNodeContents(editable);
        range.collapse(false);
        if (sel) {
          sel.removeAllRanges();
          sel.addRange(range);
        }
      }
    } catch (e) {
      /* best-effort */
    }
  }

  function insertHtml(editor, html) {
    ensureEditorSelection(editor);

    if (typeof editor.insertHTML === 'function') {
      try {
        editor.insertHTML(html);
        return true;
      } catch (e) {
        /* fall through to execCommand / DOM */
      }
    }

    try {
      var doc = typeof editor.getDocument === 'function' ? editor.getDocument() : null;
      if (doc && typeof doc.execCommand === 'function') {
        var ok = doc.execCommand('insertHTML', false, html);
        if (ok) {
          return true;
        }
      }
    } catch (e) {
      /* fall through to DOM insertion */
    }

    try {
      var editdoc = typeof editor.getDocument === 'function' ? editor.getDocument() : null;
      var editable = typeof editor.getEditable === 'function' ? editor.getEditable() : (editdoc && editdoc.body);
      if (editdoc && editable) {
        var temp = editdoc.createElement('div');
        temp.innerHTML = html;
        var frag = editdoc.createDocumentFragment();
        var node;
        while ((node = temp.firstChild)) {
          frag.appendChild(node);
        }
        var sel = typeof editor.getSelection === 'function' ? editor.getSelection() : (editdoc.defaultView ? editdoc.defaultView.getSelection() : editdoc.getSelection());
        if (sel && sel.rangeCount > 0) {
          var range = sel.getRangeAt(0);
          range.deleteContents();
          range.insertNode(frag);
        } else {
          editable.appendChild(frag);
        }
        return true;
      }
    } catch (e) {
      /* ignore */
    }

    return false;
  }

  function insertBlock(editor, cmd) {
    var def = commands[cmd];
    if (!def || !editor) {
      return false;
    }

    if (cmd === 'insertfeaturedimage') {
      try {
        var editdoc = typeof editor.getDocument === 'function' ? editor.getDocument() : null;
        var editable = typeof editor.getEditable === 'function' ? editor.getEditable() : (editdoc && editdoc.body);
        if (editable) {
          var existing = editable.querySelectorAll('[data-featured-image]');
          for (var i = 0; i < existing.length; i++) {
            existing[i].remove();
          }
        }
      } catch (e) {
        /* ignore */
      }
    }

    if (!insertHtml(editor, def.html())) {
      return false;
    }

    if (cmd === 'insertfeaturedimage') {
      try {
        var posSelect = document.getElementById('blog-featured-image-position');
        if (posSelect) {
          posSelect.value = 'manual';
          posSelect.dispatchEvent(new Event('change', { bubbles: true }));
        }
      } catch (e) {
        /* ignore */
      }
      paintFeaturedImagePreviews(editor);
    }

    try {
      var editdoc = editor.getDocument();
      var editable = typeof editor.getEditable === 'function' ? editor.getEditable() : (editdoc && editdoc.body);
      var targets = editable && editable.getElementsByClassName ? editable.getElementsByClassName(def.focus) : [];
      if (targets && targets.length) {
        var target = targets[targets.length - 1];
        if (cmd !== 'insertfeaturedimage') {
          var caretNode = target.querySelector('li, p, .blog-chart__label, .blog-stat__value') || target;
          var range = editdoc.createRange();
          range.selectNodeContents(caretNode);
          range.collapse(true);
          var sel = editor.getSelection();
          sel.removeAllRanges();
          sel.addRange(range);
        }
      }
    } catch (e) {
      /* caret is best-effort */
    }

    if (typeof editor.fireChange === 'function') {
      try {
        editor.fireChange();
      } catch (e) {
        /* ignore */
      }
    }

    return true;
  }

  function runEditorCommand(editor, name) {
    if (!editor || typeof editor.execCommand !== 'function') {
      return false;
    }
    if (typeof editor.focus === 'function') {
      editor.focus();
    }
    try {
      editor.execCommand(name);
      return true;
    } catch (e) {
      return false;
    }
  }

  function nearestBlock(editor) {
    try {
      var sel = typeof editor.getSelection === 'function' ? editor.getSelection() : null;
      var node = sel && (sel.anchorNode || sel.focusNode);
      if (node && node.nodeType === 3) {
        node = node.parentElement || node.parentNode;
      }
      if (node && node.closest) {
        return node.closest(BLOCK_SELECTOR);
      }
    } catch (e) {
      /* ignore */
    }
    return null;
  }

  function removeNearest(editor) {
    if (!editor) {
      return false;
    }
    if (typeof editor.focus === 'function') {
      editor.focus();
    }

    var block = nearestBlock(editor);
    if (!block) {
      return false;
    }

    try {
      var doc = editor.getDocument();
      var sel = editor.getSelection();
      var range = doc.createRange();
      range.selectNode(block);
      sel.removeAllRanges();
      sel.addRange(range);
      if (doc.execCommand('delete')) {
        if (typeof editor.fireChange === 'function') {
          editor.fireChange();
        }
        return true;
      }
    } catch (e) {
      /* fall through */
    }

    try {
      block.parentNode.removeChild(block);
      if (typeof editor.fireChange === 'function') {
        editor.fireChange();
      }
      return true;
    } catch (e) {
      return false;
    }
  }

  function registerSlash(ed) {
    if (!ed || !ed.slashCommands || typeof ed.slashCommands.register !== 'function') {
      return false;
    }

    Object.keys(commands).forEach(function (cmd) {
      ed.slashCommands.register({
        id: 'blog-' + cmd,
        section: 'Blog layout',
        title: labels[cmd],
        description: 'Insert a public-blog block',
        keywords: commands[cmd].slash,
        iconSvg: icons[cmd],
        run: function () {
          insertBlock(ed, cmd);
        },
      });
    });

    return true;
  }

  function RTE_Plugin_BlogBlocks() {
    var obj = this;
    var editor;

    obj.PluginName = 'BlogBlocks';

    obj.InitConfig = function () {};

    obj.InitEditor = function (argeditor) {
      editor = argeditor;

      Object.keys(commands).forEach(function (cmd) {
        editor.attachEvent('exec_command_' + cmd, function (state) {
          state.returnValue = true;
          insertBlock(editor, cmd);
        });
      });

      [0, 50, 250].forEach(function (delay) {
        window.setTimeout(function () {
          registerSlash(editor);
        }, delay);
      });
    };

    obj.insert = function (cmd) {
      return insertBlock(editor, cmd);
    };
  }

  window.RTE_DefaultConfig.plugin_blogblocks = RTE_Plugin_BlogBlocks;
  window.SuaveBlogBlocks = {
    insert: insertBlock,
    paintFeaturedImagePreviews: paintFeaturedImagePreviews,
    undo: function (editor) {
      return runEditorCommand(editor, 'undo');
    },
    redo: function (editor) {
      return runEditorCommand(editor, 'redo');
    },
    removeNearest: removeNearest,
    labels: labels,
  };
})();
