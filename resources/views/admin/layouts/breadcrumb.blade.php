<div class="content-header row">
    <div class="content-header-left col-md-6 col-12 mb-2">
        <h3 class="content-header-title" style="margin-bottom: 5px;">
            {{Breadcrumbs::generate($breadcrumb)[0]->title}}
        </h3>
        <div class="row breadcrumbs-top">
            <div class="breadcrumb-wrapper col-12">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/admin">Trang chủ</a></li>
                    <li class="breadcrumb-item">
                        <a href="{{Breadcrumbs::generate($breadcrumb)[0]->url}}">
                            {{Breadcrumbs::generate($breadcrumb)[0]->title}}
                        </a>
                    </li>
                    <li class="breadcrumb-item active">{{Breadcrumbs::generate($breadcrumb)[1]->title}}</li>
                </ol>
            </div>
        </div>
    </div>

    <div class="content-header-right col-md-6 col-12">
        <div class="btn-group float-md-right mb-1" role="group" aria-label="Button group with nested dropdown">
            <div class="btn-group" role="group">
                <button class="btn btn-outline-primary dropdown-toggle dropdown-menu-right" id="btnGroupDrop1"
                type="button" data-toggle="dropdown" aria-haspopup="true"
                aria-expanded="false"><i class="ft-settings icon-left"></i> Cài đặt</button>
                <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                    <a class="dropdown-item" href="card-bootstrap.html">Giao diện</a>
                    <a class="dropdown-item" href="component-buttons-extended.html">Cấu hình</a>
                </div>
            </div>
            <a class="btn btn-outline-primary" href="full-calender-basic.html"><i class="ft-mail"></i></a>
            <a class="btn btn-outline-primary" href="javascript:void(0)">
                <i class="ft-pie-chart"></i> <span id="time" class="vcshopee-bold"></span>
            </a>
        </div>
    </div>
</div>
