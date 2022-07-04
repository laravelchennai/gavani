<?php

namespace App\Exports\ExcelExport\FromFilteredQuery\Traits;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

/**
 * Set Property for Excel
 */
trait SetPropertyTrait
{
    /**
     * Set the File name Properties for Export
     *
     * @return array
     */
    public function properties(): array
    {
        $classBaseName = Str::of(self::class)->basename();

        return [
            'creator' => Auth::user()->name,
            'lastModifiedBy' => Auth::user()->name,
            'title' => $classBaseName,
            'description' => 'Export of ' . $classBaseName->rtrim('Export'),
            'subject' => class_basename(self::class),
            'keywords' => implode(',', ['Export', $classBaseName]),
            'category' => 'Export',
            'company' => 'Postiefs Technologies',
        ];
    }
}
