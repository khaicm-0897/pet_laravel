function uploadImages(option) {
    let element = $('#' + option.elementId);
    let sort = option.sort || false;
    let paramInit = option.paramInit || 'imageOld';
    let dataInit = option.dataInit || [];
    let urlPost = option.urlPost;
    let urlDelete = option.urlDelete;
    let headers = option.headers;
    let paramPost = option.paramPost;
    let param = option.param;
    if (sort) {
        element.sortable({
            items: "> div.preview",
            cursor: "move",
            opacity: 0.8,
            cancel: ".btn-delete-item-image",
        });
    }
    if (paramInit && dataInit.length) {
        dataInit.reverse();
        for (const item of dataInit) {
            element.prepend(`<div class="col-6 col-sm-4 col-md-3 col-lg-2 h-100 preview">
                            <label>
                                <img src="` + item + `" style ="width: 100%; height: 100%; position: absolute; top: 0; right: 0;"></img>
                                <input type="text" hidden name="` + paramInit + `" value="` + item + `"></input>
                                <span class="remove-image"><i class="fa fa-trash-o"></i></span>
                            </label>
                        </div>`);
        }
    }
    element.on('change', 'input', function (event) {
        let files = event.target.files;
        let hasFileNotImage = 0;
        for (let index = 0; index < files.length; index++) {
            if (fileIsImage(files[index])) {
                let form = new FormData();
                form.append(paramPost, files[index]);
                $.ajax({
                    url: urlPost,
                    type: 'POST',
                    headers: headers,
                    processData: false,
                    contentType: false,
                    cache: false,
                    timeout: 600000,
                    mimeType: "multipart/form-data",
                    data: form,
                    success: function (res) {
                        res = JSON.parse(res);
                        if (res.code == 200) {
                            element.prepend(`<div class="col-6 col-sm-4 col-md-3 col-lg-2 h-100 preview">
                            <label>
                                <img src="` + res.data.images + `" style ="width: 100%; max-height: 100%; position: absolute; top: 0; right: 0;"></img>
                                <input type="text" hidden name="` + param + `" value="` + res.data.images + `">
                                <span class="remove-image"><i class="fa fa-trash-o"></i></span>
                            </label>
                        </div>`);
                        }
                    },
                    error: function (err) {
                        console.log(err)
                    }
                })
            } else {
                hasFileNotImage = 1;
            }
        }
        if (hasFileNotImage) {
            alert('Có 1 số file không phải là ảnh sẽ không được tải lên.');
        }
        $(this).val(null);
    })

    element.on('click', '.remove-image', function () {
        $(this).parents('.preview').remove();
    })
}

function fileIsImage(file) {
    return file && file['type'].split('/')[0] === 'image';
}



