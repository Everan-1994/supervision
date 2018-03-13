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
}
