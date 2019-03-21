<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Payouts extends Model
{
    use SoftDeletes;
    
    protected $fillable = [
        'id', 'user_id', 'billing_system', 'purse', 'amount', 'commission', 'status', 'created_at', 'updated_at', 'deleted_at'
    ];

}