<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\invoice;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\API\baseController as BaseController;

class invoiceController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $invoice = invoice::all();
        return $this->handleResponse($invoice, 'Invoices have been retrieved!');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $attr = $request->validate([
            'tax'        => 'required|present|numeric',
            'products'   => 'required|array|min:1|exists:products,id',
            'status'     => 'required|in:0,1',
            'customer_id'=> 'required|exists:customers,id',
        ]);
        // return $request->all();
       $products = Product::whereIn('id', $attr['products'])->get();
    //    return $products;
       $total = 0;
       $discount = 0;
       foreach($products as $product){
              $total += $product->price;
           
              
       }
       $tax = ($total * $attr['tax']) / 100;
       if($products->count() >= 5){
          //  $discount += $product->price * $product->count() - $product->price;
           $discount = ($total * 10) / 100;
           $sub_total=$total -$discount + $tax;
          
       }
       else{
          $sub_total=$total + $tax;
       }
 
       
       
     
       
    //    return $tax;
    //    return $total;
    //    return $products;
    //    return $attr['products'];
        $invoice = invoice::create([
            'invoice_number'      => mt_rand(1111,9999999),//$attr['invoice_number'],
            'total_amount'        => $total,//$attr['total_amount'],
            'tax'                 => $attr['tax'],
            'discount'            => $discount,
            'sub_total'           => $sub_total,//$attr['total_amount'],  
            'status'              => $attr['status'],
            'invoiceDate'         => date('Y-m-d'),
            'customer_id'         => $attr['customer_id'],
            // 'created_at'  => $attr['created_at'],
        ]);

         $invoice->products()->attach($attr['products']);
         return $invoice;
        //  $response = [
        //     'invoice'     => $invoice->only(['invoice_number','total_amount','sub_total','status','created_at']),
           
        // ];
        // return response($response, 201);
             
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $invoice = invoice::find($id);
        return $this->handleResponse($invoice, 'Invoice has been retrieved!'); 
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
       
        $attr = $request->validate([
            'tax'        => 'required|present|numeric',
            'products'   => 'required|array|min:1|exists:products,id',
            'status'     => 'required|in:0,1',
            'customer_id'=> 'required|exists:customers,id',
        ]);
        $invoice = invoice::find($id);
        $invoice->update($attr);
        $invoice->products()->sync($attr['products']);
        return $invoice;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $invoice = invoice::find($id);
        if (is_null($invoice)) {
            return $this->handleError('Invoice not found!');
        }
        $invoice->delete();
        return $this->handleResponse($invoice, 'Invoice has been deleted!');
    }
    public function test($id){
        $invoice = invoice::with(['products'])->find($id);
        return $invoice;
    }
    public function invoiceDetails($id){
        $invoice = invoice::with(['products:id,name,price','customer:id,name,phone'])->find($id);

        return $invoice;
    }
}
