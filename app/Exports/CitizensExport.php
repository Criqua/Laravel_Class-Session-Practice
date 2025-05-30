<?php

namespace App\Exports;

use App\Models\Citizen;
use Maatwebsite\Excel\Concerns\{
    FromCollection, WithHeadings, ShouldAutoSize
};

class CitizensExport implements FromCollection, WithHeadings, ShouldAutoSize
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Citizen::with('city')->get()->map(function ($c) {
            return [
                'first_name' => $c->first_name,
                'last_name'  => $c->last_name,
                'birth_date' => $c->birth_date instanceof \Carbon\Carbon
                ? $c->birth_date->format('Y-m-d')
                : date('Y-m-d', strtotime($c->birth_date)),
                'city'       => $c->city->name,
                'address'    => $c->address,
                'phone'      => $c->phone,
            ];
        });
    }

    public function headings(): array
    {
        return ['First Name', 'Last Name', 'Birth Date', 'City', 'Address', 'Phone'];
    }
}
