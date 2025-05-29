<?php

namespace App\Imports;

use App\Models\City;
use Maatwebsite\Excel\Concerns\{
    ToModel, WithHeadingRow, WithValidation, SkipsOnFailure, SkipsFailures
};

class CitiesImport implements ToModel, WithHeadingRow, WithValidation, SkipsOnFailure
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new City([
            'name' => $row['name'],
            'description' => $row['description'] ?? null,
        ]);
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:1000',
        ];
    }
}
