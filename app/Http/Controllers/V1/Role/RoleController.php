<?php

namespace App\Http\Controllers\V1\Role;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\V1\Role\Role;
use App\Http\Resources\V1\Role\RoleResource;
use App\Http\Requests\V1\Role\StoreRoleRequest;
use App\Http\Requests\V1\Role\UpdateRoleRequest;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $paginator = Role::latest()->paginate(10);
        return self::paginated($paginator, RoleResource::class, 'Roles retrieved successfully', 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRoleRequest $request)
    {
        $role = Role::create($request->validated());
        return self::success(new RoleResource($role), 'Role created successfully', 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Role $role)
    {
        return self::success(new RoleResource($role), 'Role retrieved successfully', 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRoleRequest $request, Role $role)
    {
        $role->update($request->validated());
        return self::success(new RoleResource($role), 'Role updated successfully', 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $role)
    {
        $role->delete();
        return self::success(null, 'Role deleted successfully', 204);
    }
}
