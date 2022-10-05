<?php

namespace AvoRed\Framework\Database\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $guarded = ['id'];

    public $timestamps = false;
}