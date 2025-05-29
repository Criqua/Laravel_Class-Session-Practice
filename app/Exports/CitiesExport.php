<?php

namespace App\Exports;

use App\Models\City;
use Maatwebsite\Excel\Concerns\{
    FromCollection, WithHeadings, ShouldAutoSize
};

class CitiesExport implements FromCollection, WithHeadings, ShouldAutoSize
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return City::all()->map(function ($city) {
            return [
                'name'          => $city->name,
                'description'   => $city->description,
            ];
        });
    }

    public function headings(): array
    {
        return ['Name', 'Description'];
    }
}
