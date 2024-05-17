<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Meeting extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected 
    $fillable = [
        'user_id',
        'name',
        'status',
        'start_date',
        'end_date',
        'description',
        'attendees_user',
        'attendees_lead',
        'food_package',
        'total','ad_opts','phone'
    ];
    public static $status   = [
        'Share Agreement',
        'Waiting For Customer Confirmation',
        'Customer Confirmed / Need Admin Approval',
        'Approved',
        'Resent',
        'Withdrawn'
    ];
    public static $parent   = [
        '' => '--',
        'account' => 'Account',
        // 'lead' => 'Lead',
        'contact' => 'Contact',
        'opportunities' => 'Opportunities',
        'case' => 'Case',
    ];
    // public static  $function = [
    //     'Breakfast',
    //     'Brunch',
    //     'Lunch',
    //     'Dinner',
    //     'Wedding'
    // ];
    // public static $breakfast = [
    //     'Premium Breakfast',
    //     'Classic Brunch',
    // ];
    // public static $lunch = [
    //     'Hot Luncheon',
    //     'Cold Luncheon',
    //     'Barbecue',
    // ];
    // public static $dinner = [
    //     'Adirondack Premium Dinner',
    //     'Emerald Dinner',
    //     'Elite Dinner'
    // ];
    // public static $wedding = [
    //     'Premium Wedding',
    //     'Elite Wedding',
    //     'Plated Wedding Package'        
    // ];
   
    public function assign_user()
    {
        return $this->hasOne('App\Models\User', 'id', 'user_id');
    }

    // public function attendees_contacts()
    // {
    //     return $this->hasOne('App\Models\Contact', 'id', 'attendees_contact');
    // }
    // public function attendees_users()
    // {
    //     return $this->hasOne('App\Models\User', 'id', 'attendees_user');
    // }
    public function attendees_leads()
    {
        return $this->hasOne('App\Models\Lead', 'id', 'attendees_lead');
    }
    // public function getparent($type, $id)
    // {
    //     if($type == 'account')
    //     {
    //         $parent = Account::find($id)->name;

    //     }
    //     elseif($type == 'lead')
    //     {
    //         $parent = Lead::find($id)->name;
    //     }
    //     elseif($type == 'contact')
    //     {
    //         $parent = Contact::find($id)->name;
    //     }
    //     elseif($type == 'opportunities')
    //     {
    //         $parent = Opportunities::find($id)->name;
    //     }
    //     elseif($type == 'case')
    //     {
    //         $parent = CommonCase::find($id)->name;
    //     }else{
    //         $parent= '';
    //     }

    //     return $parent;
    // }

    public function user()
    {
    return $this->belongsTo(User::class, 'created_by');
    }
}