<?php

namespace App\Casts\DateTime;

use Carbon\Carbon;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;

class SecondsToHoursMinutesSecondsCast implements CastsAttributes
{
    /**
     * Cast the given value.
     *
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @param  string  $key
     * @param  mixed  $value
     * @param  array  $attributes
     * @return mixed
     */
    public function get($model, string $key, $value, array $attributes)
    {
        if ($value) {
            $dt = Carbon::now();
            $hours = $dt->diffInHours($dt->copy()->addSeconds($value));
            $minutes = $dt->diffInMinutes($dt->copy()->addSeconds($value)->subHours($hours));
            $seconds = $dt->diffInSeconds($dt->copy()->addSeconds($value)->subHours($hours)->subMinutes($minutes));

            return sprintf('%02d:%02d:%02d', $hours, $minutes, $seconds);
        }

        return;
    }

    /**
     * Prepare the given value for storage.
     *
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @param  string  $key
     * @param  mixed  $value
     * @param  array  $attributes
     * @return mixed
     */
    public function set($model, string $key, $value, array $attributes)
    {
        return $value;
    }
}
