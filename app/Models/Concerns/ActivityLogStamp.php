<?php

namespace App\Models\Concerns;

use Illuminate\Support\Str;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

trait ActivityLogStamp
{
    use LogsActivity;

    /**
     * Get the Options for LogsActivity
     *
     * @return LogOptions
     */
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable()
            ->useLogName(config('appconfig.model.activity_log.log_name'))
            ->dontSubmitEmptyLogs()
            ->logOnlyDirty()
            ->setDescriptionForEvent(function ($eventName) {
                return Str::of(self::class)
                    ->append('::')
                    ->append($eventName)
                    ->__toString();
            });
    }
}
