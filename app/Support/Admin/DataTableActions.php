<?php

namespace App\Support\Admin;

class DataTableActions
{
    /**
     * Render a row action kebab menu (native details + Tailwind).
     *
     * @param  list<array{label: string, url?: string, href?: string, delete?: bool, button?: bool, attrs?: array<string, scalar|null>, confirm?: string, confirmTitle?: string, confirmLabel?: string, class?: string, target?: string}>  $items
     */
    public static function menu(array $items): string
    {
        if ($items === []) {
            return '—';
        }

        $html = '<details class="group relative inline-flex justify-end">'
            .'<summary class="flex h-8 w-8 list-none cursor-pointer items-center justify-center rounded-full border border-[var(--admin-border)] bg-white text-[var(--admin-gray)] hover:border-[#cfcaff] hover:bg-[var(--admin-primary-soft)] hover:text-[var(--admin-primary)] group-open:border-[#cfcaff] group-open:bg-[var(--admin-primary-soft)] group-open:text-[var(--admin-primary)] [&::-webkit-details-marker]:hidden" aria-label="Actions">'
            .'<i class="fa-solid fa-ellipsis" aria-hidden="true"></i>'
            .'</summary>'
            .'<div class="absolute right-0 top-full z-40 mt-1.5 min-w-[8.5rem] rounded-lg border border-[var(--admin-border)] bg-white p-1.5 shadow-[0_10px_24px_rgba(15,23,42,0.12)]">';

        foreach ($items as $item) {
            $label = e((string) ($item['label'] ?? 'Action'));
            $url = e((string) ($item['url'] ?? $item['href'] ?? '#'));
            $extraClass = e((string) ($item['class'] ?? ''));
            $itemClass = 'block w-full rounded-md px-3 py-2 text-left text-sm font-medium no-underline '.$extraClass;

            if (! empty($item['delete'])) {
                $confirm = e((string) ($item['confirm'] ?? 'Delete this record?'));
                $confirmTitle = e((string) ($item['confirmTitle'] ?? 'Delete record?'));
                $confirmLabel = e((string) ($item['confirmLabel'] ?? 'Delete'));
                $html .= '<button type="button" class="'.$itemClass.' text-[var(--admin-danger)] hover:bg-[var(--admin-danger-soft)]" data-admin-delete data-url="'.$url.'" data-confirm="'.$confirm.'" data-confirm-title="'.$confirmTitle.'" data-confirm-label="'.$confirmLabel.'">'.$label.'</button>';
                continue;
            }

            if (! empty($item['button'])) {
                $attrs = self::htmlAttributes(is_array($item['attrs'] ?? null) ? $item['attrs'] : []);
                $html .= '<button type="button" class="'.$itemClass.' text-[var(--admin-text)] hover:bg-[var(--admin-primary-soft)] hover:text-[var(--admin-primary)]"'.$attrs.'>'.$label.'</button>';
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

            $html .= '<a href="'.$url.'"'.$attrs.' class="'.$itemClass.' text-[var(--admin-text)] hover:bg-[var(--admin-primary-soft)] hover:text-[var(--admin-primary)]">'.$label.'</a>';
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
