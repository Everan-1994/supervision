<?php

namespace App\Http\Controllers\Api;

use App\Models\Department;
use Illuminate\Http\Request;
use App\TransFormers\DepartmentTransformer;
use App\Http\Requests\Api\DepartmentRequest;

class DepartmentController extends Controller
{
    public function __construct()
    {
        $this->middleware('role')->only('store', 'update', 'destroy');
    }

    public function index()
    {
        return $this->response->collection(Department::all(), new DepartmentTransformer());
    }

    public function departmentList(Request $request)
    {
        $list = Department::paginate($request->pageSize, ['*'], 'page', $request->page);

        return $this->response->paginator($list, new DepartmentTransformer());
    }

    public function store(DepartmentRequest $request)
    {
        $department = Department::create([
            'department' => $request->department
        ]);

        return $this->response->item($department, new DepartmentTransformer());

    }

    public function show(Department $department)
    {
        return $this->response->item($department, new DepartmentTransformer());
    }

    public function update(DepartmentRequest $request, Department $department)
    {
        $department->update($request->all());

        return $this->response->item($department, new DepartmentTransformer());
    }

    public function destroy(Department $department)
    {
        $department->delete();

        return $this->response->noContent();
    }
}
