<?php

namespace App\Http\Controllers;
use App\Http\Controllers\BaseController;
use Validator;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Resources\Product as ProductResource;


class ProductController extends BaseController
{
    public function index() 
    {
        $products = Product::all();

        return $this->sendResponse(ProductResource::collection($products, "OK"));
    }

    public function store (Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input, 
        [
            "name" => "required",
            "price" => "required"
        ]);

        if($validator->fails())
        {
            // print_r("Nem jó");
            return $this->sendError($validator->errors());
        }

        $product = Product::create($input);

        return $this->sendResponse( new ProductResource($product), "Termék kiírva");
    }

    public function show ($id) 
    {
        $product = Product::find($id);

        if(is_null($product))
        {
            return $this->sendError("Nem jó");
        }
        return $this->sendResponse(new ProductResource($product), "Betöltve");
    }


    public function update(Request $request, $id)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            "name" => "required",
            "price" => "required"
        ]);

        if($validator->fails())
        {
            return $this->sendError($validator->errors());
        }

        $product = Product::find($id);
        $product->update($request->all());

        return $this->sendResponse(new ProductResource($product), "Termék frissítve");
    }

    public function destroy($id)
    {
        Product::destroy($id);

        return $this->sendResponse([], "Törölve");
    }


}
