<?php
namespace App\Http\Traits;

use Illuminate\Support\Facades\Mail;

use App\Http\Traits\LogTrait;

use App\Models\Area;
use App\Models\State;
use App\Models\Country;
use App\Models\Finance\BureauProduct;
use App\Models\Loans\Account;
use App\Models\Loans\CreditScore;
use App\Models\Ums\Notification;
use App\Models\User;

trait NotificationTrait{
    public function notification_get_by_user_id($user_id, $limit, $page){
        return Notification::where('user_id', '=', $user_id)->latest()->paginate($limit);
    }
}