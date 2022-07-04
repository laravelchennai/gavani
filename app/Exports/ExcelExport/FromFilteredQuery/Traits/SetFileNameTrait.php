<?php

namespace App\Exports\ExcelExport\FromFilteredQuery\Traits;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

/**
 * Set File name for Excel
 */
trait SetFileNameTrait
{
    /**
     * Set the File Name for Export
     *
     * @param string|null $fileName
     *
     * @return $this
     */
    public function setFileName(string | null $fileName = null)
    {
        $this->fileName = $fileName ?? Str::of(self::class)
            ->classBasename()
            ->append(' - ')
            ->append('[')
            ->append(Carbon::now()->setTimezone(Auth::user()->time_zone ?? config('app.timezone'))->format('Y_m_d_H_i_s'))
            ->append(']')
            ->append('.xlsx')
            ->__toString();

        return $this;
    }
}
