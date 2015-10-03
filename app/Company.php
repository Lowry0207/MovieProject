<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    //
    protected $table = 'company';

    public function event()
    {
        return $this->hasMany('App\Event','id','company_id');
    }
}

