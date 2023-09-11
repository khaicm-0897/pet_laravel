<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AdminUserRequest;
use Illuminate\Http\Response;
use App\Services\Admin\AdminUserService;
use Illuminate\Http\Request;
use App\Models\User;

class AdminUserController extends Controller
{
    public function __construct(
        private AdminUserService $adminUserService,
    ) {}

    /**
     * Display a listing.
     *
     * @return Response
     */
    public function index(Request $request) {
        $userList = $this->adminUserService->list($request->only([
            'search_title',
            'search_status',
            'per_page',
        ]));

        if ($request->ajax()) {
            return view('admin.pages.users.gird', compact('userList'));
        }

        $breadcrumb = 'admin-users-index';

        return view('admin.pages.users.list', compact(
            'userList', 'breadcrumb'
        ));
    }

    /**
     * Create user.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        $breadcrumb = 'admin-users-create';
        $user = null;

        return view('admin.pages.users.form', compact(
            'breadcrumb', 'user'
        ));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(AdminUserRequest $request)
    {
        if ($this->adminUserService->create($request)) {
            return redirect()->route('admin.users.index')->with(['success' => 'Thêm mới thành công']);
        } else {
            return back()->with(['error' => 'Thêm mới không thành công. Xin kiểm tra lại']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        //
        return \abort('404');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param User $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        $breadcrumb = 'admin-users-edit';

        return view('admin.pages.users.form', compact(
            'user', 'breadcrumb'
        ));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param User $user
     * @param AdminUserRequest $request
     * @return Response
     */
    public function update(User $user, AdminUserRequest $request)
    {
        if ($this->adminUserService->update($user, $request)) {
            return back()->with(['success' => 'Thông tin đã được lưu.']);
        } else {
            return back()->with(['error' => 'Lưu thông tin không thành công. Xin kiểm tra lại']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param User $user
     * @return bool
     */
    public function destroy(User $user): bool
    {
        if (!$this->adminUserService->delete($user)) {
            return false;
        }

        return true;
    }
}
