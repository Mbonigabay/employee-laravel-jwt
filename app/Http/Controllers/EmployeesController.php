<?php

namespace App\Http\Controllers;

use App\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EmployeesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $employees = Employee::all();
        return response()->json($employees);
    }

    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'employeeName' => 'required',
            'nationalId' => array(
                'required',
                'regex:/^[1-3](19|20)\d{2}[7-8]\d{7}[0-9]\d{2}$/u'
            ),
            'phoneNumber' => array(
                'required',
                'regex:/^(\+?25)?(078|075|073|072)\d{7}$/u'
            ),
            'email' => 'required|email',
            'dateOfBirth' => 'required',
            'status' => 'required',
            'position' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(["message" => $validator->errors()->all()], 400);
        } else {
            $employee = Employee::create([
                'employeeName' => $request->input('employeeName'),
                'nationalId' => $request->input('nationalId'),
                'phoneNumber' => $request->input('phoneNumber'),
                'email' => $request->input('email'),
                'dateOfBirth' => $request->input('dateOfBirth'),
                'status' => $request->input('status'),
                'position' => $request->input('position'),
            ]);

            return response()->json($employee);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $employee = Employee::find($id);
        return response()->json($employee);
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
        $validator = Validator::make($request->all(), [
            'employeeName' => 'required',
            'nationalId' => 'required',
            'phoneNumber' => 'required',
            'email' => 'required',
            'dateOfBirth' => 'required',
            'status' => 'required',
            'position' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(["message" => $validator->errors()->all()], 400);
        } else {
            $employee = Employee::where("id", $id)->update([
                'employeeName' => $request->input('employeeName'),
                'nationalId' => $request->input('nationalId'),
                'phoneNumber' => $request->input('phoneNumber'),
                'email' => $request->input('email'),
                'dateOfBirth' => $request->input('dateOfBirth'),
                'status' => $request->input('status'),
                'position' => $request->input('position'),
            ]);

            return response()->json(Employee::find($id));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $employee = Employee::find($id);
        $employee->delete();
        return response()->json(["message" => "Employee record deleted"], 200);
    }

    public function activate($id)
    {
        $employee = Employee::where("id", $id)->update([
            'status' => 'activate',
        ]);

        return response()->json(Employee::find($id));
    }

    public function suspend($id)
    {
        $employee = Employee::where("id", $id)->update([
            'status' => 'suspend',
        ]);

        if($employee){
            return response()->json(Employee::find($id));
        }
        return response()->json(["message" => "Not done"], 400);
    }

    public function search(Request $request)
    {
        $keyword = $request->input('keyword');
        $employee = Employee::where('employeeName', 'like', '%' . $keyword . '%')
        ->orWhere('phoneNumber', $keyword)
        ->get();

        return response()->json($employee);
    }
}
