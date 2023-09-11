<?php

namespace App\Contracts\Admin;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use App\Contracts\RepositoryInterface;

interface AdminBlogRepositoryInterface extends RepositoryInterface
{
    public function list(array $params, array $columns = ['blogs.id']): LengthAwarePaginator|Collection;
}
