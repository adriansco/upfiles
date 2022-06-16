<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\File;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class EmployeeController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:ver-empleado|crear-empleado|editar-empleado|borrar-empleado', ['only' => ['index']]);
        $this->middleware('permission:crear-empleado', ['only' => ['create', 'store']]);
        $this->middleware('permission:editar-empleado', ['only' => ['edit', 'update']]);
        $this->middleware('permission:borrar-empleado', ['only' => ['destroy']]);
    }

    public function index()
    {
        /* $employees = Employee::where('status', 'A')->paginate(5);
        return view('employees.index', compact('employees')); */
        return view('employees.index');
    }
    public function fetchByStatus($status)
    {
        /* $employees = DB::table('employees')->where('status', $status); */
        /* tabla dinamica en js dependiendo del status :B */
        return view('employees.index', compact('status'));
    }
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'string|required|min:2|max:75',
            'payroll' => 'required|min:2|max:191',
            'status' => 'required|min:1|max:1',
        ]);
        Employee::create($request->all());
        return redirect()->route('employees.index');
    }

    public function create()
    {
        return view('employees.create');
    }

    public function update(Request $request, Employee $employee)
    {
        $this->validate($request, [
            'file' => 'file|mimes:jpg,jpeg,bmp,png,doc,docx,csv,rtf,xlsx,xls,txt,pdf,zip|max:2048',
            'name' => 'string|required|min:2|max:75',
            'payroll' => 'required|min:2|max:191',
            'status' => 'required|min:1|max:1',
        ]);

        try {
            DB::beginTransaction();
            if ($request->hasFile('file')) {
                $fileDB = new File();
                $file = $request->file('file');
                $file->move(public_path() . '/' . $employee->payroll . '/', $file->getClientOriginalName());
                $fileDB->name = 'test';
                $fileDB->path = $file->getClientOriginalName();
                $fileDB->employee_payroll = $employee->payroll;
                $fileDB->save();
                $employee->update($request->except('file'));
            } else {
                $employee->update($request->all());
            }
            DB::commit();
            return redirect()->route('employees.index');
        } catch (Exception $e) {
            DB::rollBack();
            return $e;
        }
    }
    public function destroy(Employee $employee)
    {
        $employee->delete();
        return redirect()->route('employees.index');
    }
    public function edit(Employee $employee)
    {
        return view('employees.edit', compact('employee'));
    }

    public function show(Employee $employee)
    {
        return view('employees.show', compact('employee'));
    }
}
