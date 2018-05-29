<?php

namespace App\Http\Controllers;

use App\Http\Request;
use App\Utils\ArrayHelper;
use App\Models\Customer;
use App\Models\CustomerStatus;
use App\Models\User;

class CustomerController extends Controller {

    public function __construct(Request $request) {
        parent::__construct($request);
    }

    public function get($id) {
        $customer = Customer::findOrFail($id);
        $statuses = CustomerStatus::get();
        $users = User::get();

        $status = CustomerStatus::where('id', '=', $customer['status_id'])->first();
        $customer['status'] = $status['name'];
        $user = User::where('id', '=', $customer['user_id'])->first();
        $customer['user'] = $user['name'];
        
        return view('customers.customer', ['customer' => $customer, 'statuses' => $statuses, 'users' => $users]);
    }

    public function getList() {
        $customers = Customer::get();
        $users = User::get();
        foreach ($customers as $customer) {
            $status = CustomerStatus::where('id', '=', $customer['status_id'])->first();
            $customer['status'] = $status['name'];
        }
        
        return view('customers.customerlist', ['customers' => $customers, 'users' => $users]);
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
        $customer = Customer::create($this->request->all());
        
        return redirect()->route('customerlist')
                ->withErrors('Customer has been created');
    }

    public function update($id) {
        $customer = Customer::findOrFail($id);
        $customer = $customer->update($this->request->all());
        
        return redirect()->route('customerlist');
    }
    
    public function delete($id) {
        $customer = Customer::findOrFail($id)->delete();
        
        return redirect()->route('customerlist')
                ->withErrors('Customer has been deleted');
    }

}


