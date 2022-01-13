<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class EmployeeController extends Controller
{
    public function index(){
        return view('employee.index');
    }
    public function fetchEmployee(){
        $data = Employee::all();
        return response()->json([
            'employee' => $data,
        ]);
    }
    public function store(Request $request){
        
        $request->validate([
            'name' => 'required|max:191',
            'phone' => 'required|max:191',
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

            $employee = new Employee();
            $employee->name = $request->name;
            $employee->phone = $request->phone;
            $employee->status = 1;
            
            if($request->hasFile('image')){

                $file = $request->file('image');
                $ext = $file->getClientOriginalExtension();
                $filename = time().'.'.$ext;
                $file->move('uploads/employee/', $filename);

                $employee->image = $filename;
            }

            try {

                $employee->save();
                return response()->json([
                    'type' => 'success',
                    'message' => 'Successsfully Employee Created !',
                ]);
            } catch (\Exception $exception) {
                return response()->json([
                    'type' => 'error',
                    'message' => $exception->getMessage(),
                ]);
            }
    }
    public function editEmployee($id){
        $employee = Employee::find($id);
        
        if($employee){
            return response()->json([
                'type' => 'success',
                'employee' => $employee,
            ]);
        }else{
            return response()->json([
                'type' => 'error',
                'message' => 'Employee Data Not Found',
            ]);
        }
    }

    public function updateEmployee(Request $request, $id){
        $request->validate([
            'name' => 'required|max:191',
            'phone' => 'required|max:191',
            // 'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

            $employee = Employee::find($id);
            $employee->name = $request->name;
            $employee->phone = $request->phone;
            
            if($request->hasFile('image')){
                $path = 'uploads/employee/'.$employee->image;
                if(File::exists($path)){
                    File::delete($path);
                }

                $file = $request->file('image');
                $ext = $file->getClientOriginalExtension();
                $filename = time().'.'.$ext;
                $file->move('uploads/employee/', $filename);

                $employee->image = $filename;
            }

            try {

                $employee->save();
                return response()->json([
                    'type' => 'success',
                    'message' => 'Employee updated successfully !',
                ]);
            } catch (\Exception $exception) {
                return response()->json([
                    'type' => 'error',
                    'message' => 'Employee not updated !',
                    // 'message' => $exception->getMessage(),
                ]);
            }
    }
    public function deleteEmployee($id){

        $employee = Employee::find($id);
        $path = 'uploads/employee/'.$employee->image;
        if(File::exists($path)){
            File::delete($path);
        }
        if($employee){
            $employee->delete();
            return response()->json([
                'type' => 'success',
                'message' => 'Employee Data Deleted Successfully',
            ]);
        }else{
            return response()->json([
                'type' => 'error',
                'message' => 'Employee Data Not Found',
            ]);
        }
    }


}