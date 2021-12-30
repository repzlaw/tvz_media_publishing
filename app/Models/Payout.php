<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payout extends Model
{
    use HasFactory;
    protected $guarded =[];

    protected $with = ['task:id,topic','user:id,name'];

    /**
     * Get the task the website is for.
     */
    public function task()
    {
        return $this->belongsTo(Task::class);
    }

    /**
     * Get the user the website is for.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
