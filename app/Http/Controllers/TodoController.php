<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\TodoRequest;

use App\Models\Todo;

use Carbon\Carbon; 
use Validator;

class TodoController extends Controller
{
    public function store(Request $request)
    {
        $response   = [];
        $validator  = Validator::make($request->all(), TodoRequest::rules());

        if ($validator->fails()) {
            $message    = $validator->errors();
            $status     = 422;
        } else {
            $user = Auth()->user();

            $todo = new Todo();
            $todo->name         = $request->name;
            $todo->user_id      = $user->id;
            $todo->priority     = $request->priority;
            $todo->location     = $request->location;
            $todo->time_start   = Carbon::parse($request->time_start);
            $todo->save();

            return $this->getResponse(200, $todo, 'Todo berhasil ditambahkan');
        }

        return $this->getResponse($status, $response, $message);
    }
}
