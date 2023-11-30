<?php

namespace App\Http\Controllers;

use App\Models\customer;
use App\Models\invoice;
use App\Models\invoiceProduct;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PhpParser\Node\Stmt\Catch_;
use Symfony\Component\Translation\CatalogueMetadataAwareInterface;

class InvoiceController extends Controller
{
    function InvoicePage(Request $request){
        return view('pages.dashboard.invoice-page');
    }

    function SalePage(Request $request){
        return view('pages.dashboard.sale-page');
    }

    function InvoiceCreate(Request $request){

        DB::beginTransaction();

        try{
            $user_id= $request->header('id');
            $total=   $request->input('total');
            $discount=$request->input('discount');
            $vat=     $request->input('vat');
            $payable= $request->input('payable');
            $customer_id= $request->input('customer_id');

            $invoice= invoice::create([
                'total'=>$total,
                'discount'=>$discount,
                'vat'=>$vat,
                'payable'=>$payable,
                'customer_id'=>$customer_id,
                'user_id'=>$user_id,
            ]);

            $invoiceID= $invoice->id;

            $products= $request->input('products');

            foreach($products as $EachProducts){
                invoiceProduct::create([
                    'invoice_id'=>$invoiceID,
                    'user_id'=>$user_id,
                    'product_id'=> $EachProducts['product_id'],
                    'qty'=> $EachProducts['qty'],
                    'sale_price'=> $EachProducts['sale_price'],
                ]);
            }
            DB::commit();
            return 1;
        }
        catch(Exception $e){
            DB::rollBack();
            return 0;
        }

    }

    function InvoiceSelect(Request $request){
        $user_id= $request->header('id');
        return invoice::where('user_id',$user_id)->with('customer')->get();
    }

    function InvoiceDetails(Request $request){
        $user_id= $request->header('id');
        $customerDetails= customer::where('user_id',$user_id)
        ->where('id',$request->input('cus_id'))->first();

        $invoiceTotal= invoice::where('user_id',$user_id)
        ->where('id',$request->input('inv_id'))->first();

        $invoiceProduct= invoiceProduct::where('invoice_id',$request->input('inv_id'))
        ->where('user_id',$user_id)->get();

        return array(
            'customer'=>$customerDetails,
            'invoice'=>$invoiceTotal,
            'product'=>$invoiceProduct,
        );
    }


    function InvoiceDelete(Request $request){
        DB::beginTransaction();

        try{
            $user_id= $request->header('id');
            invoiceProduct::where('invoice_id',$request->input('inv_id'))
            ->where('user_id',$user_id)->delete();

            invoice::where('id',$request->input('inv_id'))->delete();

            DB::commit();
            return 1;
        }
        catch(Exception $e){
            DB::rollBack();
            return 0;
        }

    }
}
