@extends('admin.layouts.main')
@section('content')
    <div class="content-body">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">{{ Breadcrumbs::generate($breadcrumb)[0]->title }}</h4>
                        <div class="heading-elements">
                            <ul class="list-inline mb-0">
                                <button type="button" class="btn btn-warning btn-min-width"
                                    href="javscript:void(0)" onclick="getGird();">
                                    Làm mới <i class="ft-rotate-cw"></i>
                                </button>
                                <a href="{{route('admin.blogs.create')}}" style="color: white;" role="button"
                                class="">
                                    <button type="button" class="btn btn-info btn-min-width">
                                        Thêm mới<i style="margin-left: 7px" class="fa fa-pencil-square-o"></i>
                                    </button>
                                </a>
                            </ul>
                        </div>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <input type="hidden" id="getData" name="getData" data-model="Blog"
                                data-title="{{ Breadcrumbs::generate($breadcrumb)[0]->title }}" data-link="blogs">
                            <form id="formSearch" action="/admin/blogs" method="GET">
                                <div class="row">
                                    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6">
                                        <fieldset class="form-group">
                                            <label for="search_title">Tiêu đề</label>
                                            <input type="text" class="form-control"
                                                id="search_title" name="search_title" placeholder="Nhập tiêu đề">
                                        </fieldset>
                                    </div>
                                    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6">
                                        @include('admin.layouts.search_status_filter', [
                                            'typeConstant' => \App\Constants\BlogConstant::STATUS_TEXT
                                        ])
                                    </div>
                                    <div class="col-xl-2 col-lg-6 col-md-6 col-sm-6">
                                        @include('admin.layouts.per_page_filter')
                                    </div>
                                    <div class="col-xl-2 col-lg-6 col-md-6 col-sm-6 tb-btn-search">
                                        <label for="search_status" class="label_btn_search"></label>
                                        <a href="javascript:void(0)" id="btnSearch" class="btn btn-primary">
                                            Tìm kiếm <i class="fa fa-search"></i>
                                        </a>
                                    </div>
                                </div>
                            </form>
                            <div id="gird">
                                @include('admin.pages.blogs.gird', ['blogList' => $blogList])
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
