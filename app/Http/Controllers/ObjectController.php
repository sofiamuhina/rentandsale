<?php

namespace App\Http\Controllers;

use App\Http\Request;
use App\Utils\ArrayHelper;
use App\Models\Object;
use App\Models\Owner;
use App\Models\District;
use App\Models\ObjectStatus;



class ObjectController extends Controller {

    public function __construct(Request $request) {
        parent::__construct($request);
    }

    public function get($id) {
        $object = Object::findOrFail($id);
        $statuses = ObjectStatus::get();
        $districts = District::get();
        $owners = Owner::get();
        
        $status = ObjectStatus::where('id', '=', $object['status_id'])->first();
        $object['status'] = $status['name'];
        $district = District::where('id', '=', $object['district_id'])->first();
        $object['district'] = $district['name'];
        $owner = Owner::where('id', '=', $object['owner_id'])->first();
        $object['owner'] = $owner['name'];
        //$status = OrderStatus::get()->where('id', '=', $order['status_id'])->first();
        //$order['status'] = $status['name'];
        //$user = User::get()->where('id', '=', $order['user_id'])->first();
        //$order['user'] = $user['name'];
        //$retailer = Retailer::get()->where('id', '=', $order['retailer_id'])->first();
        //$order['retailer'] = $retailer['name'];
        //$statuses = OrderStatus::get();
        
        return view('objects.object', ['object' => $object, 'statuses' => $statuses, 'districts' => $districts, 'owners' => $owners]);
    }

    public function getList() {
        $objects = Object::get();
        $districts = District::get();
        $owners = Owner::get();
        foreach ($objects as $object) {
            $owner = Owner::where('id', '=', $object['owner_id'])->first();
            $object['owner'] = $owner['name'];
            $status = ObjectStatus::where('id', '=', $object['status_id'])->first();
            $object['status'] = $status['name'];
        }
        
        return view('objects.objectlist', ['objects' => $objects, 'districts' => $districts, 'owners' => $owners]);
    }
    
    /*public function getProducts($id) {
        $order = Order::findOrFail($id);
        $order_products = OrderProduct::get()->where('order_id', '=', $order['id']);
        foreach ($order_products as $order_product) {
            $products[] = Product::get()->where('id', '=', $order_product['product_id'])->first();
        }
        foreach ($products as $product) {
            if ($product['unit_id'] > 0) {
                $unit = ProductUnit::get()->where('id', "=", $product['unit_id'])->first();
                $product['unit'] = $unit['name'];
            }
        }   
        
        return view('orders.orderproduct', ['order' => $order, 'order_products' => $order_products, 'products' => $products]);
    }*/
    

    public function create() {
        $object = Object::create($this->request->all());
        
        return redirect()->route('objectlist')
                ->withErrors('Object has been created');
    }

    public function update($id) {
        $object = Object::findOrFail($id);
        $object = $object->update($this->request->all());
        
        return redirect()->route('objectlist');
    }
    
    public function delete($id) {
        $object = Object::findOrFail($id)->delete();
        
        return redirect()->route('objectlist')
                ->withErrors('Object has been deleted');
    }

}
