<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product ;
use App\Http\Resources\ProductResource;
use Response ;
use App\Models\Product_Category ;

class ProductController extends Controller
{

    public function index()
    {
        $data=null;
        $message='';   
        $products = Product::where('in_stock','1')->where('status','active')->paginate(20);
        if($products->count() > 0){
            $result=ProductResource::collection($products);
            $data= [
                    'count' => $result->count(),
                    'per_page' => intval($result->perPage()),
                    'current_page' => $result->currentPage(),
                    'total_pages' => $result->lastPage(),
                    'items' =>$result,
            ];
            return Response::json(['data'=>$data],$this->Successstatus);
        }

        $message = 'Not products Yet' ;
        return Response::json(['message'=>$message,'data'=>$data],$this->FailStatus) ;
    }

    
    public function store(Request $request)
    {
        $request->validate([
            'category_ids'=>'required|array',
            'name' => 'required',
            'price' =>'required|numeric',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $inputs = $request->only('name','description','price','quantity_available','in_stock','status') ;
        if($request->has('image')){
            $file=$request->image;
            $ext = $file->getClientOriginalExtension();
            $name=time().'.'.$ext;
            $file->move(public_path().'/products/',$name);
            $inputs['image']='/products/'.$name;
        }

        foreach ($request->category_ids as $value) {
            $inputs['category_id'] = $value ;
            $product = Product::create($inputs);

            Product_Category::create(['product_id' => $product->id,'category_id'=>$inputs['category_id']]) ;
        }
        
        if($product)
            return response()->json(['message'=>'success'],$this->Successstatus);


        return response()->json(['message'=>'failed, please try again'], $this->FailStatus);
    }

    public function show($id)
    {
        $product = Product::where('id',$id)->where('status','active')->first() ;
        if($product)
            return Response::json(['data'=>$product],$this->Successstatus);
        else
            return response()->json(['message'=>'Nothing Found'], $this->FailStatus);
    }

    public function update(Request $request, $id)
    {
       
        $inputs = $request->only('name','description','price','quantity_available','in_stock','status') ;
        if(!empty($inputs)){
            $product = Product::find($id) ;
            if($product){
                if($request->has('image')){
                    if (file_exists(public_path().$product->image))
                        unlink(public_path().$product->image);

                    $file=$request->image;
                    $ext = $file->getClientOriginalExtension();
                    $name=time().'.'.$ext;
                    $file->move(public_path().'/products/',$name);
                    $inputs['image']='/products/'.$name;
                }
                $product = Product::where('id',$id)->update($inputs) ;

                if(!empty($request->category_ids)){
                    foreach ($request->category_ids as $value) {
                        $inputs['category_id'] = $value ;
                        Product_Category::where('product_id',$product->id)->update(['category_id'=>$inputs['category_id']]) ;
                    }
                }

            if($product)
                return Response::json(['message'=>'success'],$this->Successstatus);
            else
                return response()->json(['message'=>'failed ,please try again'], $this->FailStatus);
            }
        }else{
           return response()->json(['message'=>'Nothing to update'], $this->FailStatus); 
        }
        
    }

    public function destroy($id)
    {
        $product =Product::find($id) ;
        if($product){
            Product_Category::where('product_id',$id)->delete() ;
            $product->delete() ;
            return Response::json(['message'=>'success'],$this->Successstatus);
        }
        else
            return response()->json(['message'=>'failed ,please try again'], $this->FailStatus);
    }
}
