<?php

namespace App\TransFormers;

use App\Models\Department;
use League\Fractal\TransformerAbstract;

class DepartmentTransformer extends TransformerAbstract
{
    public function transform(Department $department)
    {
        return [
            'id'         => $department->id,
            'department' => $department->department,
        ];
    }
}