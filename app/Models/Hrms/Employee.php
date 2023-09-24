<?php

namespace App\Models\Hrms;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;
    protected $table = 'hrms_employees';
    protected $fillable = array('user_id', 'employee_id', 'office_shift_id', 'reports_to', 'first_name', 'last_name', 'username', 'email', 'pincode', 'password', 'date_of_birth', 'gender', 'e_status', 'user_role_id', 'department_id', 'sub_department_id', 'designation_id', 'company_id', 'location_id', 'view_companies_id', 'salary_template', 'hourly_grade_id', 'monthly_grade_id', 'date_of_joining', 'date_of_leaving', 'marital_status', 'salary', 'wages_type', 'basic_salary', 'daily_wages', 'salary_ssempee', 'salary_ssempeer', 'salary_income_tax', 'salary_overtime', 'salary_commission', 'salary_claims', 'salary_paid_leave', 'salary_director_fees', 'salary_bonus', 'salary_advance_paid', 'address', 'state', 'city', 'zipcode', 'profile_picture', 'profile_background', 'resume', 'skype_id', 'contact_no', 'facebook_link', 'twitter_link', 'blogger_link', 'linkdedin_link', 'google_plus_link', 'instagram_link', 'pinterest_link', 'youtube_link', 'is_active', 'last_login_date', 'last_logout_date', 'last_login_ip', 'is_logged_in', 'online_status', 'fixed_header', 'compact_sidebar', 'boxed_wrapper', 'leave_categories', 'ethnicity_type', 'blood_group', 'nationality_id', 'citizenship_id', 'created_at');
}
