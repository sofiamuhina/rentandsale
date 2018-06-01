<?php

namespace App\Http\Controllers;

use App\Http\Request;
use App\Utils\ArrayHelper;
use App\Models\Object;
use App\Models\Bargain;
use App\Models\BargainStatus;
use App\Models\Customer;
use Illuminate\Support\Facades\DB;

class BargainController extends Controller {

    public function __construct(Request $request) {
        parent::__construct($request);
    }

    public function get($id) {
        $bargain = Bargain::findOrFail($id);
        $statuses = BargainStatus::get();
        
        $object = Object::where('id', '=', $bargain['object_id'])->first();
        $bargain['object'] = $object['address'];
        $customer = Customer::where('id', '=', $bargain['customer_id'])->first();
        $bargain['customer'] = $customer['name'];
        $status = BargainStatus::where('id', '=', $bargain['status_id'])->first();
        $bargain['status'] = $status['name'];
        
        return view('bargains.bargain', ['bargain' => $bargain, 'statuses' => $statuses]);
    }

    public function getList() {
        $bargains = Bargain::get();
        $customers = Customer::get();
        $objects = Object::where('status_id', '=', 1)->get();
        foreach ($bargains as $bargain) {
            $object = Object::where('id', '=', $bargain['object_id'])->first();
            $bargain['object'] = $object['address'];
            $status = BargainStatus::where('id', '=', $bargain['status_id'])->first();
            $bargain['status'] = $status['name'];
        }
        
        return view('bargains.bargainlist', ['bargains' => $bargains, 'customers' => $customers, 'objects' => $objects]);
    }
    

    public function create() {
        $object = Object::findOrFail($this->request->object_id);
        $customer = Customer::findOrFail($this->request->customer_id);
        
        $trans = DB::transaction(function() use ( $object, $customer) {
            $bargain = Bargain::create($this->request->all());
            $bargain = $bargain->update(['price' => $object->price]);
            $object = $object->update(['status_id' => 2]);
            $customer = $customer->update(['status_id' => 2]);
        });
        
        return redirect()->route('bargainlist')
                ->withErrors('Bargain has been created');
    }

    public function update($id) {
        $bargain = Bargain::findOrFail($id);
        $object = Object::findOrFail($bargain->object_id);
        $customer = Customer::findOrFail($bargain->customer_id);

        $trans = DB::transaction(function() use ( $bargain, $object, $customer) {
            if (($this->request->status_id) == 2) {
                $object = $object->update(['status_id' => 3]);
                $customer = $customer->update(['status_id' => 3]);
            }
            if (($this->request->status_id) == 3) {
                $object = $object->update(['status_id' => 1]);
                $customer = $customer->update(['status_id' => 1]);
            }
            $bargain = $bargain->update($this->request->all());
        });
        
        
        
        return redirect()->route('bargainlist');
    }
    
    public function delete($id) {
        $bargain = Bargain::findOrFail($id)->delete();
        
        return redirect()->route('bargainlist')
                ->withErrors('Bargain has been deleted');
    }

}

