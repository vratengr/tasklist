<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index() : View
    {
        return view('index', ['projects' => Project::all()]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) : JsonResponse
    {
        $validator = Validator::make($request->all(), ['name' => 'required|unique:projects,name']);
        $validator->setAttributeNames(['name' => 'Project Name']);

        if ($validator->fails()) {
            $response = ['error' => $validator->errors()->all()];
        } else {
            $response = Project::create(['name' => $request->name]);
        }

        return response()->json($response);
    }

    /**
     * Display the specified resource.
     */
    public function show(Project $project)
    {
        $list = $project->tasks()->orderBy('order')->get();
        Log::debug(print_r($list, true));
        return response()->json($list);
    }

    /**
     * Remove the specified resource from storage and all its linked data
     */
    public function destroy(Project $project) : void
    {
        $project->tasks()->delete();
        $project->delete();
    }
}
