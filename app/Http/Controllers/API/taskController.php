<?php
   
namespace App\Http\Controllers\API;
   
use Illuminate\Http\Request;
use App\Http\Controllers\API\baseController as BaseController;
use App\Http\Resources\Task as TaskResource;
use App\Models\Task;
use Illuminate\Auth\Access\Response;
use Illuminate\Validation\Validator as Validation;
use Validator;


class TaskController extends BaseController
{

    public function index()
    {
        $tasks = Task::all();
        return $this->handleResponse(TaskResource::collection($tasks), 'Tasks have been retrieved!');
    }

    public function store(Request $request)
    {
        $attr = $request->validate([
            'name' => 'required|string',
            'details'     => 'required|string|',
          
           
        ]);
        $task= Task::create([
            'name'      => $attr['name'],
            'details'     => $attr['details']
        ]);
        $response = [
            'task'     => $task->only(['name','details'])
            
        ];
        return response($response, 201);

        // $input = $request->all();
        // $validator = Validation::make($input, [
        //     'name' => 'required',
        //     'details' => 'required'
        // ]);
        // if($validator->fails()){
        //     return $this->handleError($validator->errors());       
        // }
        // $task = Task::create($input);
        // return $this->handleResponse(new TaskResource($task), 'Task created!');
    }

   
    public function show($id)
    {
        $task = Task::find($id);
        if (is_null($task)) {
            return $this->handleError('Task not found!');
        }
        return $this->handleResponse(new TaskResource($task), 'Task retrieved.');
    }
    

    public function update(Request $request, $id)
    {
        $task=Task::find($id);
        $task->update($request->all());
        return $task;

         
        // using obeject task
        // $input = $request->all();

        // $validator = $request->validate::make($input, [
        //     'name' => 'required',
        //     'details' => 'required'
        // ]);

        // if($validator->fails()){
        //     return $this->handleError($validator->errors());       
        // }

        // $task->name = $input['name'];
        // $task->details = $input['details'];
        // $task->save();
        
        // return $this->handleResponse(new TaskResource($task), 'Task successfully updated!');
    }
   
    public function destroy($id)
    {
        // delete with task object using (Task $task) in function
        // $task->delete();
        // return $this->handleResponse([], 'Task deleted!');

        return Task::destroy($id);
   
    
    }


/**
     * search for task name
     *
     * @param  string  $name
     * @return \Illuminate\Http\Response
     */
    /// search for task name
    public function search($name)
    {
        
        return Task::where('name','like','%'.$name.'%')->get();
       
    }
}