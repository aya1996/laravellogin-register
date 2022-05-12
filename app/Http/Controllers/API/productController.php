<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Http\Resources\products as productsResource;
use App\Models\Comment;
use App\Models\Product;

class productController extends baseController
{


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::all();
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
        $user = Product::create([
            'name'      => $attr['name'],
            'description'     => $attr['description'],
            'price'  => $attr['price'],

        ]);

        $response = [
            'product'     => $user->only(['name', 'description', 'price']),

        ];
        return response($response, 201);
    }

    public function createComment(Request $request)
    {

        $attr = $request->validate([
            'body' => 'required|string',
            'product_id'  => 'required|integer|exists:products,id',
        ]);
        $product = Product::find($attr['product_id']);
        if (!$product) {
            return response(['message' => 'Product not found'], 404);
        }

        $product->comments()->create([
            'body'      => $attr['body'],
            'user_id'     => auth()->user()->id,
        ]);

        return $product;
        // $comment = Comment::create([
        //     'commentable_type'  => 'App\Models\Product',
        //     'commentable_id'    => $attr['product_id'],
        //     'body'             => $attr['body'],
        //     'user_id'          => auth()->user()->id,
        // ]);
        // return $comment;
        // $comment = Comment::create([
        //     'body'      => $attr['body'],
        //     'user_id'     => $attr['user_id'],


        // ]);
        // $comment->product()->associate($attr['product_id']);
        $response = [
            // 'comment'     => $comment->only(['comment', 'user_id', 'product_id']),

        ];
        return response($response, 201);
    }

    public function getComments()
    {
        $comments = Product::with(['comments'])->get();
        return $this->handleResponse($comments, 'Comments have been retrieved!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = Product::find($id);
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
        $product = Product::find($id);
        if (is_null($product)) {
            return $this->handleError('Product not found!');
        }
        $attr = $request->validate([
            'name' => 'required|string',
            'description'     => 'required|string|',
            'price'  => 'required|string|',



        ]);
        $user = Product::create([
            'name'      => $attr['name'],
            'description'     => $attr['description'],
            'price'  => $attr['price'],

        ]);

        $response = [
            'product'     => $user->only(['name', 'description', 'price']),

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
        $product = Product::find($id);
        if (is_null($product)) {
            return $this->handleError('Product not found!');
        }
        $product->delete();
        return $this->handleResponse(null, 'Product deleted.');
    }
}
