<?php

namespace App\Exports\ExcelExport\FromFilteredQuery;

use App\Exports\ExcelExport\FromFilteredQuery\Traits\SetFileNameTrait;
use App\Exports\ExcelExport\FromFilteredQuery\Traits\SetPropertyTrait;
use App\Exports\ExcelExport\FromFilteredQuery\Traits\SetQueryBuilder;
use App\Exports\ExcelExport\FromFilteredQuery\Traits\SetWriterType;
use App\Models\Monitoring\Site;
use Illuminate\Contracts\Support\Responsable;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithProperties;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class SiteExport implements FromQuery, Responsable, ShouldAutoSize, WithHeadings, WithProperties, WithStyles
{
    use Exportable;
    use SetFileNameTrait;
    use SetPropertyTrait;
    use SetQueryBuilder;
    use SetWriterType;

    public function headings(): array
    {
        return [
            'URL',
            'Friendly Name',
            'Domain Valid',
            'SSL check Enabled',
            'Domain check Enabled',
        ];
    }

    public function prepareRows($rows)
    {
        return $rows->transform(function (Site $modelInstance) {
            return [
                'url' => $modelInstance->url,
                'friendly_name' => $modelInstance->friendly_name,
                'is_domain_valid' => $modelInstance->is_domain_valid ? 'Yes' : 'No',
                'check_ssl' => $modelInstance->check_ssl ? 'Yes' : 'No',
                'check_domain' => $modelInstance->check_domain ? 'Yes' : 'No',
            ];
        });
    }

    /**
     * @return Illuminate\Database\Query\Builder
     */
    public function query()
    {
        return $this->queryBuilderInstace;
    }

    public function styles(Worksheet $sheet)
    {
        return collect(range('A', 'E'))
            ->mapWithKeys(function ($value) {
                return [
                    $value => [
                        'alignment' => [
                            'vertical' => Alignment::VERTICAL_CENTER,
                            'horizontal' => Alignment::HORIZONTAL_CENTER,
                        ],
                    ],
                ];
            })
            ->prepend([
                'font' => ['bold' => true],
                'alignment' => [
                    'vertical' => Alignment::VERTICAL_CENTER,
                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                ],
            ], 1)
            ->toArray();
    }
}
