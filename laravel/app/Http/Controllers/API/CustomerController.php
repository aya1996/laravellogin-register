<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\customer;
use App\Http\Resources\customer as customerResource;
use Illuminate\Http\Request;  
use Illuminate\Support\Facades\Validator;
use Illuminate\Auth\Access\Response;

class CustomerController extends baseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $customers = customer::all();
        return $this->handleResponse($customers, 'Customers have been retrieved!');
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
            'email'     => 'required|string|email|unique:customers',
            'phone'  => 'required|string|unique:customers',
           
        ]);
        $user = customer::create([
            'name'      => $attr['name'],
            'email'     => $attr['email'],
            'phone'  => $attr['phone'],
        ]);
       
        $response = [
            'customer'     => $user->only(['name','email','phone']),
           
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
        $customer = customer::find($id);
        if (is_null($customer)) {
            return $this->handleError('Customer not found!');
        }
        return $this->handleResponse(new customerResource($customer), 'Customer retrieved.');
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
        $customer = customer::find($id);
        if (is_null($customer)) {
            return $this->handleError('Customer not found!');
        }
        $attr = $request->validate([
            'name' => 'required|string',
            'email'     => 'required|string|email|unique:customers,email,'.$customer->id,
            'phone'  => 'required|string|unique:customers,phone,'.$customer->id,
           
        ]);
        $customer->update([
            'name'      => $attr['name'],
            'email'     => $attr['email'],
            'phone'  => $attr['phone'],
        ]);
        $response = [
            'customer'     => $customer->only(['name','email','phone']),
           
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
        $customer = customer::find($id);
        if (is_null($customer)) {
            return $this->handleError('Customer not found!');
        }
        $customer->delete();
        return $this->handleResponse([], 'Customer deleted!');
    }
}
