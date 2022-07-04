<?php

namespace App\Casts\Storage;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;

class ConverMegaByteToHumanReadableCast implements CastsAttributes
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

        $bytes = $value * 1024 * 1024;

        //@link https://stackoverflow.com/a/4538054/8487424
        [$num, $alpha] = preg_split('/(?<=\d)(?=[a-z]+)/i', $this->human_filesize($bytes, 1));

        return sprintf('%g', $num) + 0 .' '.$alpha;
    }

    /**
     * Convert Mb to human file format
     *
     * @link https://gist.github.com/liunian/9338301
     *
     * @return string
     *
     * @throws conditon
     */
    public function human_filesize($bytes, $decimals = 2)
    {
        $size = ['B', 'kB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB'];
        $factor = floor((strlen($bytes) - 1) / 3);

        return sprintf("%.{$decimals}f", $bytes / pow(1024, $factor)) . @$size[$factor];
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
