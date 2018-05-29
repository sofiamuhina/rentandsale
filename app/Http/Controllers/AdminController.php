<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Object;
use App\Models\Bargain;
use App\Models\District;
use App\Models\Customer;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;

class AdminController extends Controller {

    public function __construct() {
        parent::__construct();
    }

    function home() {
        $objects = Object::get();
        $bargains = Bargain::where('status_id', '=', 2)->get();
        $districts = District::get();
        foreach ($districts as $district) {
            $object = 0;
            $object = Object::where('district_id', '=', $district->id)->get();
            $district['count'] = count($object);
        }
        $users = User::get();
        foreach ($users as $user) {
            $profit = 0;
            foreach ($bargains as $bargain) {
                $object = Object::where('id', '=', $bargain->object_id)->first();
                $customer = Customer::where('id', '=', $bargain->customer_id)->first();
                if (($customer->user_id) == ($user->id)) {
                    $profit = $profit + $bargain->price;
                }
            }
            $user['profit'] = $profit;
        }
        
        
        $date = strtotime("now"); 
        $objects_day = $objects_week = $objects_month = 0;
        foreach ($objects as $object) {
            if (($date - $object['created_at']) < 86400) $objects_day ++;
            if (($date - $object['created_at']) < 604800) $objects_week ++;
            if (($date - $object['created_at']) < 2592000) $objects_month ++;
        }
        $bargains_month= $bargains_year  = 0;
        foreach ($bargains as $bargain) {
            if (($date - $bargain['created_at']) < 2592000) $bargains_month ++;
            if (($date - $bargain['created_at']) < 31556926) $bargains_year ++;
        }

        
        $user = Auth::user();
        if ($user != null) {
        return view('dashboard', [
            'users' => $users,
            'districts' => $districts,
            'objects_day' => $objects_day,
            'objects_week' => $objects_week,
            'objects_month' => $objects_month,
            'bargains_month' => $bargains_month,
            'bargains_year' => $bargains_year]);
        }
        
        
        $user = Auth::user();
        if ($user != null) {
        return view('dashboard');
        }
        return redirect()->route('login');
    }
    
    public function testMessage() {
        return view('chattest');
    }

}
