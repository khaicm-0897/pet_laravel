<div class="row form-row">
    @if (!empty($userList))
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead class="bg-primary text-white">
                <tr>
                    <th class="text-center vcshopee-bold">#</th>
                    <th class="text-center vcshopee-bold">Ảnh đại diện</th>
                    <th class="text-center vcshopee-bold">Họ tên</th>
                    <th class="text-center vcshopee-bold">Số điện thoại</th>
                    <th class="text-center vcshopee-bold">Email</th>
                    <th class="text-center vcshopee-bold">Trạng thái</th>
                    <th class="text-center vcshopee-bold">Hành động</th>
                </tr>
                </thead>
                <tbody>
                    @foreach($userList as $key => $user)
                        <tr>
                            <th class="text-center vcshopee-bold"scope="row">
                                {{ ($userList->currentPage()-1)*$userList->perPage()+$key+1 }}
                            </th>
                            <td class="text-center">
                                <a {{ getImageUrl($user->avatar) }}>
                                    <img style="height: 50px" src="{{getImage($user->avatar,
                                        \App\Constants\ImageSize::BLOG['300'])}}" alt="{{@$user->name}}">
                                </a>
                            </td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->phone }}</td>
                            <td class="text-right">{{ $user->email ? $user->email : '' }}</td>
                            <td class="text-center">
                                <div class="form-group mt-1 change-status">
                                    <input type="checkbox" data-id="{{ $user->id }}" value="{{ $user->id }}"
                                        class="switchery" data-size="sm"
                                        {{ $user && $user->status ==
                                            \App\Constants\SettingConstant::ACTIVE ? 'checked' : '' }}
                                    />
                                </div>
                            </td>
                            <td class="text-center">
                                <a class="warning mr-1" href="{{route('admin.blogs.edit', $user->id)}}">
                                    <i class="fa fa-pencil"></i>
                                </a>
                                <a class="danger delete mr-1 delete-item"
                                    data-id="{{ $user->id }}" title="Xóa bài viết này?">
                                    <i class="fa fa-trash-o"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="text-center col-12 font-weight-bold">
            Không có dữ liệu
        </div>
    @endif
</div>
<div class="tb-paginate float-md-right">
    {{ !empty($userList) ? $userList->links() : '' }}
</div>
