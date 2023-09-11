<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use App\Constants\UserConstant;

class AdminUserRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            "name"     => 'required|max:150',
            "email"    => 'nullable|regex:/'.regexEmail().'/|unique:users,email',
            "status"   => 'required|in:' . @implode(",", @array_keys(@UserConstant::STATUS_TEXT)),
            "birthday" => 'required',
            "gender"   => 'required',
        ];
        if (@$this->request->get('id')) {
            $rules['phone'] = 'nullable|regex:/'.regexPhone().'/|unique:users,phone,' . @$this->request->get('id');
            $rules['username'] = 'regex:/'.regexUsername().'/|unique:users,username,' . @$this->request->get('id');
            $rules['email'] = 'nullable|regex:/'.regexEmail().'/|unique:users,email,' . @$this->request->get('id');
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'required'  => ':attribute không được để trống',
            'max'       => ':attribute không lớn hơn :max',
            'min'       => ':attribute không nhỏ hơn :min số',
            'unique'    => ':attribute đã tồn tại trong hệ thống',
            'in'        => ':attribute không thỏa mãn',
            'regex'     => ':attribute không đúng định dạng',
            'confirmed' => ':attribute không khớp',
        ];
    }

    public function attributes()
    {
        return [
            "name"        => 'Họ và Tên',
            "username"    => 'Tên đăng nhập',
            "phone"       => 'Số điện thoại',
            "email"       => 'Email',
            "status"      => 'Trạng thái',
            "address"     => 'Địa chỉ',
            "avatar"      => 'Ảnh đại diện',
            "birthday"    => 'Ngày sinh',
            "gender"      => 'Giới tính',
            "salary"      => 'Lương cơ bản',
            "position_id" => 'Chức vụ',
            "branch_id"   => 'Chi nhánh',
            "password"    => 'Mật khẩu',
        ];
    }
}
