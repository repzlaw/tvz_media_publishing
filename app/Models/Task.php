<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $with = ['payout:id,status'];


    /**
     * Get the payout for the is for.
     */
    public function payout()
    {
        return $this->belongsTo(Payout::class);
    }
}
