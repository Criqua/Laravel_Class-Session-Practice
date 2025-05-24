<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Citizen extends Model
{
    protected $fillable = [
        'first_name',
        'last_name',
        'birth_date',
        'city_id',
        'address',
        'phone',
    ];

    public function city()
    {
        return $this->belongsTo(City::class);
    }   

    public function getCity()
    {
        return $this->city ? $this->city->name : 'No asignada';
    }

    public function getFullName()
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    public function getAge()
    {
        return \Carbon\Carbon::parse($this->birth_date)->age;
    }

}
