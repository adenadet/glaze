<?php
namespace App\Http\Traits;

use App\Models\Loans\Account;
use App\Models\Loans\Guarantor;
use App\Models\Loans\GuarantorRequest;

use App\Models\Loans\File;
use Illuminate\Support\Facades\Mail;

trait FileTrait{
    public function file_get_loan_files_by_id($id){
        return File::where('loan_id', '=', $id)->latest()->get();
    }
    
    public function file_upload_by_type($file, $type, $location, $id){
        if($type == 'image'){
            $new_name = $id."-".time().".".explode('/',explode(':', substr( $file, 0, strpos($file, ';')))[1])[1];
            \Image::make($file)->save(public_path($location).'/'.$new_name);
            return $location.'/'.$new_name;
        }

        else if ($type == 'pdf'){
            $new_name = $id."-".time().'.pdf';
            $dent = explode("base64,", $file);
            $dustbin = base64_decode($dent[1], true);
            file_put_contents((public_path($location).'/'.$new_name), $dustbin);
            return $location.'/'.$new_name;
        }
    }

    public function file_upload_user_profile_image($file, $item_id, $location){
        if (!is_null($file)){
            $image = ((!is_null($item_id)) ? ($item_id."-") : '').time().".".explode('/',explode(':', substr($file, 0, strpos($file, ';')))[1])[1];
            \Image::make($file)->save(public_path($location.'/').$image);
            $file_url = $image;
        }
    }
}