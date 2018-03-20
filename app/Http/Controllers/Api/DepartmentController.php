<?php

namespace App\Http\Controllers\Api;

use App\Models\Department;
use Illuminate\Http\Request;
use App\TransFormers\DepartmentTransformer;
use App\Http\Requests\Api\DepartmentRequest;

class DepartmentController extends Controller
{
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
        $user = \Auth::guard('api')->user();

        if ($user->hasRole(['Founder'])) {
            $department->update($request->all());
            return $this->response->item($department, new DepartmentTransformer());
        }

        return $this->response->errorUnauthorized('没有权限');
    }

    public function destroy(Department $department)
    {
        $user = \Auth::guard('api')->user();

        if ($user->hasRole(['Founder'])) {
            $department->delete();
            return $this->response->noContent();
        }

        return $this->response->errorUnauthorized('没有权限');
    }
}
