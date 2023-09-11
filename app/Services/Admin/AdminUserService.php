<?php

namespace App\Services\Admin;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use App\Contracts\Admin\AdminUserRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Hash;
use App\Constants\DirectoryConstant;
use App\Services\UploadService;
use App\Constants\ImageSize;
use App\Models\User;

class AdminUserService
{
    public function __construct(
        private AdminUserRepositoryInterface $adminUserRepositoryInterface,
        private UploadService $uploadService
    ){}

    /**
     * @param array $params
     * @return LengthAwarePaginator|Collection
     */
    public function list(array $params): LengthAwarePaginator|Collection
    {
        $columns = [
            'users.id',
            'users.phone',
            'users.name',
            'users.email',
            'users.status',
            'users.avatar',
            'users.created_at',
        ];

        return $this->adminUserRepositoryInterface->list($params, $columns);
    }

    /**
     * Create the user
     *
     * @param $request
     * @return mixed
     */
    public function create($request)
    {
        //update avatar and resize
        if ($request->avatar) {
            $avatar = @$this->uploadService->moveImage(DirectoryConstant::IMAGE_USERS, $request->avatar);
            if ($avatar) {
                $this->uploadService->resize($avatar, ImageSize::USERS);
                $request->merge([
                    'avatar' => $avatar,
                ]);
            }
        }

        $data = array_filter([
            'name'               => $request->name,
            'status'             => $request->status,
            'phone'              => $request->phone,
            'email'              => $request->email,
            'address'            => $request->address,
            'avatar'             => $request->avatar,
            "birthday"           => $request->birthday,
            "gender"             => $request->gender,
            "password"           => bcrypt(123456),
        ]);

        return $this->adminUserRepositoryInterface->create($data);
    }

    /**
     * Update user
     *
     * @param User $user
     * @param $request
     * @return User|bool
     */
    public function update(User $user, $request)
    {
        //update avatar and resize
        if ($request->avatar) {
            $avatar = @$this->uploadService->moveImage(DirectoryConstant::IMAGE_USERS, $request->avatar);
            if ($avatar) {
                $this->uploadService->resize($avatar, ImageSize::USERS);
                $request->merge([
                    'avatar' => $avatar,
                ]);
            }
        } else {
            $request->merge([
                'avatar' => $user->avatar,
            ]);
        }

        $data = array_filter([
            'name'               => @$request->name,
            'status'             => @$request->status,
            'phone'              => @$request->phone,
            'email'              => @$request->email,
            'address'            => @$request->address,
            'avatar'             => @$request->avatar,
            "birthday"           => @$request->birthday,
            "gender"             => @$request->gender,
        ], function ($var) {
            return $var !== null;
        });

        return $this->adminUserRepositoryInterface->update($user, $data);
    }

    /**
     * Delete user
     *
     * @param User $user
     * @return bool
     */
    public function delete(User $user)
    {
        $user->update([
            'username' => $user->username . '_' . time(),
            'phone'    => $user->phone . '_' . time(),
            'email'    => $user->email . '_' . time(),
        ]);

        return $this->adminUserRepositoryInterface->delete($user);
    }

    // Change Password
    public function changePassword($user, $request)
    {
        if (Hash::check($request->old_password, $user->password)) {
            $user->password = bcrypt($request->password);
            $user->save();
            return $user;
        } else {
            return false;
        }
    }
}
