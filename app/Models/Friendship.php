<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Friendship extends Model
{
    protected $table = 'friendships';
    protected $fillable = ['sender_id', 'recipient_id', 'status'];

    public $timestamps = true;
}
