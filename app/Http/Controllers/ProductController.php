<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product ;
use App\Http\Resources\ProductResource;
use Response ;

class ProductController extends Controller
{
    public $Successstatus = 200 ;
    public $FailStatus = 500 ;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data=null;
        $message='';   
        $products = Product::where('in_stock','1')->where('status','active')->paginate(20);
        if($products->count() > 0){
            $result=ProductResource::collection($products);
            $data= [
                    'total' => $result->total(),
                    'count' => $result->count(),
                    'per_page' => intval($result->perPage()),
                    'current_page' => $result->currentPage(),
                    'total_pages' => $result->lastPage(),
                    'items' =>$result,
            ];
            return Response::json(['status'=>'01','data'=>$data],$this->Successstatus);
        }

        $message = 'Not products Yet' ;
        return Response::json(['status' => '02','message'=>$message,'data'=>$data],$this->FailStatus) ;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'price' =>'required|numeric',
            'image'         => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $inputs = $request->only('category_id','name','description','price','quantity_available','in_stock','status') ;
        if($request->has('image')){
            $file=$request->image;
            $ext = $file->getClientOriginalExtension();
            $name=time().'.'.$ext;
            $file->move(public_path().'/products/',$name);
            $inputs['image']='/products/'.$name;
        }
        $product = Product::create($inputs);
        if($product)
            return response()->json(['status'=>'01','message'=>'success'],$this->Successstatus);


        return response()->json(['status'=>'02','message'=>'failed, please try again'], $this->FailStatus);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = Product::where('id',$id)->where('status','active')->first() ;
        if($product)
            return Response::json(['status'=>'01','data'=>$product],$this->Successstatus);
        else
            return response()->json(['status'=>'02','message'=>'Nothing Found'], $this->FailStatus);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $product = Product::where('id',$id)->where('status','active')->first() ;
        if($product)
            return Response::json(['status'=>'01','data'=>$product],$this->Successstatus);
        else
            return response()->json(['status'=>'02','message'=>'Nothing Found'], $this->FailStatus);
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
        $request->validate([
            'name' => 'required','price' =>'required|numeric',
            'image'         => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]) ;

        $inputs = $request->only('category_id','name','description','price','quantity_available','in_stock','status') ;
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

        if($product)
            return Response::json(['status'=>'01','message'=>'success'],$this->Successstatus);
        else
            return response()->json(['status'=>'02','message'=>'failed ,please try again'], $this->FailStatus);
        }
        return response()->json(['status'=>'02','message'=>'failed ,please try again'], $this->FailStatus);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product =Product::find($id) ;
        if($product){
            $product->delete() ;
            return Response::json(['status'=>'01','message'=>'success'],$this->Successstatus);
        }
        else
            return response()->json(['status'=>'02','message'=>'failed ,please try again'], $this->FailStatus);
    }
}
