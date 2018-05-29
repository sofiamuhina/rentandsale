<?php

namespace App\Http\Controllers;

use App\Http\Request;
use App\Utils\ArrayHelper;
use App\Models\Owner;


class OwnerController extends Controller {

    public function __construct(Request $request) {
        parent::__construct($request);
    }

    public function get($id) {
        $owner = Owner::findOrFail($id);

        
        return view('owners.owner', ['owner' => $owner]);
    }

    public function getList() {
        $owners = Owner::get();

        
        return view('owners.ownerlist', ['owners' => $owners]);
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
        $owner = Owner::create($this->request->all());
        
        return redirect()->route('ownerlist')
                ->withErrors('Owner has been created');
    }

    public function update($id) {
        $owner = Owner::findOrFail($id);
        $owner = $owner->update($this->request->all());
        
        return redirect()->route('ownerlist');
    }
    
    public function delete($id) {
        $owner = Owner::findOrFail($id)->delete();
        
        return redirect()->route('ownerlist')
                ->withErrors('Owner has been deleted');
    }

}
