<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    public function index(){
        $products = Product::paginate(100);
        return view('products.index', compact('products'));
    }

    public function store(Request $request){
        // return 
        $request->validate([
            'name' => 'required|max:191',
            'items' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

            $employee = new Product();
            $employee->name = $request->name;
            $employee->items = $request->items;
            $employee->status = 1;
            
            if($request->hasFile('image')){

                $file = $request->file('image');
                $ext = $file->getClientOriginalExtension();
                $filename = time().'.'.$ext;
                $file->move('uploads/product/', $filename);

                $employee->image = $filename;
            }

            try {

                $employee->save();
                return response()->json([
                    'type' => 'success',
                    'message' => $request->all(),
                ]);
            } catch (\Exception $exception) {
                return response()->json([
                    'type' => 'error',
                    'message' => $exception->getMessage(),
                ]);
            }
    }

    public function editproduct($id){
        $product = Product::find($id);
        
        if($product){
            return response()->json([
                'type' => 'success',
                'product' => $product,
            ]);
        }else{
            return response()->json([
                'type' => 'error',
                'message' => 'product Data Not Found',
            ]);
        }
    }

    public function updateproduct(Request $request, $id){
        $request->validate([
            'name' => 'required|max:191',
            'items' => 'required|max:191',
            // 'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

            $product = Product::find($id);
            $product->name = $request->name;
            $product->items = $request->items;
            
            if($request->hasFile('image')){
                $path = 'uploads/product/'.$product->image;
                if(File::exists($path)){
                    File::delete($path);
                }

                $file = $request->file('image');
                $ext = $file->getClientOriginalExtension();
                $filename = time().'.'.$ext;
                $file->move('uploads/product/', $filename);

                $product->image = $filename;
            }

            try {

                $product->save();
                return response()->json([
                    'type' => 'success',
                    'message' => 'product updated successfully !',
                ]);
            } catch (\Exception $exception) {
                return response()->json([
                    'type' => 'error',
                    'message' => 'product not updated !',
                    // 'message' => $exception->getMessage(),
                ]);
            }
    }

    public function deleteproduct($id){

        $product = Product::find($id);
        $path = 'uploads/product/'.$product->image;
        if(File::exists($path)){
            File::delete($path);
        }
        if($product){
            $product->delete();
            return response()->json([
                'type' => 'success',
                'message' => 'product Data Deleted Successfully',
            ]);
        }else{
            return response()->json([
                'type' => 'error',
                'message' => 'product Data Not Found',
            ]);
        }
    }

    public function inactiveProduct($id){
        $product = Product::find($id);
        $product->status = 0;
        if($product){
            $product->save();
            return response()->json([
                'type' => 'success',
                'message' => 'Status Active Successfully',
            ]);
        }else{
            return response()->json([
                'type' => 'error',
                'message' => 'Status Not Active',
            ]);
        }
    }
    public function activeProduct($id){
        $product = Product::find($id);
        // dd($product);
        $product->status = 1;
        if($product){
            $product->save();
            return response()->json([
                'type' => 'success',
                'message' => 'Status InActive Successfully',
            ]);
        }else{
            return response()->json([
                'type' => 'error',
                'message' => 'Status Not InActive',
            ]);
        }
    }

}
