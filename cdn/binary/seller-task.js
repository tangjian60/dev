$(function () {
    var comment_img_html = '<div class="col-md-8"><div class="tieyu-icon image-upload-container"><img class="task-image-upload" src="' + CDN_BINARY_URL + 'cross.png"></div><div class="tieyu-icon image-upload-container"><img class="task-image-upload" src="' + CDN_BINARY_URL + 'cross.png"></div><div class="tieyu-icon image-upload-container"><img class="task-image-upload" src="' + CDN_BINARY_URL + 'cross.png"></div><div class="tieyu-icon image-upload-container"><img class="task-image-upload" src="' + CDN_BINARY_URL + 'cross.png"></div><div class="tieyu-icon image-upload-container"><img class="task-image-upload" src="' + CDN_BINARY_URL + 'cross.png"></div></div>';
    var comment_img_btn_html = '<div class="col-md-8"><a class="btn btn-sm btn-primary task-comment-button-img">添加一组评论</a><a class="btn btn-sm btn-success task-comment-button-confirm">确定</a><br><span class="task-comment-tips">确定好评论数量后，点击确定开始上传图片</span></div>';
    var comment_text_html = '<div class="col-md-8"><input class="form-control task-comment-input" type="text" name="comment_text"></div><div class="col-md-1"><a class="btn-remove-text-comment" href="javascript:;">&times;</a></div>';
    var comment_text_btn_html = '<div class="col-md-8"><a class="btn btn-sm btn-primary task-comment-button">添加评论</a></div>';

    var task_method_details_search = '<input placeholder="搜索关键字" class="form-control" type="text" name="task_method_details">';
    var task_method_details_share = '<input placeholder="推广链接" class="form-control" type="text" name="task_method_details">';
    var task_method_details_tkl = '<input placeholder="淘口令" class="form-control" type="text" name="task_method_details">';
    var task_method_details_pic = '<div class="tieyu-icon image-upload-container"><img data-upload-server="' + CDN_UPLOAD_URL + '" data-input-name="task_method_details" class="image-upload" src="' + CDN_BINARY_URL + 'cross.png"><input type="hidden" name="task_method_details"></div>';
    
    var express_weight_html = '<div class="col-md-8"><input class="form-control express-weight-input" type="text" name="goods_weight" placeholder="货物重量"></div>';

    var task_key_word_area = '<div class="col-md-8" style="width:90%">';
        task_key_word_area +=   '关键词：<input class="form-control task-key-word-input" type="text" name="task_method_details" style="width: 30%; display: inline-block;">';
        task_key_word_area +=   '&nbsp&nbsp&nbsp&nbsp搜索排序：<select class="form-control sort-type" name="sort_type" style="width: 15%; display: inline-block;">';
        task_key_word_area +=       '<option value="综合">综合</option>';
        task_key_word_area +=       '<option value="销量">销量</option>';
        task_key_word_area +=       '<option value="综合直通车">综合直通车</option>';
        task_key_word_area +=   '</select>';
        task_key_word_area +=   '&nbsp&nbsp&nbsp&nbsp单数：<input class="form-control task-task-number" type="number" name="task_number" style="width: 10%; display: inline-block;" value="0" onmousewheel="return false;" min="0">';
        task_key_word_area += '</div>';
        task_key_word_area += '<div class="col-md-1"><a class="btn-remove-key-word" href="javascript:;">&times;</a></div>';
    var task_key_word_area_add = '<div class="col-md-8"><a class="btn btn-sm btn-primary task-add-key-word">点击添加关键词方案</a></div>';

    var sort_type_without_search = '<div class="form-group">';
        sort_type_without_search += '<label class="col-md-3 control-label">';
        sort_type_without_search += '排序方式<span class="label label-default">必填</span>';
        sort_type_without_search += '</label>';
        sort_type_without_search += '<div class="col-md-8">';
        sort_type_without_search += '<label class="radio-inline"><input class="sort_type" type="radio" name="sort_type" value="综合">综合</label>';
        sort_type_without_search += '<label class="radio-inline"><input class="sort_type" type="radio" name="sort_type" value="销量">销量</label>';
        sort_type_without_search += '<label class="radio-inline"><input class="sort_type" type="radio" name="sort_type" value="综合直通车">综合直通车</label>';
        sort_type_without_search += '<p class="help-block">综合排序宝贝位置不稳定，推荐使用销量排序</p>';
        sort_type_without_search += '</div>';
        sort_type_without_search += '</div>';
                

    function bind_task_comment_img_update_event() {
        var uploader_url = CDN_UPLOAD_URL + '/seller_image_transport.php';
        $('.task-image-upload').each(function (i, e) {
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
    
    function update_task_number(){
        var task_number = 0;
        $("input[name='task_number']").each(function(){
            if ($(this).val()) {
                task_number += parseInt($(this).val());
            }else{
                $(this).val(1);
                task_number += 1;
            }
        });
        return task_number;
    }

    function update_price() {
        var form_data = $('.form-task-dianfu').formToJSON();
        var t_capital = string_to_float(form_data.task_capital).toFixed(2);
        var t_nums = string_to_int(form_data.num_of_pkg);
        var task_capital = t_capital * t_nums;
        var t_commission = CNY_DIANFU_BASIC + (task_capital * CNY_DIANFU_FEILV);
        var t_express = 0;
        if (form_data.comment_type && form_data.comment_type == COMMENT_TYPE_TEXT) {
            t_commission += CNY_COMMENT_WENZI;
        }
        if (form_data.comment_type && form_data.comment_type == COMMENT_TYPE_PICTURE) {
            t_commission += CNY_COMMENT_TUPIAN;
        }
        t_commission = t_commission * COMMISSION_DISCOUNT / 100;

		t_commission += CNY_HEIHAO;

		if (form_data.is_collection && form_data.is_collection != NOT_AVAILABLE) {
            t_commission += CNY_DIANFU_SC;
        }
		if (form_data.is_add_cart && form_data.is_add_cart != NOT_AVAILABLE) {
            t_commission += CNY_DIANFU_JIAGOU;
        }
		if (form_data.is_fake_chat && form_data.is_fake_chat != NOT_AVAILABLE) {
            t_commission += CNY_JIALIAO;
        }
		if (form_data.is_compete_collection && form_data.is_compete_collection != NOT_AVAILABLE) {
            t_commission += CNY_JINGPIN_SC;
        }
		if (form_data.is_compete_add_cart && form_data.is_compete_add_cart != NOT_AVAILABLE) {
            t_commission += CNY_JINGPIN_JIAGOU;
        }
        if (form_data.is_preferred && form_data.is_preferred != NOT_AVAILABLE) {
            t_commission += CNY_YOUXIAN;
        }
        if (form_data.is_huabei && form_data.is_huabei != NOT_AVAILABLE) {
            t_commission += CNY_HUABEI;
        }
        if (form_data.sex_limit && form_data.sex_limit != NOT_AVAILABLE) {
            t_commission += CNY_XINGBIE;
        }
        if (form_data.age_limit && form_data.age_limit != NOT_AVAILABLE) {
            t_commission += CNY_NIANLING;
        }
        if (form_data.tb_rate_limit && form_data.tb_rate_limit != NOT_AVAILABLE) {
            t_commission += CNY_DENGJI;
        }
        if (form_data.express_type && form_data.express_type != NOT_AVAILABLE) {
            t_express += CNY_DIANFU_EXPRESS;
        }

        var task_cnt = string_to_int(form_data.task_cnt);
        var all_task_capital_amount = task_capital * task_cnt;
        var all_task_commission_amount = t_commission * task_cnt;
        var all_task_express_amount = t_express * task_cnt;
        var total_amount = all_task_capital_amount + all_task_commission_amount + all_task_express_amount;
        $('.task_cnt').html(task_cnt);
        $('#task_capital_amount').html(task_capital.toFixed(2));
        $('#task_commission_amount').html(t_commission.toFixed(2));
        $('#task_express_amount').html(t_express.toFixed(2));
        $('#all_task_capital_amount').html(all_task_capital_amount.toFixed(2));
        $('#all_task_commission_amount').html(all_task_commission_amount.toFixed(2));
        $('#all_task_express_amount').html(all_task_express_amount.toFixed(2));
        $('#total_amount').html(total_amount.toFixed(2));
    }
    
    function init_task_cnt_input(){
        $('#task-cnt-input').removeAttr("readonly");
        $('#task-cnt-input').val("");
    }
    $('.task_method').click(function () {
        var method = $(this).val();
        var target_ele = $('#task_method_details');
        if (method == '搜索') {
            if (parent_order_data_attribute != null && parent_order_data_attribute.task_method == '搜索' && parent_order_data_attribute.task_method_details != null) {


                // 编辑情况
                var rHtml = ''


                parent_order_data_attribute.task_method_details.forEach(function(x, i) {
                    rHtml += task_key_word_area;
                })
                rHtml += task_key_word_area_add;

                $('.task-key-word').html(rHtml);
                $('#task-cnt-input').attr('readonly', true);
                $('#task-cnt-input').val("");
            }else{
                $('.task-key-word').html(task_key_word_area + task_key_word_area_add);
                $('#task-cnt-input').val(0);//TODO... val(1)
                $('#task-cnt-input').attr('readonly', true);
                $('#sort_type').hide();
                update_price();
            }
        } else if (method == '分享成交') {
            if (parent_order_data_attribute != null && parent_order_data_attribute.task_method == '分享成交' && parent_order_data_attribute.task_method_details != null) {
                $('.task-key-word').html('<input placeholder="推广链接" class="form-control" type="text" name="task_method_details" value="' + parent_order_data_attribute.task_method_details  + '">');
                $('#sort_type').show();
            }else{
                $('.task-key-word').html(task_method_details_share);
                $('#sort_type').show();
                init_task_cnt_input();
            }
        } else if (method == '淘口令') {
            if (parent_order_data_attribute != null && parent_order_data_attribute.task_method == '淘口令' && parent_order_data_attribute.task_method_details != null) {
                $('.task-key-word').html('<input placeholder="淘口令" class="form-control" type="text" name="task_method_details" value="' + parent_order_data_attribute.task_method_details  + '">');
                $('#sort_type').show();
            }else{
                $('.task-key-word').html(task_method_details_tkl);
                init_task_cnt_input();
                $('#sort_type').show();
            }
        } else if (method == '聚划算') {
            if (parent_order_data_attribute != null && parent_order_data_attribute.task_method == '聚划算' && parent_order_data_attribute.task_method_details != null) {
                $('.task-key-word').html('<div class="tieyu-icon image-upload-container"><img data-upload-server="' + CDN_UPLOAD_URL + '" data-input-name="task_method_details" class="image-upload" src="' + CDN_DOMAIN + parent_order_data_attribute.task_method_details + '"><input type="hidden" name="task_method_details" value="' + parent_order_data_attribute.task_method_details + '"></div>');
                $('#sort_type').show();
            }else{
                $('.task-key-word').html(task_method_details_pic);
                init_task_cnt_input();
                $('#sort_type').show();
            }
            bind_image_upload_event();
        } else if (method == '淘抢购') {
            if (parent_order_data_attribute != null && parent_order_data_attribute.task_method == '淘抢购' && parent_order_data_attribute.task_method_details != null) {
                $('.task-key-word').html('<div class="tieyu-icon image-upload-container"><img data-upload-server="' + CDN_UPLOAD_URL + '" data-input-name="task_method_details" class="image-upload" src="' + CDN_DOMAIN + parent_order_data_attribute.task_method_details + '"><input type="hidden" name="task_method_details" value="' + parent_order_data_attribute.task_method_details + '"></div>');
                $('#sort_type').show();
            }else{
                $('.task-key-word').html(task_method_details_pic);
                init_task_cnt_input();
                $('#sort_type').show();
            }
            bind_image_upload_event();
        } else if (method == '天天特价') {
            if (parent_order_data_attribute != null && parent_order_data_attribute.task_method == '天天特价' && parent_order_data_attribute.task_method_details != null) {
                $('.task-key-word').html('<div class="tieyu-icon image-upload-container"><img data-upload-server="' + CDN_UPLOAD_URL + '" data-input-name="task_method_details" class="image-upload" src="' + CDN_DOMAIN + parent_order_data_attribute.task_method_details + '"><input type="hidden" name="task_method_details" value="' + parent_order_data_attribute.task_method_details + '"></div>');
                $('#sort_type').show();
            }else{
                $('.task-key-word').html(task_method_details_pic);
                init_task_cnt_input();
                $('#sort_type').show();
            }
            bind_image_upload_event();
        } else {
            $('.task-key-word').html('');
        }
    });
    $('.comment_type').click(function () {
        var c_type = $(this).val();
        var task_number = 0;
        $("input[name='task_number']").each(function(){
            if ($(this).val()) {
                task_number += parseInt($(this).val());
            }
        });
        if (c_type == COMMENT_TYPE_NORMAL) {
            $('#tips-comment-type').html('普通好评免费，内容由买家自由发挥');
            $('.task-comment-area').html('');
        } else if (c_type == COMMENT_TYPE_TEXT) {
            if (task_number != null && task_number > 0) {}
            $('#tips-comment-type').html('每单+ ' + CNY_COMMENT_WENZI + ' 元，请添加 ' + task_number + ' 组评论');
            if (parent_order_data_attribute != null && parent_order_data_attribute.comment_type == '2' && parent_order_data_attribute.comment_text != null) {
                var comment_text_list = parent_order_data_attribute.comment_text;
                var comment_text_html_with_value = '';
                for (var i = 0; i < comment_text_list.length; i++) {
                    comment_text_html_with_value += '<div class="col-md-8"><input class="form-control task-comment-input" type="text" name="comment_text" value="' + comment_text_list[i] + '"></div><div class="col-md-1"><a class="btn-remove-text-comment" href="javascript:;">&times;</a></div>';
                }
                $('.task-comment-area').html(comment_text_html_with_value + comment_text_btn_html);
            }else{
                $('.task-comment-area').html(comment_text_html + comment_text_btn_html);
            }
        } else if (c_type == COMMENT_TYPE_PICTURE) {
            $('#tips-comment-type').html('每单+ ' + CNY_COMMENT_TUPIAN + ' 元，请添加 ' + task_number + ' 组评论');
            $('.task-comment-area').html(comment_text_html + comment_img_html + comment_img_btn_html);
            $('#task-cnt-input').attr('readonly', true);
            // $('#task-cnt-input').val(1);
        }
        update_price();
    });
    $('.is_collection').click(function () {
        if ($(this).val() == NOT_AVAILABLE) {
            $('#tips-is-collection').html('');
        } else {
            $('#tips-is-collection').html('每单+ ' + CNY_DIANFU_SC + ' 元');
        }
        update_price();
    });
	$('.is_add_cart').click(function () {
        if ($(this).val() == NOT_AVAILABLE) {
            $('#tips-is-add-cart').html('');
        } else {
            $('#tips-is-add-cart').html('每单+ ' + CNY_DIANFU_JIAGOU + ' 元');
        }
        update_price();
    });
	$('.is_fake_chat').click(function () {
        if ($(this).val() == NOT_AVAILABLE) {
            $('#tips-is-fake-chat').html('');
        } else {
            $('#tips-is-fake-chat').html('每单+ ' + CNY_JIALIAO + ' 元');
        }
        update_price();
    });
	$('.is_compete_collection').click(function () {
        if ($(this).val() == NOT_AVAILABLE) {
            $('#tips-is-compete-collection').html('');
        } else {
            $('#tips-is-compete-collection').html('每单+ ' + CNY_JINGPIN_SC + ' 元');
        }
        update_price();
    });
	$('.is_compete_add_cart').click(function () {
        if ($(this).val() == NOT_AVAILABLE) {
            $('#tips-compete-add-cart').html('');
        } else {
            $('#tips-compete-add-cart').html('每单+ ' + CNY_JINGPIN_JIAGOU + ' 元');
        }
        update_price();
    });
    $('.is_preferred').click(function () {
        if ($(this).val() == NOT_AVAILABLE) {
            $('#tips-is-preferred').html('');
        } else {
            $('#tips-is-preferred').html('每单+ ' + CNY_YOUXIAN + ' 元');
        }
        update_price();
    });
    $('.is_huabei').click(function () {
        if ($(this).val() == NOT_AVAILABLE) {
            $('#tips-is-huabei').html('');
        } else {
            $('#tips-is-huabei').html('每单+ ' + CNY_HUABEI + ' 元');
        }
        update_price();
    });
    $('.sex_limit').click(function () {
        if ($(this).val() == NOT_AVAILABLE) {
            $('#tips-sex-limit').html('');
        } else {
            $('#tips-sex-limit').html('每单+ ' + CNY_XINGBIE + ' 元');
        }
        update_price();
    });
    $('.express_type').click(function () {
        if ($(this).val() == NOT_AVAILABLE) {
            $('#tips-express-type').html('');
        } else {
            $('#tips-express-type').html(express_weight_html + '<div class="col-md-8">每单+ ' + CNY_DIANFU_EXPRESS + ' 元（0-40kg，保留小数点后一位）</div>');
        }
        update_price();
    });
    $('.age_limit').click(function () {
        if ($(this).val() == NOT_AVAILABLE) {
            $('#tips-age-limit').html('');
        } else {
            $('#tips-age-limit').html('每单+ ' + CNY_NIANLING + ' 元');
        }
        update_price();
    });
    $('.tb_rate_limit').click(function (e) {
        if ($(this).val() == NOT_AVAILABLE) {
            $('#tips-tb-rate-limit').html('');
        } else {
            $('#tips-tb-rate-limit').html('每单+ ' + CNY_DENGJI + ' 元');
        }
        update_price();
    });
    $('#task-cnt-input,#input-task-capital,#input-num-of-pkg').on('keyup change', function () {
        update_price();
    });
    $(document).on("keyup", ".task-task-number", function (e) {
        e.preventDefault();
        var task_number = update_task_number();
        $('#task-cnt-input').attr('readonly', true);
        $('#task-cnt-input').val(task_number);
        update_price();
    });
    $(document).on("click", ".task-comment-button", function (e) {
        e.preventDefault();
        $(this).parent('.col-md-8').before(comment_text_html);
        // $('#task-cnt-input').val($('.task-comment-input').length);
        // update_price();
    });
    $(document).on("click", ".task-add-key-word", function (e) {
        e.preventDefault();
        $(this).parent('.col-md-8').before(task_key_word_area);
        var task_number = update_task_number();
        $('#task-cnt-input').val(task_number);
        update_price();
    });
    $(document).on("click", ".btn-remove-text-comment", function (e) {
        e.preventDefault();
        $(this).parent(".col-md-1").prev().remove();
        $(this).parent(".col-md-1").remove();
        $('#task-cnt-input').val($('.task-comment-input').length);
        update_price();
    });
	$(document).on("click", ".btn-remove-key-word", function (e) {
        e.preventDefault();
		$(this).parent(".col-md-1").prev().remove();
		$(this).parent(".col-md-1").remove();
        var task_number = update_task_number();
        $('#task-cnt-input').val(task_number);
        update_price();
    });
    $(document).on("click", ".task-comment-button-img", function (e) {
        e.preventDefault();
        $(this).parent('.col-md-8').before(comment_text_html + comment_img_html);
        $('#task-cnt-input').val($('.task-comment-input').length);
        update_price();
    });
    $(document).on("click", ".task-comment-button-confirm", function (e) {
        e.preventDefault();
        $(this).hide();
        $('.task-comment-button-img').hide();
        $('.task-comment-tips').html('请填写评论内容并点击「+」号上传评论图片');
        bind_task_comment_img_update_event();
    });
    function get_haoping_img() {
        var o = new Array();
        $('.task-image-upload').each(function () {
            o.push($(this).attr('src'));
        });
        return o;
    }
    $('#btn-task-go').click(function (e) {
        e.preventDefault();
        var form_data = $('.form-task-dianfu').formToJSON();
        var that = $(this);
        hide_error_message();
        if (form_data.sku == "") { form_data.sku = "任意" }
        if (form_data.hand_out_interval == "") { form_data.hand_out_interval = "0"; }
		if (parseInt(form_data.hand_out_interval) > 500) { show_error_message('放单时间间隔不能大于500分钟'); return; }
        if (form_data.task_method == '搜索') {
            // 单个
            if (typeof(form_data.sort_type) == 'string') {
                if (!form_data.task_method_details || !form_data.task_number) {show_error_message('关键词和单数不能为空'); return;}
            }else{ //多个
                if (typeof(form_data.task_method_details) != 'object' || typeof(form_data.sort_type) != 'object' || typeof(form_data.task_number) != 'object' ) {
                    show_error_message('字段不能为空'); return; 
                }
                for(var i in form_data.task_method_details){
                    if (!form_data.task_method_details[i]) { show_error_message('关键词不能为空'); return; }
                }
                var task_number_total = 0;
                for(var j in form_data.task_number){
                    if (!form_data.task_number[j]) { 
                        show_error_message('单数不能为空'); return; 
                    }else if(form_data.task_number[j] == 0){
                        show_error_message('关键词单数不能为0！'); return;
                    }else{
                        task_number_total += parseInt(form_data.task_number[j]);
                    }
                }
                if (task_number_total != form_data.task_cnt) {show_error_message('关键词单数和任务单数不符'); return;}
            }
        }
        if (parseInt(form_data.comment_type) == 2 || parseInt(form_data.comment_type) == 3) {
            if (parseInt(form_data.task_cnt) != 1) {
                if (form_data.comment_text.length != form_data.task_cnt) {show_error_message('任务单数与指定评论内容个数不符合'); return;}
                for(var j in form_data.comment_text){
                    if (!form_data.comment_text[j]) { 
                        show_error_message('评价不能为空'); return; 
                    }
                }
            }
        }

       for ( var key in form_data) {
            if (key.indexOf('demo') != -1) {
                //form_data[key] = 'del'
                 delete form_data[key]
            }
        }
        if (invalid_parameter(form_data)) { show_error_message('所有字段均不能为空，请填写所有字段'); return; }
        if (form_data.comment_type == COMMENT_TYPE_PICTURE) { form_data.comment_img = get_haoping_img(); }
        if (Date.parse(new Date(form_data.start_time)) > Date.parse(new Date(form_data.end_time))) {show_error_message('任务结束时间不能小于任务开始时间'); return;}
        if (Date.parse(new Date()) > Date.parse(new Date(form_data.end_time))) {show_error_message('任务结束时间不能小于当前时间'); return;}
        if (form_data.goods_weight != undefined) {
            if (isNumber(form_data.goods_weight) && form_data.goods_weight > 0) {
            } else {
                show_error_message('快递货物重量必须大于0');return;
            }
        }

        that.addClass('disabled');
        that.attr("disabled", true);

        ajax_request(
            that.data('url'),
            form_data,
            function (e) {
                if (e.code == CODE_SUCCESS) {
                    show_success_message('任务创建成功，正在跳转到支付页面……');
                    goto_url(that.data('target') + e.msg, 3000);
                } else {
                    show_error_message(e.msg);
                    that.removeClass('disabled');
                    that.attr("disabled", false);
                }
            });
    });
    $(".format_datetime").datetimepicker({
        language: 'zh-CN',
        format: 'yyyy-mm-dd hh:ii:00',
        autoclose: true
    });


    if (parent_order_data_attribute != null) {
        // 模版
        if (parent_order_data_attribute.template_id != null) {
            $("#template_id").val(parent_order_data_attribute.template_id);
        }
        // 任务入口
        if (parent_order_data_attribute.task_method != null) {
            var task_method_value = ['搜索', '分享成交', '淘口令', '聚划算', '淘抢购', '天天特价'];
            for (var i = 0; i < task_method_value.length; i++) {
                if (task_method_value[i] == parent_order_data_attribute.task_method) {
                    $('.task_method')[i].click();
                }
            }
        }

        //关键词
        if (parent_order_data_attribute.task_method_details != null) {
            parent_order_data_attribute.task_method_details.forEach(function(x, i) {
                $(":input[name='task_method_details']").eq(i).val(x);
            })

        }
        //搜索排序
        if (parent_order_data_attribute.sort_type != null) {
            parent_order_data_attribute.sort_type.forEach(function(x, i) {
                $(":input[name='sort_type']").eq(i).val(x);
            })
        }

       /* //单数
        if (parent_order_data_attribute.task_number != null) {
            parent_order_data_attribute.task_number.forEach(function(x, i) {
                $(":input[name='task_number']").eq(i).val(x);
            })
        }*/

        // 收货人数
        if (parent_order_data_attribute.receipt_cnt > 0) {
            $(":input[name='receipt_cnt']").val(parent_order_data_attribute.receipt_cnt);
        }
        // 购买人数
        if (parent_order_data_attribute.buyer_cnt > 0) {
            $(":input[name='buyer_cnt']").val(parent_order_data_attribute.buyer_cnt);
        }
        // 尺码规格
        if (parent_order_data_attribute.sku != null) {
            $(":input[name='sku']").val(parent_order_data_attribute.sku);
        }
        // 实际成交价格
        if (parent_order_data_attribute.task_capital > 0) {
            $(":input[name='task_capital']").val(parent_order_data_attribute.task_capital);
        }
        // 每单拍
        if (parent_order_data_attribute.num_of_pkg > 0) {
            $(":input[name='num_of_pkg']").val(parent_order_data_attribute.num_of_pkg);
        }
        // 是否使用优惠券
        if (parent_order_data_attribute.is_coupon != null) {
            var is_coupon_radio_id = (parent_order_data_attribute.is_coupon == '使用优惠券') ? 0 : 1;
            $(":input[name='is_coupon']")[is_coupon_radio_id].click();
        }
        //收藏商品 
        if (parent_order_data_attribute.is_collection != null) {
            var is_collection_radio_id = (parent_order_data_attribute.is_collection == 'na') ? 1 : 0;
            $(":input[name='is_collection']")[is_collection_radio_id].click();
        }
        //加入购物车下单 
        if (parent_order_data_attribute.is_add_cart != null) {
            var is_add_cart_radio_id = (parent_order_data_attribute.is_add_cart == 'na') ? 1 : 0;
            $(":input[name='is_add_cart']")[is_add_cart_radio_id].click();
        }
        //假聊 
        if (parent_order_data_attribute.is_fake_chat != null) {
            var is_fake_chat_radio_id = (parent_order_data_attribute.is_fake_chat == 'na') ? 1 : 0;
            $(":input[name='is_fake_chat']")[is_fake_chat_radio_id].click();
        }
        //竞品收藏 
        if (parent_order_data_attribute.is_compete_collection != null) {
            var is_compete_collection_radio_id = (parent_order_data_attribute.is_compete_collection == 'na') ? 1 : 0;
            $(":input[name='is_compete_collection']")[is_compete_collection_radio_id].click();
        }
        //竞品加购物车 
        if (parent_order_data_attribute.is_compete_add_cart != null) {
            var is_compete_add_cart_radio_id = (parent_order_data_attribute.is_compete_add_cart == 'na') ? 1 : 0;
            $(":input[name='is_compete_add_cart']")[is_compete_add_cart_radio_id].click();
        }
        // 放单模式
        if (parent_order_data_attribute.is_preferred != null) {
            var is_preferred_radio_id = (parent_order_data_attribute.is_preferred == 'na') ? 0 : 1;
            $(":input[name='is_preferred']")[is_preferred_radio_id].click();
        }
        // 花呗设置
        if (parent_order_data_attribute.is_huabei != null) {
            var is_huabei_radio_id = (parent_order_data_attribute.is_huabei == 'na') ? 0 : 1;
            $(":input[name='is_huabei']")[is_huabei_radio_id].click();
        }
        // 性别限制
        if (parent_order_data_attribute.sex_limit != null) {
            var sex_limit_radio_id;
            switch (parent_order_data_attribute.sex_limit){
                case 'na':
                    sex_limit_radio_id = 0;
                    break;
                case '男':
                    sex_limit_radio_id = 1;
                    break;
                case '女':
                    sex_limit_radio_id = 2;
                    break;
            }
            $(":input[name='sex_limit']")[sex_limit_radio_id].click();
        }
        // 年龄限制
        if (parent_order_data_attribute.age_limit != null) {
            $(":input[name='age_limit']").val(parent_order_data_attribute.age_limit);
        }
        // 等级限制
        if (parent_order_data_attribute.tb_rate_limit != null) {
            $(":input[name='tb_rate_limit']").val(parent_order_data_attribute.tb_rate_limit);
        }

       /* // 区域限制
         if (parent_order_data_attribute.taskPlanDay != null) {
             $(":input[name='taskPlanDay']").val(parent_order_data_attribute.taskPlanDay);
         }*/

        //任务单数
        if (parent_order_data_attribute.task_cnt != null) {
            //$(":input[name='task_cnt']").val(parent_order_data_attribute.task_cnt);
            $(":input[name='task_cnt']").val(0);
        }
        //放单时间间隔（分钟）
        if (parent_order_data_attribute.hand_out_interval != null) {
            $(":input[name='hand_out_interval']").val(parent_order_data_attribute.hand_out_interval);
        }
        //选择快递
        if (parent_order_data_attribute.is_express != null) {
            var is_express_radio_id = (parent_order_data_attribute.is_express == '1') ? 1 : 0;
            $(":input[name='express_type']")[is_express_radio_id].click();
            if (parent_order_data_attribute.goods_weight != null) {
                $(":input[name='goods_weight']").val(parent_order_data_attribute.goods_weight);
            }
        }
        //评价方式
        if (parent_order_data_attribute.comment_type != null) {
            var comment_type_radio_id;
            switch (parent_order_data_attribute.comment_type){
                case '1':
                    comment_type_radio_id = 0;
                    break;
                case '2':
                    comment_type_radio_id = 1;
                    break;
                case '3':
                    comment_type_radio_id = 2;
                    break;
            }
            $(":input[name='comment_type']")[comment_type_radio_id].click();
        }
    }else{ //init endif
        $('.task_method')[0].click();
    } // init endifelse
    
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