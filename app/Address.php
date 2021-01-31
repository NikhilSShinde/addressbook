<?php

namespace App;

use Illuminate\Database\Eloquent\Model;



class Address extends Model
{
    protected $table = 'address_book';

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'profile_pic',
        'phone',
        'street',
        'zip_code',
        'city',
        'slug',
     ];

    protected $with = ['city'];

    public function city()
    {
        return $this->hasOne(City::class, 'id', 'city');
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }
}
