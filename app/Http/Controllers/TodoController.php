<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\TodoRequest;

use App\Models\Todo;

use Carbon\Carbon; 
use Validator;

class TodoController extends Controller
{
    public function get(Request $request)
    {
        $paginate   = is_null($request->paginate) ? 10 : $request->paginate;
        $user       = Auth()->user();
        
        $priority   = $request->priority;
        $status     = $request->status;
        
        $todo = Todo::where('user_id', $user->id);
        
        if(!is_null($status)){
            if($status == 1){
                $todo = $todo->where('status', 1);
            } else if($status == 0){
                $todo = $todo->where('status', 0);
            }
        }

        if(!is_null($priority)){
            if($priority == 1){
                $todo = $todo->orderBy('priority', 'DESC');
            } else if($priority == 0){
                $todo = $todo->orderBy('priority', 'ASC');
            }
        }

        $todo = $todo->paginate((int) $paginate);
        
        return $this->getResponse(200, $todo, 'List Todo');
    }

    public function getAll(Request $request)
    {
        $paginate   = is_null($request->paginate) ? 10 : $request->paginate;
        
        $priority   = $request->priority;
        $status     = $request->status;
        $prev       = $request->prev;
        
        $todo = Todo::with('user');
        
        if(!is_null($status)){
            if($status == 1){
                $todo = $todo->where('status', 1);
            } else if($status == 0){
                $todo = $todo->where('status', 0);
            }
        }

        if(!is_null($priority)){
            if($priority == 1){
                $todo = $todo->orderBy('priority', 'DESC');
            } else if($priority == 0){
                $todo = $todo->orderBy('priority', 'ASC');
            }
        }

        if(!is_null($prev)){
            if($prev == 1){
                $todo = $todo->whereDate('time_start', '<=', Carbon::now());
            }
        }

        $todo = $todo->paginate((int) $paginate);
        
        return $this->getResponse(200, $todo, 'List Todo');
    }

    public function show(Request $request, $id)
    {
        $user = Auth()->user();

        $todo = Todo::where('user_id', $user->id)
                    ->where('id', $id)
                    ->first();

        if(is_null($todo)){
            return $this->getResponse(500, '', 'Data dengan id '.$id.' tidak ditemukan');   
        }

        return $this->getResponse(200, $todo, 'Detail Todo');
    }

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

    public function patch(Request $request, $id)
    {
        $response   = [];
        $validator  = Validator::make($request->all(), TodoRequest::rules());

        if ($validator->fails()) {
            $message    = $validator->errors();
            $status     = 422;
        } else {
            $user = Auth()->user();

            $todo = Todo::where('user_id', $user->id)
                        ->where('id', $id)
                        ->first();

            if(is_null($todo)){
                return $this->getResponse(500, '', 'Data dengan id '.$id.' tidak ditemukan');   
            }
            
            $todo->name         = $request->name;
            $todo->priority     = $request->priority;
            $todo->location     = $request->location;
            $todo->time_start   = Carbon::parse($request->time_start);
            $todo->status       = $request->status ? $request->status : 0;
            $todo->update();

            return $this->getResponse(200, $todo, 'Todo berhasil diupdate');
        }

        return $this->getResponse($status, $response, $message);   
    }

    public function destroy($id)
    {
        $user = Auth()->user();
            
        $todo = Todo::where('user_id', $id)
                     ->where('id', $id)
                     ->first();

        if(is_null($todo)){
            return $this->getResponse(500, '', 'Data dengan id '.$id.' tidak ditemukan');   
        }

        $todo->delete();

        return $this->getResponse(200, '', 'Todo berhasil didelete');
    }
}
