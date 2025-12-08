<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\UserDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ResetPasswordRequest;
use App\Http\Requests\Admin\UserStoreRequest;
use App\Http\Requests\Admin\UserUpdateRequest;
use App\Models\User;
use App\Services\Admin\RoleService;
use App\Services\Admin\UserService;
use Illuminate\Http\Request;

class UserController extends Controller
{
    protected $service;

    public function __construct(UserService $service, RoleService $roleService)
    {
        $this->service = $service;
        $this->roleService = $roleService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(UserDataTable $dataTable)
    {
        return $dataTable->render('admin.users.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = $this->roleService->list();
        return view('admin.users.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserStoreRequest $request)
    {
        $this->service->create($request->validated());

        return redirect()->route('admin.users.index')->with('success', 'User created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        $roles = $this->roleService->list();
        return view('admin.users.edit', compact('roles','user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserUpdateRequest $request, User $user)
    {
        $this->service->update($user, $request->validated());
        return redirect()->route('admin.users.index')->with('success', 'User updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $this->service->delete($user);
        return redirect()->route('admin.users.index')->with('success', 'User deleted successfully.');
    }

    
    public function resetPassword(User $user)
    {
        return view('admin.users.reset-password',compact('user'));
    }

    public function updatePassword(User $user,ResetPasswordRequest $request)
    {
        $this->service->resetPassword($user,$request->validated());
        return redirect()->route('admin.users.index')->with('success', 'Password updated successfully');
    }
}
