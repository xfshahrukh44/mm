<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\Exportable;
use Excel;

class OrderExport implements FromArray, WithHeadings
{
    use Exportable;
    
    private $writerType = \Maatwebsite\Excel\Excel::CSV;

    protected $main_array;

    public function __construct(array $main_array)
    {
        $this->main_array = $main_array;
    }

    public function headings(): array
    {
        return [
            'ID',
            'Date Punched',
            'Dispatch Date',
            'Customer Name',
            'Phone',
            'Address',
            'Total',
            'Status',
            'Punched By',
            'Modified By'
        ];
    }

    public function array(): array
    {
        return $this->main_array;
    }
}
