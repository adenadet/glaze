<?php

namespace App\Models\Loans;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Structure;

class GuarantorAddressVerification extends Structure
{
    use HasFactory;

    protected $primaryKey = 'id';
    protected $table = 'loan_guarantors';
    protected $fillable = array('guarantor_id', 'address_type', 'alternate_address', 'description', 'location_ease', 'met_with', 'met_with_name', 'met_with_relations', 'met_with_phone', 'remarks', 'visit_update', 'visit_date', 'visit_date_2', 'created_by', 'updated_by', 'deleted_by', 'created_at', 'updated_at', 'deleted_at');
    
}