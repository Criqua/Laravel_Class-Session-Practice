<?php

namespace App\Imports;

use App\Models\Citizen;
use Maatwebsite\Excel\Concerns\{
    ToModel, WithHeadingRow, WithValidation
};

class CitizensImport implements ToModel, WithHeadingRow, WithValidation
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Citizen([
            'first_name' => $row['first_name'],
            'last_name'  => $row['last_name'],
            'birth_date' => $row['birth_date'],
            'city_id'    => $row['city_id'],
            'address'    => $row['address'] ?? null,
            'phone'      => $row['phone'] ?? null,
        ]);
    }

    public function rules(): array
    {
        return [
            'first_name' => 'required|string|max:60',
            'last_name'  => 'required|string|max:60',
            'birth_date' => 'required|date|before:today',
            'city_id'    => 'required|exists:cities,id',
            'address'    => 'nullable|string|max:1000',
            'phone'      => 'nullable|string|max:15',
        ];
    }
}
