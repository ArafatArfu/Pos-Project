<?php

namespace App\Http\Controllers;
use App\Helper\JWTToken;
use App\Mail\OTPMail;
use App\Models\category;
use App\Models\customer;
use App\Models\invoice;
use App\Models\product;
use App\Models\user;
use ErrorException;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redis;

class DashboardController extends Controller
{
    function DashboardPage(Request $request){
        return view('pages.dashboard.dashboard-page');
    }


    function Summary(Request $request):array{

        $user_id= $request->header('id');

        $Product= product::where('user_id',$user_id)->count();
        $Category= category::where('user_id',$user_id)->count();
        $Customer= customer::where('user_id',$user_id)->count();
        $Invoice= invoice::where('user_id',$user_id)->count();
        $total= invoice::where('user_id',$user_id)->sum('total');
        $vat= invoice::where('user_id',$user_id)->sum('vat');
        $payable= invoice::where('user_id',$user_id)->sum('payable');

        return[
            'product'=>$Product,
            'category'=>$Category,
            'customer'=>$Customer,
            'invoice'=>$Invoice,
            'total'=>round($total, precision:2),
            'vat'=>round($vat,precision:2),
            'payable'=>round($payable,precision:2)
        ];
    }


}
