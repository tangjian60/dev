$(function () {

    bind_img_upload_event();

    $(".format_datetime").datetimepicker({
        language: 'zh-CN',
        format: 'yyyy-mm-dd hh:ii:00',
        autoclose: true
    });


    function bind_img_upload_event() {
        var uploader_url = CDN_UPLOAD_URL + '/seller_image_transport.php';
        $('.image-upload').each(function (i, e) {
            var that = $(this);
            var input = document.createElement('input');
            input.type = "file";
            input.accept = "image/*";
            input.className = "image-file-uploader";
            input.onchange = function (f) {
                if (!this.files[0]) return;
                lrz(this.files[0], {width: UPLOAD_IMAGE_SIZE, quality: TASK_IMAGE_QUALITY}, function (results) {
                    ajax_request(uploader_url
                        , {img_base: encodeURIComponent(results.base64)}
                        , function (data) {
                            if (data.code == CODE_SUCCESS) {
                                $('input[name="' + that.data('input-name') + '"]').val(data.msg);
                                that.attr('src', CDN_DOMAIN + data.msg);
                            } else {
                                alert(data.msg);
                            }
                        });
                });
            };
            $(input).insertAfter($(this));
        });
    }




});


function isNumber(val){

    var regPos = /^\d+(\.\d+)?$/; //非负浮点数
    var regNeg = /^(-(([0-9]+\.[0-9]*[1-9][0-9]*)|([0-9]*[1-9][0-9]*\.[0-9]+)|([0-9]*[1-9][0-9]*)))$/; //负浮点数
    if(regPos.test(val) || regNeg.test(val)){
        return true;
    }else{
        return false;
    }

}