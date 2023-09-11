function uploadImage(option) {
    let element = $("#" + option.elementId);
    let imageInit = option.imageInit || null;
    let urlPost = option.urlPost;
    let paramPost = option.paramPost;
    let param = option.param;
    let paramInit = option.paramInit;
    let urlDelete = option.urlDelete;
    let headers = option.headers;
    if (imageInit) {
        element.html(`<div class="preview" style ="width: ` + element.data('width') + `; height: ` + element.data('height') + `">
                        <label>
                            <img class="image_upload_form" src="` + imageInit + `" style ="width: ` + element.data('width') + `; height: ` + element.data('height') + `; top: 0; right: 0;object-fit: contain;">
                            <input class="file" type="file" accept="image/*"hidden></input>
                        </label>
                        <input type="text" hidden name="` + param + `" value="` + paramInit + `"></input>
                    </div>`);
    } else {
        element.html(`<div class="input-upload-image" style="width: ` + element.data('width') + `; height: ` + element.data('height') + `">
                        <label for="file"><span>+</span></label>
                        <input class="file" type="file" id="file" accept="image/*" />
                        <input type="text" hidden name="` + param + `" value="` + paramInit + `"></input>
                    </div>`);
    }
    element.on("change", "input[type='file']", function (event) {
        let files = event.target.files;

        for (let index = 0; index < files.length; index++) {
            if (fileIsImage(files[index])) {
                let form = new FormData();
                form.append(paramPost, files[index]);
                $.ajax({
                    url: urlPost,
                    type: "POST",
                    headers: headers,
                    processData: false,
                    contentType: false,
                    cache: false,
                    timeout: 600000,
                    mimeType: "multipart/form-data",
                    data: form,
                    success: function (res) {
                        res = JSON.parse(res);
                        // console.log(res)
                        if (res.code == 200) {
                            element.html(
                                `<div class="preview" style ="width: ` + element.data('width') + `; height: ` + element.data('height') + `">
                                <label>
                                    <img src="` + res.data.images + `" style="width: ` + element.data('width') + `; height: ` + element.data('height') + `; top: 0; right: 0;object-fit: contain;">
                                    <input class="file" type="file" hidden accept="image/*"></input>
                                </label>
                                <input type="text" hidden name="` + param + `" value="` + res.data.images + `"></input>
                            </div>`
                            );
                        }
                    },
                    error: function (err) {
                        console.log(err);
                    }
                });
            } else {
                alert('Chọn file là ảnh');
            }
        }
        $(this).val(null);
    });
}

function fileIsImage(file) {
    return file && file['type'].split('/')[0] === 'image';
}

