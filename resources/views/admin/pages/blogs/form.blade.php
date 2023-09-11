@extends('admin.layouts.main')
@section('content')
<div class="content-body">
    <section id="basic-form-layouts">
        <div class="row match-height">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="card-header p-0">
                            <h4 class="card-title">{{ Breadcrumbs::generate($breadcrumb)[1]->title }}</h4>
                        </div>
                    </div>
                    <div class="card-content collapse show">
                        <div class="card-body">
                            <form class="form-horizontal" id="form" method="POST"
                                action="{{ route(
                                    isset($blog) ? 'admin.blogs.update' : 'admin.blogs.store',
                                    isset($blog) ? $blog->id : '')
                                }}"
                                data-parsley-validate>
                                @if (isset($blog))
                                    {{ method_field('POST') }}
                                @endif
                                @csrf
                                <input type="hidden" name="id" value="{{ $blog ? $blog->id : '' }}">
                                <div class="row">
                                    <div class="col-12 col-sm-6 col-md-3 clearfix">
                                        <div class="form-group clearfix">
                                            <label class="vcshopee-bold" for="image">
                                                Ảnh {{ Breadcrumbs::generate($breadcrumb)[0]->title }}
                                            </label>
                                            <div class="d-flex justify-content-center"
                                                id="upload-image" data-width='100%' data-height='217px'>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-6 col-md-9 clearfix">
                                        <div class="row">
                                            <div class="col-12 col-sm-12 col-md-6 col-lg-4">
                                                <div class="form-group required
                                                    {{ $errors->has('title') ? 'has-error' : '' }}">
                                                    <label class="vcshopee-bold" for="title">
                                                        Tiêu đề<span class="required-field star-field">*</span>
                                                    </label>
                                                    <input type="text" class="form-control" name="title"
                                                        value="{{$blog && $blog->title ? $blog->title : old('title')}}"
                                                        required="required" data-parsley-trigger="change focusout"
                                                        data-parsley-required-message="Tiêu đề không được để trống"
                                                        placeholder="Nhập tiêu đề">
                                                    <span class="help-block">
                                                        {{ $errors->first('title', ':message') }}
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="col-12 col-sm-12 col-md-6 col-lg-4">
                                                <div class="form-group required
                                                        {{ $errors->has('status') ? 'has-error' : '' }}">
                                                    <label class="vcshopee-bold" for="status">
                                                        Trạng thái <span class="required-field star-field">*</span>
                                                    </label>
                                                    <select name="status" id="status"
                                                        class="form-control select2 status">
                                                        <option value="">Chọn</option>
                                                        @foreach (\App\Constants\BlogConstant::STATUS_TEXT
                                                            as $key => $value)
                                                            <option
                                                                {{ $blog && $blog->status == $key ? 'selected' : ''}}
                                                                value="{{$key}}">{{$value}}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    <span class="help-block">
                                                        {{ $errors->first('status', ':message') }}
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="col-12 col-sm-12 col-md-6 col-lg-4">
                                                <div class="form-group required
                                                    {{ $errors->has('publish_date') ? 'has-error' : '' }}">
                                                    <label class="vcshopee-bold" for="publish_date">
                                                        Ngày đăng <span class="required-field star-field">*</span>
                                                    </label>
                                                    <div class="input-group date" id="datetime">
                                                        <div class="input-group-append">
                                                            <span class="input-group-text">
                                                                <span class="fa fa-calendar"></span>
                                                            </span>
                                                        </div>
                                                        <input type="text" class="form-control datetimepicker blog"
                                                            required="required" data-parsley-trigger="change focusout"
                                                            data-parsley-required-message="Ngày đăng
                                                                không được để trống"
                                                            placeholder="Định dạng 2023-10-11" name="publish_date"
                                                            autocomplete="off"
                                                            value="{{isset($blog->publish_date) ?
                                                                $blog->publish_date : old('publish_date') }}">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-12 col-sm-12 col-md-6 col-lg-4">
                                                <div class="form-group required">
                                                    <label class="vcshopee-bold" for="description">Mô tả</label>
                                                    <input type="text" class="form-control" name="description"
                                                        value="{{ $blog && $blog->description
                                                            ? $blog->description : old('description') }}"
                                                        placeholder="Nhập địa chỉ chi tiết">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-actions">
                                    <button type="submit" class="btn btn-primary mr-1">
                                        <i class="fa fa-check-square-o"></i> Lưu lại
                                    </button>
                                    <a href="{{route('admin.blogs.index')}}" class="btn btn-warning">
                                        <i class="ft-x"></i> Quay lại
                                    </a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
@section('scripts')
    <script>
        $(document).ready(function () {
            uploadImage({
                elementId: 'upload-image',
                imageInit: "{!! $blog && $blog->image ? $blog->image : old('image')!!}",
                urlPost: '/admin/ajax-admin/upload-image-temp',
                paramPost: 'images',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                param: "image",
                paramInit: "{!! @old('image')!!}"
            });
        });
    </script>
@endsection
