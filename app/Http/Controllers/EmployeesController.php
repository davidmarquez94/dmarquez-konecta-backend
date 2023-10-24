<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;

class EmployeesController extends Controller
{
    public function index() {
        $employees = Employee::all();
        if(count($employees) > 0){
            return json_encode([
                'success' => true,
                'data' => $employees
            ]);
        } else {
            return json_encode([
                'success' => true,
                'message' => __('messages.employees_list_empty')
            ]);
        }
    }
}
