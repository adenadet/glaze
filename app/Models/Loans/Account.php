<?php

namespace App\Models\Loans;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    protected $primaryKey = 'id';
    protected $table = 'loan_accounts';
    protected $fillable = array('name', 'unique_id', 'amount', 'type_id', 'user_id', 'payable', 'emi', 'duration', 'bank_id', 'acct_name', 'acct_number', 'total_paid', 'request_date', 'request_by', 'guaranteed_date', 'approved_by', 'approved_date', 'payout_by', 'payout_date', 'status', 'created_by', 'updated_by', 'created_at', 'updated_at', 'deleted_at');

    public function bank(){
        return $this->belongsTo('App\Models\Finance\AllBank', 'bank_id', 'id');
    }

    public function guarantors(){
    	return $this->hasMany('App\Models\Loans\Guarantor', 'loan_id', 'id'); 
	}
    
    public function guarantor_requests(){
    	return $this->hasMany('App\Models\Loans\GuarantorRequest', 'loan_id', 'id'); 
	}
    
    public function repayments(){
    	return $this->hasMany('App\Models\Loans\Repayment', 'loan_id', 'id'); 
	}
    
    public function type(){
        return $this->belongsTo('App\Models\Loans\Type', 'type_id', 'id');
    }

    public function matrix_level(){
        return $this->belongsTo('App\Models\Loans\ConfirmationMatrixItem', 'App\Models\Loans\ConfirmationMatrix',);
    }

    public function user(){
        return $this->belongsTo('App\Models\User', 'user_id', 'id');
    }
}
