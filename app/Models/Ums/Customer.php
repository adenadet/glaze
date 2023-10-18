<?php

namespace App\Models\Ums;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';
    protected $table = 'customers';
    protected $fillable = array('id', 'user_id', 'bvn_status', 'status', 'bvn_confirmed_by', 'bvn_confirmed_at', 'confirmation_channel', 'confirmation', 'created_by', 'updated_by', 'deleted_by', 'created_at', 'updated_at', 'deleted_at');
}
