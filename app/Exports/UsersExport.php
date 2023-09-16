<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\Exportable;

class UsersExport implements FromCollection, WithHeadings, ShouldAutoSize, WithMapping, WithStyles
{
    use Exportable;

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return User::all();
    }

    public function headings(): array
    {
        return [
            // '#',
            'Name',
            'Email',
            'Phone',
            'Time',

        ];
    }

    public function map($users): array
    {
        return [
            // $users->id,
            $users->name,
            $users->email,
            $users->phone,
            $users->created_at->format('d-M-Y'),
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle('A1:E1')->getFont()->setBold(true);
    }
}
