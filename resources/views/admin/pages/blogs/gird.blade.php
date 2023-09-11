<div class="row form-row">
    @if (!empty($blogList))
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead class="bg-primary text-white">
                <tr>
                    <th class="text-center vcshopee-bold">#</th>
                    <th class="text-center vcshopee-bold">Ảnh bài viết</th>
                    <th class="text-center vcshopee-bold">Tiêu đề</th>
                    <th class="text-center vcshopee-bold">Ngày hiển thị</th>
                    <th class="text-center vcshopee-bold">Trạng thái</th>
                    <th class="text-center vcshopee-bold">Hành động</th>
                </tr>
                </thead>
                <tbody>
                    @foreach($blogList as $key => $blog)
                        <tr>
                            <th class="text-center vcshopee-bold"scope="row">
                                {{ ($blogList->currentPage()-1)*$blogList->perPage()+$key+1 }}
                            </th>
                            <td class="text-center">
                                <a {{ getImageUrl($blog->image) }}>
                                    <img style="height: 50px" src="{{getImage($blog->image,
                                        \App\Constants\ImageSize::BLOG['300'])}}" alt="{{@$blog->title}}">
                                </a>
                            </td>
                            <td>{{ $blog->title }}</td>
                            <td class="text-right">{{ $blog->publish_date ? $blog->publish_date : '' }}</td>
                            <td class="text-center">
                                <div class="form-group mt-1 change-status">
                                    <input type="checkbox" data-id="{{ $blog->id }}" value="{{ $blog->id }}"
                                        class="switchery" data-size="sm"
                                        {{ $blog && $blog->status ==
                                            \App\Constants\SettingConstant::ACTIVE ? 'checked' : '' }}
                                    />
                                </div>
                            </td>
                            <td class="text-center">
                                <a class="warning mr-1" href="{{route('admin.blogs.edit', $blog->id)}}">
                                    <i class="fa fa-pencil"></i>
                                </a>
                                <a class="danger delete mr-1 delete-item"
                                    data-id="{{ $blog->id }}" title="Xóa bài viết này?">
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
    {{ !empty($blogList) ? $blogList->links() : '' }}
</div>
