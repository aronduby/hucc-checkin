<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Checkin extends Model
{

    /**
     * Attributes that can be mass assigned
     * @var string[]
     */
    protected $fillable = ['phone', 'in', 'out'];

    public function getDates() {
        return [
            'in',
            'out',
            'created_at',
            'updated_at',
        ];
    }

    /**
     * Has one person through the phone number
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function person() {
        return $this->hasOne('App\Models\Person', 'phone', 'phone');
    }

    public function scopeOpen($query) {
        return $query->whereNull('out');
    }
}
