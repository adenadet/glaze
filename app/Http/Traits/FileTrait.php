<?php
namespace App\Http\Traits;

use App\Models\Loans\Account;
use App\Models\Loans\Guarantor;
use App\Models\Loans\GuarantorRequest;

use App\Mail\Guarantor\ConfirmMail;
use App\Mail\Guarantor\GuaranteedMail;
use App\Mail\Guarantor\RequestMail;
use App\Mail\Guarantor\ThanksMail;
use App\Models\Country;
use App\Models\Loans\Type;

use Illuminate\Support\Facades\Mail;

trait FileTrait{
    public function file_upload_by_type($file, $type, $location, $id){
        if($type == 'image'){
            $new_name = $id."-".time().".".explode('/',explode(':', substr( $file, 0, strpos($file, ';')))[1])[1];
            \Image::make($file)->save(public_path($location).$new_name);
            return $location.'/'.$new_name;
        }

        else if ($type == 'pdf'){
            $new_name = $id."-".time().'.'.$file->getClientOriginalExtension();
            $file->move(public_path($location), $new_name);
            return $location.'/'.$new_name;
        }
    }
}