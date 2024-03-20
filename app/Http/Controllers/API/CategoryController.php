<?php
   
namespace App\Http\Controllers\API;
   
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\Category;

class CategoryController extends BaseController
{
   
    public function index()
    {    
        $categorys = Category::get()->toArray();
        return response()->json([
            'success' => true,
            'data' => $categorys
        ]);
    }

    public function categorieslist(Request $request)
    {
        $name = $request->input('search'); 

        $categorys = Category::with(['photo']);

        if ($name) {
            $categorys = $categorys->where('title' , 'like', '%' . $name . '%');
        }
        
        if(isset($request->limit)){
            if($request->limit != 0){
                $categorys = $categorys->limit($request->limit);    
            }
          }else{
            $categorys = $categorys->limit(5);
          }
            $categorys = $categorys->get();
    
        $founds = $categorys->map(function ($amenity) {

            return [
                "id" => $amenity->id,
                "title" => $amenity->title,
                "description" => $amenity->description,
                "status" => $amenity->status,
                "icon" => $amenity->image_url,
                'created_at' => $amenity->created_at,
                'updated_at' => $amenity->updated_at,
            ];
         });
     
         return response()->json([
            'status' => 200,
             "message" => "categorys List",
             "data" => $founds->all(),
         ]);
    }
 
}
