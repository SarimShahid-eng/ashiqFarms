<?php

namespace App\Http\Controllers\Inventory;

use App\Customer;
use App\Http\Controllers\Controller;
use App\Inventory\Employees;
use App\Inventory\Employees_type;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class EmployeesController extends Controller
{
    public function index($id = '')
    {$employees=Employees::with('type')->get();

        $employees_update = '';
        if (!empty($id)) {
            $employees_update = Employees::find($id);
        }
        $employee_types = Employees_type::all();
        // $employees = Employees::join('employees_type', 'employees.employees_type_id', '=', 'employees_type.id')
        //     ->select('*', 'employees.id as employees_id')
        //     ->get();
        // // dd($employees);
        return view('inventory.employees.index', compact('employee_types', 'employees', 'employees_update'));
    }
    public function store(Request $request)
    {
        if ($request->update_id) {
            Employees::where('id', $request->update_id)->update([
                'name' => $request->name,
                'employees_type_id' => $request->employees_type_id
            ]);
            return response([
                'success'   => 'Employee Updated successfully',
                'redirect'  =>   route('inventory.employees.index'),
            ]);
        }
        $Input = $request->all();
        Employees::create($Input);
        return response([
            'success'   => 'Employee added successfully',
            'redirect'  =>   route('inventory.employees.index'),
        ]);
    }
    public function delete($id)
    {
        Employees::destroy($id);
        return response([
            'success'   => 'Employees Deleted successfully',
            'redirect'  =>   route('inventory.employees.index'),
        ]);
    }
    //Employees Type
    public function employees_type($id = '')
    {
        $employees_upd = '';
        if (!empty($id)) {
            $employees_upd = Employees_type::find($id);
        }
        $employees = Employees::join('employees_type', 'employees.employees_type_id', '=', 'employees_type.id')
            ->select('*')
            ->get();
        $employee_types = Employees_type::all();
        return view('inventory.employees.employees_type', compact('employee_types', 'employees', 'employees_upd'));
    }
    public function employees_type_delete($id)
    {
        Employees_type::destroy($id);
        return response([
            'success'   => 'Employees Type Deleted successfully',
            'redirect'  =>   route('inventory.employees.employees_type'),
        ]);
    }
    public function type_store(Request $request)
    {

        if ($request->update_id) {
            Employees_type::where('id', $request->update_id)->update(['employees_type' => $request->employees_type]);
            return response([
                'success'   => 'Employees Type Updated successfully',
                'redirect'  =>   route('inventory.employees.employees_type'),
            ]);
        }
        $Input = $request->all();
        Employees_type::create($Input);
        return response([
            'success'   => 'Employees Type added successfully',
            'redirect'  =>   route('inventory.employees.employees_type'),
        ]);
    }
    public function employees_type_edit($id)
    {

        $employee_type_update = Employees_type::find($id);
        return view('inventory.employees.employees_type', compact('employee_type_update'));
    }
}
