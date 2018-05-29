<?php

namespace App\Http\Controllers;

use App\Http\Request;
use App\Utils\ArrayHelper;
use App\Models\Object;
use App\Models\Bargain;
use App\Models\BargainStatus;
use App\Models\Customer;


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
        $objects = Object::get();
        foreach ($bargains as $bargain) {
            $object = Object::where('id', '=', $bargain['object_id'])->first();
            $bargain['object'] = $object['address'];
            $status = BargainStatus::where('id', '=', $bargain['status_id'])->first();
            $bargain['status'] = $status['name'];
        }
        
        return view('bargains.bargainlist', ['bargains' => $bargains, 'customers' => $customers, 'objects' => $objects]);
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
        $bargain = Bargain::create($this->request->all());
        
        return redirect()->route('bargainlist')
                ->withErrors('Bargain has been created');
    }

    public function update($id) {
        $bargain = Bargain::findOrFail($id);
        $bargain = $bargain->update($this->request->all());
        
        return redirect()->route('bargainlist');
    }
    
    public function delete($id) {
        $bargain = Bargain::findOrFail($id)->delete();
        
        return redirect()->route('bargainlist')
                ->withErrors('Bargain has been deleted');
    }

}

