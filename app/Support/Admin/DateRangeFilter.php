<?php

namespace App\Support\Admin;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class DateRangeFilter
{
    /**
     * Apply an optional date_from / date_to filter to a query column.
     *
     * @param  Builder<\Illuminate\Database\Eloquent\Model>  $query
     */
    public static function apply(Builder $query, Request $request, string $column = 'updated_at'): void
    {
        $from = trim((string) $request->input('date_from', ''));
        $to = trim((string) $request->input('date_to', ''));

        if ($from === '' && $to === '') {
            return;
        }

        try {
            if ($from !== '') {
                $query->where($column, '>=', Carbon::parse($from)->startOfDay());
            }

            if ($to !== '') {
                $query->where($column, '<=', Carbon::parse($to)->endOfDay());
            }
        } catch (\Throwable) {
            // Ignore invalid date payloads from the client.
        }
    }
}
