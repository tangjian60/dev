$(function(){
    $('#myModal').on('shown.bs.modal', function (event) {
        var that = $(event.relatedTarget);
        $('#id').val(that.data('id'));
        $('#url').val(that.data('url'));
    });

    $('.memo1').change(function(){
        if ($(this).val() == '5') {
            $('.memo2').val('于明亮光线下拍照，需看清身份证底纹以及手持证件上的清晰信息');
        }
    });

    $(".btn-reject").click(function (e) {
        e.preventDefault();
        var that = $('.reject');
        that.addClass('disabled');
        that.attr("disabled", true);

        var form_data = $('#form-modal').formToJSON();
        form_data['memo'] = (function(){
            $memo2 = $(".memo2").val();
            $memo2 = $.trim($memo2);
            $memo1 = $('.memo1').find("option:selected").text();

            if ($memo1 == '其他'
                && $memo2.length == 0){
                return "";
            }else if ($memo2.length == 0){
                return $memo1;
            }else{
                return $memo1 + '(' + $memo2 + ')';
            }
        }());

        // 是否永久拒绝再次提交实名审核
        form_data['cer_reject'] = $('.memo1').val() == '4' ? 1 : -1;

        if (invalid_parameter(form_data)) {
            alert('请填写拒绝原因');
            return;
        }

        ajax_request(
            $('#url').val(),
            form_data,
            function (e) {
                if (e.code == CODE_SUCCESS) {
                    location.reload();
                } else {
                    alert(e.msg);
                    that.removeClass('disabled');
                    that.attr("disabled", false);
                }
            });
    });
});
