<?php

namespace App\Models\Loans;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Guarantor extends Model
{
    protected $primaryKey = 'id';
    protected $table = 'loan_guarantors';
    protected $fillable = array('loan_id', 'request_id', 'bvn', 'title', 'first_name', 'middle_name', 'last_name', 'relationship', 'email', 'phone', 'employer', 'employer_address', 'employer_phone', 'employer_email', 'marital_status', 'gender', 'address', 'status', 'description', 'net_income', 'salary_range', 'guarantor_signature', 'guarantor_date', 'created_at', 'updated_at', 'deleted_by', 'deleted_at');

    public function employer_address_verification(){
        return $this->belongsTo('App\Models\Loans\GuarantorAddressVerification', 'guarantor_id', 'id');
    }
    
    public function loan(){
        return $this->belongsTo('App\Models\Loans\Account', 'loan_id', 'id');
    }

    public function residential_address_verification(){
        return $this->belongsTo('App\Models\Loans\GuarantorAddressVerification', 'guarantor_id', 'id');
    }
}
