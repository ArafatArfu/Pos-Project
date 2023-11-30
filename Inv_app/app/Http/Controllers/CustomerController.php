<?php

namespace App\Http\Controllers;

use App\Models\customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{

    function CustomerPage(Request $request){
        return view('pages.dashboard.customer-page');
    }

        //Customer create
    function CustomerCreate(Request $request){
        $user_id= $request->header('id');
        return customer::create([
            'name'=>$request->input('name'),
            'email'=>$request->input('email'),
            'mobile'=>$request->input('mobile'),
            'user_id'=>$user_id
        ]);
    }

        //Customer List
    function CustomerList(Request $request){
        $user_id= $request->header('id');
        return customer::where('user_id',$user_id)->get();
    }

        //Delete Customer
    function CustomerDelete(Request $request){
        $customer_id= $request->input('id');
        $user_id= $request->header('id');
        return customer::where('id',$customer_id)->where('user_id',$user_id)->delete();
    }

                //Customer BY ID
    function CustomerByID(Request $request){
        $customer_id= $request->input('id');
        $user_id= $request->header('id');
        return customer::where('id',$customer_id)->where('user_id',$user_id)->first();
    }

        //Update Customer
        function CustomerUpdate(Request $request){
            $customer_id=$request->input('id');
            $user_id=$request->header('id');
            return Customer::where('id',$customer_id)->where('user_id',$user_id)->update([
                'name'=>$request->input('name'),
                'email'=>$request->input('email'),
                'mobile'=>$request->input('mobile'),
            ]);
        }
}
