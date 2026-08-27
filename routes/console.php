<?php

use Illuminate\Console\Scheduling\Schedule as ScheduleDefinition;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Schedule::command('generate:blog')
    ->days([ScheduleDefinition::TUESDAY, ScheduleDefinition::FRIDAY])
    ->at((string) config('blogs.trend_drafts.time', '09:00'))
    ->timezone((string) config('app.timezone', 'Asia/Kolkata'))
    ->when(fn (): bool => (bool) config('blogs.trend_drafts.enabled', true))
    ->withoutOverlapping();

Schedule::command('seo:audit-report')
    ->days([ScheduleDefinition::MONDAY])
    ->at((string) config('seo.audit_report.time', '09:00'))
    ->timezone((string) config('app.timezone', 'Asia/Kolkata'))
    ->when(fn (): bool => (bool) config('seo.audit_report.enabled', true))
    ->withoutOverlapping();
