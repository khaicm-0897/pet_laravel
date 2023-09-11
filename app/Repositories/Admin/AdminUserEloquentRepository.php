<?php

namespace App\Repositories\Admin;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use App\Contracts\Admin\AdminUserRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use App\Repositories\EloquentRepository;
use App\Constants\SettingConstant;
use App\Models\User;

class AdminUserEloquentRepository extends EloquentRepository implements AdminUserRepositoryInterface
{
    /**
     * ProductEloquentRepository constructor.
     *
     * @param User $model
     */
    public function __construct(User $model)
    {
        parent::__construct($model);
    }

    /**
     * @param array $params
     * @param array $columns
     *
     * @return LengthAwarePaginator|Collection
     */
    public function list(array $params, array $columns = ['users.id']): LengthAwarePaginator|Collection
    {
        return $this->model::select($columns)
            ->when(isset($params['search_title']), function ($query) use ($params) {
                return $query->where('users.title', 'like', '%' . $params['search_title'] . '%');
            })
            ->when(isset($params['search_status']), function ($query) use ($params) {
                return $query->where('users.status', $params['search_status']);
            })
            ->orderBy('users.id', 'DESC')
            ->orderBy('users.created_at', 'DESC')
            ->paginate($params['per_page'] ?? SettingConstant::DEFAULT_PAGINATE);
    }
}
