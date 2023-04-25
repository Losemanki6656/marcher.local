<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BindedCard extends Model
{
    use HasFactory;

    protected $fillable = ['id', 'user_id', 'card_id', 'pan', 'expiry', 'card_holder', 'balance', 'phone', 'card_token', 'status'];

    // protected $table = 'binded_cards';

    // protected $hidden = ['card_token','expiry','balance','card_id','user_id','status','created_at','updated_at'];

    // protected $appends = ['pan'];

   
}
