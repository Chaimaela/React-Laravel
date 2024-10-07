<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Http\Resources\TaskResource;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $query = Task::query(); //means: "Start preparing a request to get data from the tasks table.

        $sortField = request("sort_field", "created_at"); // Default sorting column
        $sortDirection = request("sort_direction", "desc"); // Default sorting direction


        // If a 'name' parameter is passed in the request, filter tasks where the name is similar.
        if (request("name")) {
            $query->where("name", "like", "%" . request("name") . "%");
        }
        // If a 'status' parameter is passed in the request, filter tasks with the same status.

        if (request("status")) {
            $query->where("status", request("status"));
        }
        $tasks = $query->orderBy($sortField, $sortDirection)  // Apply sorting to the query
                            ->paginate(10);


    // Return the filtered tasks and query parameters to the front-end using Inertia.js
        return inertia('Task/Index', [
            "tasks" => TaskResource::collection($tasks),
            'queryParams' => request()->query() ?: null,

        ]);

        
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTaskRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Task $task)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTaskRequest $request, Task $task)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        //
    }
}
