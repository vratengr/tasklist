<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class TaskController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) : JsonResponse
    {
        if ($errors = $this->validateRequest($request)) {
            return response()->json(['error' => $errors]);
        } else {
            $response = Task::create([
                'name'          => $request->name,
                'project_id'    => $request->project_id,
                'order'         => $request->order,
            ]);
            return response()->json($response);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Task $task) : JsonResponse
    {
        if ($errors = $this->validateRequest($request)) {
            return response()->json(['error' => $errors]);
        } else {
            return response()->json(['success' => $task->update(['name' => $request->name])]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        $task->delete();
    }

    /**
     * Update order of all tasks within the same project
     *
     * @param   Request $request
     * @return  void
     */
    public function sort(Request $request) : void
    {
        foreach ($request->tasks as $order => $task) {
            Task::where('id', $task)->update(['order' => $order]);
        }
    }

    /**
     * Validate request data
     *
     * @param   Request   $request
     * @return  array
     */
    private function validateRequest(Request $request) : array
    {
        $validator  = Validator::make($request->all(), [
            'project_id'    => 'required|exists:projects,id',
            'name'          => [
                'required',
                Rule::unique('tasks', 'name')->where('project_id', $request->project_id),
            ],
        ]);
        $validator->setAttributeNames([
            'project_id'    => 'Project',
            'name'          => 'Task Name',
        ]);

        if ($validator->fails()) {
            return $validator->errors()->all();
        } else {
            return [];
        }
    }
}
