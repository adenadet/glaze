<?php

namespace App\Http\Controllers\Api\Ums;

use App\Http\Controllers\Controller;
use App\Http\Traits\GeminiTrait;
use App\Http\Traits\UserTrait;
use App\Models\Area;
use App\Models\Country;
use App\Models\NextOfKin;
use App\Models\Settings\KYCItem;
use App\Models\State;
use App\Models\Ums\SocialMedia;
use App\Models\Ums\CustomerEmployer;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProfileController extends Controller
{
    use GeminiTrait, UserTrait;
    public function employees(Request $request)
    {
        $employer = CustomerEmployer::updateOrcreate(['user_id' => auth('api')->id()], 
            [
                'customer_id' => null,
                'name' => $request->input['name'],
                'employment_date' => $request->input['employment_date'] ?? null,
                'educational_level' => $request->input['educational_level'] ?? null,
                'employment_status' => $request->input['status'] ?? null,
                'employer_lga_id' => $request->input['lga_id'] ? :null,
                'landmark' => null,
                'monthly_income' => $request->input['monthly_income'] ?? null,
                'pay_day' => $request->input['pay_day'] ?? null,
                'pension_number' => $request->input['pension_number'] ?? null,
                'tax_no' => $request->input['tax_number'] ?? null,
                'employer_telephone_no' => $request->input['employer_telephone_no'] ?? null,
                'employer_sector_code' => $request->input['employer_sector_code'] ?? null,
                'staff_id' => $request->input['staff_id'] ?? null,
                'employer_address' => $request->input['employer_address'] ?? null,
                'employer_city' => $request->input['employer_city'] ?? null,
                'employer_email' => $request->input['employer_email'] ?? null,
                'status'  => $request->input['status'] ?? 1,
                'end_date' => $request->input['end_date'] ?? null,
                'created_by' => auth('api')->id(),
                'updated_by' => auth('api')->id(),
            ]
        );
    }
    
    public function index(){
        $kyc_items = KYCItem::select( 'setting_kyc_items.*',
            DB::raw('(select file from `user_kyc_items` where setting_kyc_items.id = user_kyc_items.item_id and user_kyc_items.user_id = '.auth('api')->id().' order by id asc limit 1) as kyc_file'),
            DB::raw('(select identification from `user_kyc_items` where setting_kyc_items.id = user_kyc_items.item_id and user_kyc_items.user_id = '.auth('api')->id().' order by id asc limit 1) as kyc_identification'),
            DB::raw('(select expiry_date from `user_kyc_items` where setting_kyc_items.id = user_kyc_items.item_id and user_kyc_items.user_id = '.auth('api')->id().' order by id asc limit 1) as kyc_expiry_date'),
            DB::raw('(select type from `user_kyc_items` where setting_kyc_items.id = user_kyc_items.item_id and user_kyc_items.user_id = '.auth('api')->id().' order by id asc limit 1) as kyc_type'),
        )->get();

        return response()->json([
            'areas' => Area::select('id', 'name')->orderBy('name', 'ASC')->get(),
            'employer' => CustomerEmployer::where('user_id', '=', auth('api')->id())->first(),
            'kyc_items' => $kyc_items,
            'kyc_list' => KYCItem::all(),
            'nok' => NextOfKin::where('user_id', auth('api')->id())->first(),
            'sectors' => $this->get_gemini_employer_sectors(),
            'states' => $this->get_gemini_states(),
            'socials' => SocialMedia::where('user_id', auth('api')->id())->first(),
            'user' => User::where('id', '=', auth('api')->id())->with('next_of_kin', 'customer_accounts', 'customer_address.state', 'customer_address.area', 'social_medias')->with(['area', 'state',])->first(),
        ]);
    }

    public function states($id)
    {
        return response()->json([
            'lgas' => $this->get_gemini_lgas($id),
        ]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'first_name' => 'required',
            'last_name' => 'required',
            'phone' => 'numeric',
            'sex' => 'required|string',
            'dob' => 'required|date',
            'bvn' => 'required|numeric',
        ]);

        $image_url = $currentPhoto = auth('api')->user()->image;
        //echo $currentPhoto;
         
        if (($request['image'] != $currentPhoto) && ($request['image'] != '')){
            $image = $request['id']."-".time().".".explode('/',explode(':', substr( $request['image'], 0, strpos($request['image'], ';')))[1])[1];

            \Image::make($request['image'])->save(public_path('img/profile/').$image);

            $image_url = $image;

            $old_image = public_path('img/profile/').$currentPhoto;

            if (file_exists($old_image)){ @unlink($old_image); }
        }

        if (!(is_null($request->input('id')))){
            $user = User::find($request->input('id'));
        
            $user->first_name = $request['first_name'];
            $user->middle_name = $request['middle_name'];
            $user->last_name = $request['last_name'];
            $user->phone = $request['phone'];
            $user->bvn = $request['bvn'];
            $user->bvn = $request['nin'];
            $user->sex = $request['sex'];
            $user->dob = $request['dob'];
            $user->image = $image_url;
            $user->updated_at = date('Y-m-d H:i:s');

            $user->save();
        }
        else{
            //$user = $this->create_new_user($request);
            $user = $this->create_new_user($request);
        }
        
        $nok = NextOfKin::where('user_id', '=', $user->id)->count();
        if ($nok == 0){
            //echo "No Next of Kin";
        }

        return response()->json([
            'added' => $user,
            'user' => User::where('id', auth('api')->id())->with(['customer_address','customer_accounts','state'])->first(),
            'areas' => Area::select('name', 'id')->where('state_id', 25)->get(),
            'states' => State::where('country_id', 1)->get(),
            'nok' => NextOfKin::where('user_id', auth('api')->id())->first(),
            'nations' => Country::orderBy('name', 'ASC')->get(),
        ]);
    }

    public function show($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
