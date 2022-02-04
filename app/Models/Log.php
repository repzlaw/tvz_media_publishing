<?php

namespace App\Models;

use Carbon\Carbon;
use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Log extends Model
{
    use HasFactory,Uuid;
    public $incrementing = false;

    protected $keyType = 'uuid';
    protected $guarded = [];
    
}
