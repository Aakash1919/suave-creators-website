<?php

namespace App\Support\Admin;

class DataTableActions
{
    /**
     * Render a row action kebab menu (native details + admin.css).
     *
     * Styles live in public/css/admin.css so they do not depend on Tailwind
     * scanning PHP strings (Vite build does not see class names in this file).
     *
     * @param  list<array{label: string, url?: string, href?: string, delete?: bool, method?: string, button?: bool, attrs?: array<string, scalar|null>, confirm?: string, confirmTitle?: string, confirmLabel?: string, class?: string, target?: string}>  $items
     */
    public static function menu(array $items): string
    {
        if ($items === []) {
            return '—';
        }

        $html = '<details class="admin-table__action-menu">'
            .'<summary class="admin-table__action-menu-trigger" aria-label="Actions">'
            .'<i class="fa-solid fa-ellipsis" aria-hidden="true"></i>'
            .'</summary>'
            .'<div class="admin-table__action-menu-panel">';

        foreach ($items as $item) {
            $label = e((string) ($item['label'] ?? 'Action'));
            $url = e((string) ($item['url'] ?? $item['href'] ?? '#'));
            $extraClass = trim((string) ($item['class'] ?? ''));
            $itemClass = 'admin-table__action-menu-item'.($extraClass !== '' ? ' '.e($extraClass) : '');

            if (! empty($item['delete'])) {
                $confirm = e((string) ($item['confirm'] ?? 'Delete this record?'));
                $confirmTitle = e((string) ($item['confirmTitle'] ?? 'Delete record?'));
                $confirmLabel = e((string) ($item['confirmLabel'] ?? 'Delete'));
                $html .= '<button type="button" class="'.$itemClass.' admin-table__action-menu-item--danger" data-admin-delete data-url="'.$url.'" data-confirm="'.$confirm.'" data-confirm-title="'.$confirmTitle.'" data-confirm-label="'.$confirmLabel.'">'.$label.'</button>';
                continue;
            }

            if (! empty($item['method'])) {
                $method = strtoupper(trim((string) $item['method']));
                $confirm = e((string) ($item['confirm'] ?? 'Continue with this action?'));
                $confirmTitle = e((string) ($item['confirmTitle'] ?? 'Confirm?'));
                $confirmLabel = e((string) ($item['confirmLabel'] ?? $item['label'] ?? 'Confirm'));
                $html .= '<button type="button" class="'.$itemClass.'" data-admin-action data-url="'.$url.'" data-method="'.e($method).'" data-confirm="'.$confirm.'" data-confirm-title="'.$confirmTitle.'" data-confirm-label="'.$confirmLabel.'">'.$label.'</button>';
                continue;
            }

            if (! empty($item['button'])) {
                $attrs = self::htmlAttributes(is_array($item['attrs'] ?? null) ? $item['attrs'] : []);
                $html .= '<button type="button" class="'.$itemClass.'"'.$attrs.'>'.$label.'</button>';
                continue;
            }

            $target = trim((string) ($item['target'] ?? ''));
            $attrs = '';
            if ($target !== '') {
                $attrs = ' target="'.e($target).'"';
                if ($target === '_blank') {
                    $attrs .= ' rel="noopener noreferrer"';
                }
            }

            $html .= '<a href="'.$url.'"'.$attrs.' class="'.$itemClass.'">'.$label.'</a>';
        }

        $html .= '</div></details>';

        return $html;
    }

    /**
     * @param  array<string, scalar|null>  $attrs
     */
    private static function htmlAttributes(array $attrs): string
    {
        $html = '';

        foreach ($attrs as $name => $value) {
            if ($value === null || $value === false) {
                continue;
            }

            $key = e((string) $name);

            if ($value === true) {
                $html .= ' '.$key;
                continue;
            }

            $html .= ' '.$key.'="'.e((string) $value).'"';
        }

        return $html;
    }
}
