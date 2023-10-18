<?php

namespace App\Models\Loans;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CreditScore extends Model
{
    protected $primaryKey = 'id';
    protected $table = 'loan_account_credit_scores';
    protected $fillable = array('matrix_id', 'role_id', 'stage_number', 'created_at', 'updated_at', 'deleted_at');
}
