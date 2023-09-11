<?php

namespace App\Services\Admin;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use App\Contracts\Admin\AdminBlogRepositoryInterface;
use App\Constants\DirectoryConstant;
use Illuminate\Support\Collection;
use App\Services\UploadService;
use App\Constants\ImageSize;
use App\Models\Blog;

class AdminBlogService
{
    public function __construct(
        private AdminBlogRepositoryInterface $adminBlogRepositoryInterface,
        private UploadService $uploadService
    ) {}

    /**
     * @param array $params
     * @return LengthAwarePaginator|Collection
     */
    public function list(array $params): LengthAwarePaginator|Collection
    {
        $columns = [
            'blogs.id',
            'blogs.title',
            'blogs.image',
            'blogs.publish_date',
            'blogs.created_at',
            'blogs.status',
        ];

        return $this->adminBlogRepositoryInterface->list($params, $columns);
    }

    /**
     * @param int $blogId
     * @return Blog|null
     */
    public function detail(int $blogId): Blog|null
    {
        $columns = [
            'blogs.id',
            'blogs.title',
            'blogs.image',
            'blogs.publish_date',
            'blogs.created_at',
            'blogs.status',
        ];

        return $this->adminBlogRepositoryInterface->getById($blogId, $columns);
    }

    /**
     * Create the blog
     *
     * @param array $inputs
     * @return mixed
     */
    public function create(array $inputs)
    {
        $file = $inputs['image'];
        if ($file) {
            $image = $this->uploadService->moveImage(DirectoryConstant::IMAGE_BLOG, $file);
            if ($image) {
                $this->uploadService->resize($image, ImageSize::BLOG);

                $inputs = array_merge($inputs, [
                    'image' => $image,
                ]);
            }
        }

        $data = array_filter([
            'title' => $inputs['title'],
            'user_id' => 1,
            'publish_date' => $inputs['publish_date'],
            'status'=> $inputs['status'],
            'image'=> $inputs['image'],
            'description'=> $inputs['description'],
        ], function ($var) {
            return $var !== null;
        });

        return $this->adminBlogRepositoryInterface->create($data);
    }

    /**
     * Update Blog
     *
     * @param int $blogId
     * @param array $inputs
     * @return Blog|bool
     */
    public function update(int $blogId, array $inputs): Blog|bool
    {
        $blog = $this->adminBlogRepositoryInterface->findOrFail($blogId);

        if (!$blog) {
            return false;
        }

        $file = $inputs['image'];
        if ($file) {
            $image = $this->uploadService->moveImage(DirectoryConstant::IMAGE_BLOG, $file);
            if ($image) {
                $this->uploadService->resize($image, ImageSize::BLOG);

                $inputs = array_merge($inputs, [
                    'image' => $image,
                ]);
            }
        } else {
            $inputs = array_merge($inputs, [
                'image' => $blog->image,
            ]);
        }

        $data = array_filter([
            'title' => $inputs['title'],
            'user_id' => 1,
            'publish_date' => $inputs['publish_date'],
            'status'=> $inputs['status'],
            'image'=> $inputs['image'],
            'description'=> $inputs['description'],
        ], function ($var) {
            return $var !== null;
        });

        return $this->adminBlogRepositoryInterface->update($blogId, $data);
    }

    /**
     * Delete Blog
     *
     * @param int $blogId
     * @return bool
     */
    public function delete(int $blogId): bool
    {
        $blog = $this->adminBlogRepositoryInterface->findOrFail($blogId);

        return $blog->update([
            'title' => $blog->title . '_' . time(),
            'deleted_at' => now(),
        ]);
    }
}
