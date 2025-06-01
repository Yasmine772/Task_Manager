<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    // protected $fillable = [   //لادخال القيم المسموحة
    //     'user_id',
    //     'phone',
    //     'address',
    //     'date of brith',
    //     'bio'
    // ];
    protected $guarded = ['id'];



    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
