<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MedicoController extends Controller
{
    private $status     =   200;
    // --------------- [ Save Student function ] -------------
    public function createMedico(Request $request) {

        // validate inputs
        $validator          =       Validator::make($request->all(),
            [
                "first_name"        =>      "required",
                "last_name"         =>      "required",
                "email"             =>      "required|email",
                "phone"             =>      "required|numeric",
                "CRM"               =>      "required"
            ]
        );

        // if validation fails
        if($validator->fails()) {
            return response()->json(["status" => "failed", "validation_errors" => $validator->errors()]);
        }

        $student_id             =       $request->id;
         $studentArray           =       array(
            "first_name"            =>      $request->first_name,
            "last_name"             =>      $request->last_name,
            "full_name"             =>      $request->first_name . " " . $request->last_name,
            "email"                 =>      $request->email,
            "phone"                 =>      $request->phone,
            "CRM"                   =>      $request->crm
        );

        if($medico_id !="") {           
            $medico              =         Student::find($medico_id);
            if(!is_null($medico)){
                $updated_status     =       Student::where("id", $medico_id)->update($studentArray);
                if($updated_status == 1) {
                    return response()->json(["status" => $this->status, "success" => true, "message" => "medico detail updated successfully"]);
                }
                else {
                    return response()->json(["status" => "failed", "message" => "Whoops! failed to update, try again."]);
                }               
            }                   
        }

        else {
            $medico        =       Medico::create($medicoArray);
            if(!is_null($medico)) {            
                return response()->json(["status" => $this->status, "success" => true, "message" => "medico record created successfully", "data" => $student]);
            }    
            else {
                return response()->json(["status" => "failed", "success" => false, "message" => "Whoops! failed to create."]);
            }
        }        
    }

    // --------------- [ Students Listing ] -------------------
    public function medicoListing() {
        $medico       =       Medico::all();
        if(count($medico) > 0) {
            return response()->json(["status" => $this->status, "success" => true, "count" => count($medico), "data" => $medico]);
        }
        else {
            return response()->json(["status" => "failed", "success" => false, "message" => "Whoops! no record found"]);
        }
    }

    // --------------- [ Student Detail ] ----------------
    public function medicoDetail($id) {
        $medico       =       Medico::find($id);
        if(!is_null($medico)) {
            return response()->json(["status" => $this->status, "success" => true, "data" => $medico]);
        }
        else {
            return response()->json(["status" => "failed", "success" => false, "message" => "Whoops! no medico found"]);
        }
    }
//---------------- [ Delete Student ] ----------
    public function medicoDelete($id) {
        $medico        =       Medico::find($id);
        if(!is_null($medico)) {
            $delete_status      =       Medico::where("id", $id)->delete();
            if($delete_status == 1) {
                return response()->json(["status" => $this->status, "success" => true, "message" => "medico record deleted successfully"]);
            }
            else{
                return response()->json(["status" => "failed", "message" => "failed to delete, please try again"]);
            }
        }
        else {
            return response()->json(["status" => "failed", "message" => "Whoops! no medico found with this id"]);
        }
    }
}
