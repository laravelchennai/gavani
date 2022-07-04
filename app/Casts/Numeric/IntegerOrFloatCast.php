<?php

namespace App\Casts\Numeric;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;

class IntegerOrFloatCast implements CastsAttributes
{
    /**
     * Cast the given value.
     *
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @param  string  $key
     * @param  mixed  $value
     * @param  array  $attributes
     *
     * @return mixed
     */
    public function get($model, string $key, $value, array $attributes)
    {
        $value = sprintf('%g', $value) + 0;
        $type = gettype($value);

        return match ($type) {
            'double' => (float) $value,
            'integer' => (int) $value,
        };
    }

    /**
     * Prepare the given value for storage.
     *
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @param  string  $key
     * @param  mixed  $value
     * @param  array  $attributes
     *
     * @return mixed
     */
    public function set($model, string $key, $value, array $attributes)
    {
        return $value;
    }
}
