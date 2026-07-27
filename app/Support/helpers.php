<?php

use Illuminate\Support\Facades\Session;

if (! function_exists('createFlashMessage')) {
    /**
     * Build "{Resource} has been {action} successfully."
     * Flashes to session `status` by default (callers never choose a flash key).
     *
     * Examples:
     *   createFlashMessage('Blog');              // Blog has been created successfully.
     *   createFlashMessage('Blog', 'updated');   // Blog has been updated successfully.
     *   createFlashMessage('Blog', 'deleted');   // Blog has been deleted successfully.
     *
     * @param  'created'|'updated'|'deleted'|'saved'|string  $action
     */
    function createFlashMessage(string $resource, string $action = 'created', bool $flash = true): string
    {
        $resource = trim($resource);
        $verb = match (strtolower(trim($action))) {
            'create', 'created' => 'created',
            'update', 'updated' => 'updated',
            'delete', 'deleted' => 'deleted',
            'save', 'saved' => 'saved',
            default => trim($action),
        };

        $message = $resource === ''
            ? sprintf('Record has been %s successfully.', $verb)
            : sprintf('%s has been %s successfully.', $resource, $verb);

        if ($flash) {
            Session::flash('status', $message);
        }

        return $message;
    }
}
