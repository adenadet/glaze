<?php

namespace App\Models\Loans;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Guarantor extends Model
{
    protected $primaryKey = 'id';
    protected $table = 'loan_guarantors';
    protected $fillable = array('loan_id', 'name', 'relationship', 'email', 'phone', 'employer', 'employer_address', 'marital_status', 'gender', 'address', 'office_phone', 'status', 'description', 'guarantor_signature', 'guarantor_date', 'created_at', 'updated_at', 'deleted_by', 'deleted_at');
}
