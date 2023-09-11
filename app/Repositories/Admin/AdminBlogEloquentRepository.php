<?php

namespace App\Repositories\Admin;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use App\Contracts\Admin\AdminBlogRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use App\Repositories\EloquentRepository;
use App\Constants\SettingConstant;
use App\Models\Blog;

class AdminBlogEloquentRepository extends EloquentRepository implements AdminBlogRepositoryInterface
{
    /**
     * ProductEloquentRepository constructor.
     *
     * @param Blog $model
     */
    public function __construct(Blog $model)
    {
        parent::__construct($model);
    }

    /**
     * @param array $params
     * @param array $columns
     *
     * @return LengthAwarePaginator|Collection
     */
    public function list(array $params, array $columns = ['blogs.id']): LengthAwarePaginator|Collection
    {
        return $this->model::select($columns)
            ->when(isset($params['search_title']), function ($query) use ($params) {
                return $query->where('blogs.title', 'like', '%' . $params['search_title'] . '%');
            })
            ->when(isset($params['search_status']), function ($query) use ($params) {
                return $query->where('blogs.status', $params['search_status']);
            })
            ->orderBy('blogs.id', 'DESC')
            ->orderBy('blogs.created_at', 'DESC')
            ->paginate($params['per_page'] ?? SettingConstant::DEFAULT_PAGINATE);
    }
}
