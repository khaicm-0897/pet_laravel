let page = 1;
let getDataModel = $("#getData").data('model');
let getDataTitle = $("#getData").data('title');
let getDataLink  = $("#getData").data('link');

let removePreloader = function () {
    $('.preloader').css('opacity', 0);
    setTimeout(function () {
            $('.preloader').hide();
        }, 800
    );
};

$(function () {
    removePreloader();
});

let timeDisplay = document.getElementById("time");

function refreshTime() {
    let dateString = new Date().toLocaleString("vi-VI", {timeZone: "Asia/Ho_Chi_Minh"});
    let formattedString = dateString.replace(", ", " - ");
    timeDisplay.innerHTML = formattedString;
}

setInterval(refreshTime, 0);

function switchCherry() {
    let element = Array.prototype.slice.call(document.querySelectorAll('.switchery'));

    element.forEach(function(html) {
        new Switchery(html, {size : 'small', color : '#00B5B8'});
    });
}

function toastrError($text, $type, $time) {
    toastr.error($text, $type, {"showMethod": "slideDown", "hideMethod": "slideUp", timeOut: $time});
}

function toastrSuccess($text, $type, $time) {
    toastr.success($text, $type, {"showMethod": "slideDown", "hideMethod": "slideUp", timeOut: $time}).css("width","400px");
}

function ajaxDeleteObject(nameObject = 'Đối tượng', url, callback) {
    swal({
        title: "Xóa " + nameObject.toLowerCase(),
        text: "Bạn muốn xóa " + nameObject.toLowerCase() + " này?",
        icon: "warning",
        buttons: {
            cancel: {
                text: "Quay lại",
                value: null,
                visible: true,
                className: "",
                closeModal: true,
            },
            confirm: {
                text: "Đúng",
                value: true,
                visible: true,
                className: "bg-danger",
                closeModal: false
            }
        }
    }).then((isConfirm) => {
        if (isConfirm) {
            $.ajax({
                method: 'delete',
                url: url,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (res) {
                    if (res == 1) {
                        callback();
                        swal.close();
                        toastrSuccess("Đã xóa thành công!", nameObject.charAt(0).toUpperCase() + nameObject.substr(1).toLowerCase(), 2500);
                    } else {
                        swal("Lỗi!", nameObject.charAt(0).toUpperCase() + nameObject.substr(1).toLowerCase() + " chưa được xóa", "error");
                    }
                },
                error: function () {
                    swal("Lỗi!", nameObject.charAt(0).toUpperCase() + nameObject.substr(1).toLowerCase() + " chưa được xóa", "error");
                }
            })
        } else {
            $('.removeAddress').removeClass('removeAddress');
        }
    });
}

function changeStatus(url) {
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: 'get',
        url: url,
        success: function (res) {
            if (res.status == 1) {
                toastrSuccess("Đang hoạt động", "Đã chuyển trạng thái thành công", 2500);
            } else {
                toastrSuccess("Đã khóa", "Đã chuyển trạng thái thành công", 2500);
            }
        },
        error: function () {
            toastr.error('Vui lòng kiểm tra lại', 'Lỗi', {
                "showMethod": "slideDown",
                "hideMethod": "slideUp",
                timeOut: 2000
            });
        }
    });
}

$('body .required.has-error input').on('keyup', function (e) {
    $(this).parents('.required.has-error').find('span.help-block').remove();
})

$('form input').bind("keypress", function (e) {
    if (e.keyCode == 13) {
        e.preventDefault();
        return false;
    }
});

$(document).ready(function () {
    $('.select2.all').select2({
        placeholder: 'Chọn',
    });
    $('.select2.status').select2({
        placeholder: {
            id: '-1'
        },
    });
    switchCherry();
    $('.number').number(true);
    $(function () {
        $(".datetimepicker.blog").datetimepicker({
            locale: 'vi',
            format: 'YYYY-MM-DD',
            minDate: '1900-01-01',
        });
    });
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    try {
        $.fn.datetimepicker.defaults.locale = 'vi';
    } catch (error) {
        //
    }
    try {
        moment.locale('vi');
    } catch (error) {

    }
});

$('body').on('click', '.change-status', function () {
    let $elm = $(this).parent().find("input[type=checkbox]");
    let status = 0;
    let id = $elm.val();

    if ($elm.is(":checked")) {
        status = 1;
    }

    changeStatus('/admin/ajax-admin/change-status-item/' + id + '?status=' + status + '&model='+ getDataModel);
});

$(document).on('click','.pagination a', function(e){
    e.preventDefault();
    page = $(this).attr('href').split('page=')[1];
    getGird();
});

window.getGird = function()
{
    let url = '?page=' + page + '&' + $('#formSearch').serialize();
    $.ajax({
        type: "GET",
        url: url,
        success: function(res) {
            $('#gird').html(res);
            goToDivById('gird', 70);
            switchCherry();
        }
    });
}

$('#btnSearch').on('click', function () {
    page = 1;
    getGird();
});

$('#formSearch input').on('keyup', function (e) {
    if(e.keyCode == 13){
        page = 1;
        getGird();
    }
});

$('#formSearch select').on('change', function (e) {
    page = 1;
    getGird();
});

$('body').on('click', '.delete', function () {
    let id = $(this).data('id');
    ajaxDeleteObject(getDataTitle, '/admin/blogs/delete/'+ id, getGird);
});
