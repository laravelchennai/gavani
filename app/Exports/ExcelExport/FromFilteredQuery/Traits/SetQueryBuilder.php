<?php

namespace App\Exports\ExcelExport\FromFilteredQuery\Traits;

/**
 * Set Query Builder Instance for Excel
 */
trait SetQueryBuilder
{
    protected $queryBuilderInstace;

    /**
     * Set the Query Builder instance
     *
     * @param Illuminate\Database\Query\Builder $queryBuilderInstace
     *
     * @return $this
     */
    public function setQueryBuilder($queryBuilderInstace)
    {
        $this->setFileName();

        $this->queryBuilderInstace = $queryBuilderInstace;

        return $this;
    }
}
