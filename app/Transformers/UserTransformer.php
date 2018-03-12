<?php

namespace App\TransFormers;

use App\Models\User;
use League\Fractal\TransformerAbstract;

class UserTransformer extends TransformerAbstract
{

    public function transform(User $user)
    {
        return [
            'id'         => $user->id,
            'name'       => $user->name,
            'email'      => $user->email,
            'sex'        => $user->sex == 1 ? '男' : '女',
            'identify'   => $user->identify == 1 ? '校内' : '校外',
            'department' => $user->department->department,
            'created_at' => $user->created_at->toDateTimeString(),
            'updated_at' => $user->updated_at->toDateTimeString(),
        ];
    }

}