<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateRoleRequest;
use App\Http\Requests\UpdateRoleRequest;
use App\Models\Role;
use App\Repositories\RoleRepository;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\DB;
use Laracasts\Flash\Flash;

class RoleController extends AppBaseController
{

    /** @var  RoleRepository */
    private RoleRepository $roleRepository;

    public function __construct(RoleRepository $roleRepo)
    {
        $this->roleRepository = $roleRepo;
    }

    public function index(): View|Factory|Application
    {
        return view('roles.index');
    }

    public function create(): View|Factory|Application
    {
        $permissions = $this->roleRepository->getPermissions();

        return view('roles.create', compact('permissions'));
    }

    public function store(CreateRoleRequest $request): Redirector|RedirectResponse|Application
    {
        $input = $request->all();
        $this->roleRepository->store($input);
        Flash::success(__('messages.flash.role_create'));

        return redirect(route('roles.index'));
    }

    public function edit(Role $role): View|Factory|Application
    {
        $permissions = $this->roleRepository->getPermissions();
        $selectedPermissions = $role->getAllPermissions()->keyBy('id');

        return view('roles.edit', compact('role', 'permissions', 'selectedPermissions'));
    }

    public function update(UpdateRoleRequest $request, Role $role): Redirector|RedirectResponse|Application
    {
        $this->roleRepository->update($request->all(), $role->id);
        Flash::success(__('messages.flash.role_update'));

        return redirect(route('roles.index'));
    }

    public function destroy(Role $role): JsonResponse
    {
        if ($role->is_default == 1) {

            return $this->sendError(__('messages.flash.default_role_not_delete'));
        }

        $checkRecord = DB::table('model_has_roles')->where('role_id', '=', $role->id)->exists();
        if ($checkRecord) {
            return $this->sendError(__('messages.flash.user_role_not_delete'));
        }

        $role->delete();

        return $this->sendSuccess(__('messages.flash.role_delete'));
    }
}
