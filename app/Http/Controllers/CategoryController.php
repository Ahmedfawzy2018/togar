<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category ;
use App\Http\Resources\CategoryResource;
use Response ;
class CategoryController extends Controller
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
        $categoirs = Category::where('status','active')->paginate(20);
        if($categoirs->count() > 0){
            $result=CategoryResource::collection($categoirs);
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

        $message = 'Not Category Yet' ;
        return Response::json(['status' => '02','message'=>$message,'data'=>$data],$this->FailStatus) ;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
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
        ]);

        $category = new Category;
        $category->name = $request->get('name') ;
        $category->description = $request->get('description') ;

        if($request->get('parent_id'))
            $category->parent_id = $request->get('parent_id') ;

        if($category->save())
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
        $category = Category::where('id',$id)->where('status','active')->first() ;
        if($category)
            return Response::json(['status'=>'01','data'=>$category],$this->Successstatus);
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
        $category = Category::find($id) ;
        if($category)
            return Response::json(['status'=>'01','data'=>$category],$this->Successstatus);
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
        $request->validate(['name' => 'required']) ;

        $inputs = $request->only('name','description','parent_id','status') ;
        $category = Category::where('id',$id)->update($inputs) ;

        if($category)
            return Response::json(['status'=>'01','message'=>'success'],$this->Successstatus);
        else
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
        $category =Category::find($id) ;
        if($category){
            $category->delete() ;
            return Response::json(['status'=>'01','message'=>'success'],$this->Successstatus);
        }
        else
            return response()->json(['status'=>'02','message'=>'failed ,please try again'], $this->FailStatus);
    }
}
