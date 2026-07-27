<?php

namespace App\Http\Controllers\Admin\Concerns;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

trait RespondsToAdminAjax
{
    /**
     * Whether the request expects a JSON admin response.
     */
    protected function wantsAdminJson(Request $request): bool
    {
        return $request->ajax() || $request->expectsJson() || $request->boolean('_ajax');
    }

    /**
     * Return a success JSON payload for AJAX, or a flash redirect otherwise.
     *
     * Message: createFlashMessage('Blog') → "Blog has been created successfully."
     *
     * @param  'created'|'updated'|'deleted'|'saved'|string  $action
     * @param  array<string, mixed>  $extra
     */
    protected function adminSuccess(
        Request $request,
        string $resource,
        string $action = 'created',
        ?string $redirectRoute = null,
        mixed $routeParams = [],
        array $extra = [],
    ): JsonResponse|RedirectResponse {
        $isAjax = $this->wantsAdminJson($request);
        $message = createFlashMessage($resource, $action, flash: ! $isAjax);

        if ($isAjax) {
            return response()->json(array_merge([
                'success' => true,
                'message' => $message,
                'redirect' => $redirectRoute ? route($redirectRoute, $routeParams) : null,
            ], $extra));
        }

        return $redirectRoute
            ? redirect()->route($redirectRoute, $routeParams)
            : back();
    }

    /**
     * Return an error JSON payload for AJAX, or a flash redirect otherwise.
     *
     * @param  array<string, mixed>  $extra
     */
    protected function adminError(
        Request $request,
        string $message,
        int $status = 422,
        array $extra = [],
    ): JsonResponse|RedirectResponse {
        if ($this->wantsAdminJson($request)) {
            return response()->json(array_merge([
                'success' => false,
                'message' => $message,
            ], $extra), $status);
        }

        Session::flash('error', $message);

        return back()->withInput();
    }
}
