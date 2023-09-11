<script src="{{asset('/admin/js/custom-script-before.js')}}" type="text/javascript"></script>
<script src="{{asset('/admin/app-assets/vendors/js/forms/toggle/switchery.min.js')}}" type="text/javascript"></script>
<!-- BEGIN VENDOR JS-->
<script src="{{asset('/admin/app-assets/vendors/js/vendors.min.js')}}" type="text/javascript"></script>
<!-- BEGIN VENDOR JS-->
<!-- BEGIN PAGE VENDOR JS-->
{{-- <script src="{{asset('/app-assets/vendors/js/tables/datatable/datatables.min.js')}}" type="text/javascript"></script> --}}
<!-- END PAGE VENDOR JS-->
<!-- BEGIN STACK JS-->
<script src="{{asset('/admin/app-assets/js/core/app-menu.js')}}" type="text/javascript"></script>
<script src="{{asset('/admin/app-assets/js/core/app.js')}}" type="text/javascript"></script>
<script src="{{asset('/admin/app-assets/js/scripts/customizer.js')}}" type="text/javascript"></script>
<!-- END STACK JS-->
<!-- BEGIN PAGE LEVEL JS-->
{{-- <script src="{{asset('/app-assets/js/scripts/tables/datatables-extensions/datatables-sources.js')}}" type="text/javascript"></script> --}}
<script src="{{asset('/admin/js/loading-ajax.js')}}" type="text/javascript"></script>
<script src="{{asset('/admin/js/upload-image.js')}}"></script>
<script src="{{asset('/admin/js/upload-images.js')}}"></script>
<script src="{{asset('/admin/app-assets/js/scripts/extensions/parsley.js')}}"></script>
<script src="{{asset('/admin/app-assets/vendors/js/extensions/toastr.min.js')}}" type="text/javascript"></script>
<script src="{{asset('/admin/app-assets/vendors/js/extensions/sweetalert.min.js')}}" type="text/javascript"></script>
{{-- <script src="{{asset('/ckeditor/ckeditor.js')}}" type="text/javascript"></script> --}}
<!-- END CKEDITOR -->
<script src="{{asset('/admin/app-assets/js/scripts/jquery-number/jquery.number.min.js')}}" type="text/javascript"></script>
<script src="{{asset('/admin/app-assets/vendors/js/forms/icheck/icheck.min.js')}}" type="text/javascript"></script>
<script src="{{asset('/admin/app-assets/vendors/js/forms/select/select2.full.min.js')}}" type="text/javascript"></script>
<script src="{{asset('/admin/app-assets/vendors/js/pickers/dateTime/moment-with-locales.min.js')}}" type="text/javascript"></script>
<script src="{{asset('/admin/app-assets/vendors/js/pickers/dateTime/bootstrap-datetimepicker.min.js')}}" type="text/javascript"></script>

<script src="{{asset('/admin/js/custom-script-after.js')}}" type="text/javascript"></script>

<script>
    if('{{\Session::has('success')}}'){
        toastr.success('{{\Session::get('success')}}','Thành công', {"showMethod": "slideDown", "hideMethod": "slideUp", timeOut: 2000});
    }
    if('{{\Session::has('error')}}'){
        toastr.error('{{\Session::get('error')}}', 'Lỗi', {"showMethod": "slideDown", "hideMethod": "slideUp", timeOut: 2000});
    }
</script>
<!-- END PAGE LEVEL JS-->
