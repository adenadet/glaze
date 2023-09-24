<?php

namespace App\Models\Loans;

use App\Models\Structure;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GuarantorRequest extends Structure
{
    protected $primaryKey = 'id';
    protected $table = 'loan_guarantor_requests';
    protected $fillable = array('loan_id', 'first_name', 'last_name', 'email', 'phone', 'status', 'created_by', 'updated_by', 'created_at', 'updated_at', 'deleted_by', 'deleted_at');
}
