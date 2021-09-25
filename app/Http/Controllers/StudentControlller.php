<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use Error;
use Illuminate\Support\Facades\DB;
use Haruncpi\LaravelIdGenerator\IdGenerator;
class StudentControlller extends Controller
{
    public function create(Request $request){
        $student = new Student();
        $student->student_name = $request->student_name;
        $student->standard = $request->standard;
        $student->division = $request->division;
        $student->dob      = $request->dob;
        $student->gender   = $request->gender;
        $lastId = Student::select('student_id')->orderBy('student_id','desc')->first();
        $last=substr($lastId , 17,3);
        if($last>=9){
            $student->student_id='R-0'.$last +1;
        }
       elseif($last<9){
        $student->student_id='R-00'.$last +1;
       }
        $student->save();
        return response()->json(['success'=>'success']);
    }
    public function read(){
        $result = DB::table('students')->where('id','!=',1)->get();
        if($result) {
            return response()->json([
                'message' => "Data Found",
                "code"    => 200,
                "data"  => $result
            ]);
        } else  {
            return response()->json([
                'message' => "Internal Server Error",
                "code"    => 500
            ]);
        }
    }
    public function delete(Request $request){
        $result =DB::table('students')->where('id',$request->id)->delete();
        if($result) {
            return response()->json([
                'message' => "deleted succesfully",
                "code"    => 200,
                
            ]);
            return back()->with('success','Sucessfully Deleted');
        } 
        else  {
            return response()->json([
                'message' => "Internal Server Error",
                "code"    => 500
            ]);
        }
    }
}
