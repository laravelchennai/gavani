<?php

namespace App\Exports\ExcelExport\FromFilteredQuery\Traits;

use Maatwebsite\Excel\Excel;

/**
 * Set Writer Type for Excel
 */
trait SetWriterType
{
    /**
     * Set the File Writer Type for Export
     *
     * @param string $writerType
     *
     * @return $this
     */
    public function setWriterType(string $writerType)
    {
        $this->writerType = $writerType ?? Excel::XLSX;

        return $this;
    }
}
