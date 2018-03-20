<?php

Route::any('{all}', function () {
    return view('everan');
})->where(['all' => '.*']);
