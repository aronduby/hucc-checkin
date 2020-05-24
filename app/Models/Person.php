<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Person extends Model
{
    /**
     * Mass assignable
     *
     * @var string[]
     */
    protected $fillable = ['phone', 'name'];

    public function checkins() {
        return $this->hasMany('App\Models\Checkin', 'phone', 'phone');
    }

}
