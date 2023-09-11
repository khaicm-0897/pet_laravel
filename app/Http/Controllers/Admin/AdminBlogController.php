<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\AdminBlogRequest;
use App\Http\Controllers\Controller;
use App\Services\Admin\AdminBlogService;
use Illuminate\Http\Response;
use Illuminate\Http\Request;

class AdminBlogController extends Controller
{
    public function __construct(
        private AdminBlogService $adminBlogService
    ) {}

    /**
     * Display a listing.
     *
     * @return Response
     */
    public function index(Request $request) {
        $blogList = $this->adminBlogService->list($request->only([
            'search_title',
            'search_status',
            'per_page',
        ]));

        if ($request->ajax()) {
            return view('admin.pages.blogs.gird', compact('blogList'));
        }

        $breadcrumb = 'admin-blogs-index';

        return view('admin.pages.blogs.list', compact(
            'blogList', 'breadcrumb'
        ));
    }

    /**
     * Create Blog.
     *
     * @return Response
     */
    public function create() {
        $breadcrumb = 'admin-blogs-create';
        $blog = null;

        return view('admin.pages.blogs.form', compact(
            'breadcrumb', 'blog'
        ));
    }

    /**
     * Store a newly created in storage.
     *
     * @param AdminBlogRequest $request
     * @return Response
     */
    public function store(AdminBlogRequest $request)
    {
        $inputs = $request->only([
            'title',
            'user_id',
            'publish_date',
            'status',
            'description',
        ]);

        $inputs['image'] = $request->image ? $request->image : null;

        if (!$this->adminBlogService->create($inputs)) {
            return back()->with(['error' => 'Thêm mới không thành công. Xin kiểm tra lại']);
        }

        return redirect()->route('admin.blogs.index')->with(['success' => 'Thêm mới thành công']);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        return \abort('404');
    }

    /**
     * Show the form for editing the specified.
     *
     * @param int $blogId
     * @return Response
     */
    public function edit(int $blogId)
    {
        $breadcrumb = 'admin-blogs-edit';
        $blog = $this->adminBlogService->detail($blogId);

        if (!$blog) {
            return false;
        }

        return view('admin.pages.blogs.form', compact(
            'blog','breadcrumb'
        ));
    }

    /**
     * Update the specified in storage.
     *
     * @param int $blog
     * @param AdminBlogRequest $request
     * @return Response
     */
    public function update(int $blogId, AdminBlogRequest $request)
    {
        $inputs = $request->only([
            'title',
            'user_id',
            'publish_date',
            'status',
            'description',
        ]);

        $inputs['image'] = $request->image ? $request->image : null;

        if (!$this->adminBlogService->update($blogId, $inputs)) {
            return back()->with(['error' => 'Lưu thông tin không thành công. Xin kiểm tra lại']);
        }

        return back()->with(['success' => 'Thông tin đã được lưu.']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $blogId
     * @return Response
     */
    public function destroy(int $blogId)
    {
        if (!$this->adminBlogService->delete($blogId)) {
            return false;
        }

        return true;
    }
}
