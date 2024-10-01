<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Http\Requests\StoreProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
use App\Http\Resources\ProjectResource;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $query = Project::query(); //means: "Start preparing a request to get data from the projects table.


        // If a 'name' parameter is passed in the request, filter projects where the name is similar.
        if (request("name")) {
            $query->where("name", "like", "%" . request("name") . "%");
        }
        // If a 'status' parameter is passed in the request, filter projects with the same status.

        if (request("status")) {
            $query->where("status", request("status"));
        }
        $projects = $query->paginate(10);


    // Return the filtered projects and query parameters to the front-end using Inertia.js
        return inertia('Project/Index', [
            "projects" => ProjectResource::collection($projects),
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
    public function store(StoreProjectRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Project $project)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Project $project)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProjectRequest $request, Project $project)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project)
    {
        //
    }
}
