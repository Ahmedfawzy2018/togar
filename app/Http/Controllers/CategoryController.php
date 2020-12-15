<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category ;
use App\Http\Resources\CategoryResource;
use Response ;
class CategoryController extends Controller
{
    
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
            return Response::json(['data'=>$data],$this->Successstatus);
        }

        $message = 'Not Category Yet' ;
        return Response::json(['message'=>$message,'data'=>$data],$this->FailStatus) ;
    }

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

        $category->save() ;
        if($category)
            return Response::json(['data'=>compact('category')],$this->Successstatus);

        return Response::json(['message'=>'failed, please try again'], $this->FailStatus);
    }

   
    public function show($id)
    {
        $category = Category::where('id',$id)->where('status','active')->first() ;
        if($category)
            return Response::json(['data'=>compact('category')],$this->Successstatus);
        else
            return Response::json(['message'=>'Nothing Found'], $this->FailStatus);

    }

    public function update(Request $request, $id)
    {
        $inputs = $request->only('name','description','parent_id','status') ;
        if(!empty($inputs)){
            $category = Category::where('id',$id)->update($inputs) ;

            if($category)
                return Response::json(['message'=>'success'],$this->Successstatus);
            else
                return Response::json(['message'=>'failed ,please try again'], $this->FailStatus);
        }else{
            return Response::json(['message'=>'Nothing to update'], $this->FailStatus);
        }
    }

   
    public function destroy($id)
    {
        $category =Category::find($id) ;
        if($category){
            $category->delete() ;
            return Response::json(['message'=>'success'],$this->Successstatus);
        }
        else
            return Response::json(['message'=>'failed ,please try again'], $this->FailStatus);
    }
}
