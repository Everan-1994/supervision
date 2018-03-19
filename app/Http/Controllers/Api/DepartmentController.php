<?php

namespace App\Http\Controllers\Api;

use App\Models\Department;
use App\TransFormers\DepartmentTransformer;

class DepartmentController extends Controller
{
    public function index()
    {
        return $this->response->collection(Department::all(), new DepartmentTransformer());
    }

    public function departmentList()
    {
        return $this->response->paginator(Department::paginate(20), new DepartmentTransformer());
    }
}
