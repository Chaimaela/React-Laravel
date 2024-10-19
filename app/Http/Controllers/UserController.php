<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\UserCrudResource;
use App\Http\Resources\UserResource;
use PhpParser\Node\Stmt\Else_;

use function Laravel\Prompts\password;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $query = User::query(); //means: "Start preparing a request to get data from the users table.

        $sortField = request("sort_field", "created_at"); // Default sorting column
        $sortDirection = request("sort_direction", "desc"); // Default sorting direction


        // If a 'name' parameter is passed in the request, filter users where the name is similar.
        if (request("name")) {
            $query->where("name", "like", "%" . request("name") . "%");
        }
        // If a 'email' parameter is passed in the request, filter users with the same email.

        if (request("email")) {
            $query->where("email", request("email"));
        }
        $users = $query->orderBy($sortField, $sortDirection)  // Apply sorting to the query
                            ->paginate(10);


    // Return the filtered users and query parameters to the front-end using Inertia.js
        return inertia('User/Index', [
            "users" => UserCrudResource::collection($users),
            'queryParams' => request()->query() ?: null,
            'success' => session('success')

        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return inertia("User/Create");

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request)
    
        
        {
            $data = $request->validated();
            $data['email_verified_at'] = time();
            $data['password'] = bcrypt($data['password']);
            User::create($data);
    
            return to_route('user.index')
                ->with('success', 'User was created');
        }
    

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        //
        return inertia("User/Edit",[
            "user" => new UserCrudResource($user),


        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        //
        $data = $request->validated();
        $password = $data["password"];
        if($password){
            $data['password']= bcrypt($password);
        }
        else{
            unset($data['password']);
        }
        $user -> update($data);
        return to_route('user.index')->with('success', "User was Updated successfully");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    
        {
            //
            $name = $user->name;
    
            $user->delete();
          
            return to_route('user.index')->with("success", "User \"$name\" Was Deleted successfully");
        }
    
}
