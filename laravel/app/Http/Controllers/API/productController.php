<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\products;
use Illuminate\Http\Request;
use App\Http\Resources\products as productsResource;

class productController extends baseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = products::all();
        return $this->handleResponse($products, 'Products have been retrieved!');
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
            'name' => 'required|string',
            'description'     => 'required|string|',
            'price'  => 'required|string|',
        
           
           
        ]);
        $user = products::create([
            'name'      => $attr['name'],
            'description'     => $attr['description'],
            'price'  => $attr['price'],

        ]);
       
        $response = [
            'product'     => $user->only(['name','description','price']),
           
        ];
        return response($response, 201);
             
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = products::find($id);
        if (is_null($product)) {
            return $this->handleError('Product not found!');
        }
        return $this->handleResponse(new productsResource($product), 'Product retrieved.');
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
        $product = products::find($id);
        if (is_null($product)) {
            return $this->handleError('Product not found!');
        }
        $attr = $request->validate([
            'name' => 'required|string',
            'description'     => 'required|string|',
            'price'  => 'required|string|',
        
           
           
        ]);
        $user = products::create([
            'name'      => $attr['name'],
            'description'     => $attr['description'],
            'price'  => $attr['price'],

        ]);
       
        $response = [
            'product'     => $user->only(['name','description','price']),
           
        ];
        return response($response, 201);
             
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = products::find($id);
        if (is_null($product)) {
            return $this->handleError('Product not found!');
        }
        $product->delete();
        return $this->handleResponse(null, 'Product deleted.');
    }
}
