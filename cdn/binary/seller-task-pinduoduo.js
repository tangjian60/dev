$(function () {
    var task_method_details_search = '<input placeholder="搜索关键字" class="form-control" type="text" name="task_method_details">';
    var task_method_details_pid = '<input placeholder="输入Pid" class="form-control" type="text" name="task_method_details">';

    var comment_text_html = '<div class="col-md-8"><input class="form-control task-comment-input" type="text" name="comment_text"></div><div class="col-md-1"><a class="btn-remove-text-comment" href="javascript:;">&times;</a></div>';
    var comment_text_btn_html = '<div class="col-md-8"><a class="btn btn-sm btn-primary task-comment-button">添加评论</a></div>';
    var comment_img_html = '<div class="col-md-8"><div class="tieyu-icon image-upload-container"><img class="task-image-upload" src="' + CDN_BINARY_URL + 'cross.png"></div><div class="tieyu-icon image-upload-container"><img class="task-image-upload" src="' + CDN_BINARY_URL + 'cross.png"></div><div class="tieyu-icon image-upload-container"><img class="task-image-upload" src="' + CDN_BINARY_URL + 'cross.png"></div><div class="tieyu-icon image-upload-container"><img class="task-image-upload" src="' + CDN_BINARY_URL + 'cross.png"></div><div class="tieyu-icon image-upload-container"><img class="task-image-upload" src="' + CDN_BINARY_URL + 'cross.png"></div></div>';
    var comment_img_btn_html = '<div class="col-md-8"><a class="btn btn-sm btn-primary task-comment-button-img">添加一组评论</a><a class="btn btn-sm btn-success task-comment-button-confirm">确定</a><br><span class="task-comment-tips">确定好评论数量后，点击确定开始上传图片</span></div>';

    var express_weight_html = '<div class="col-md-8"><input class="form-control express-weight-input" type="text" name="goods_weight" placeholder="货物重量"></div>';
    var task_key_word_area = '<div class="col-md-8" style="width:90%">';
        task_key_word_area +=   '关键词：<input class="form-control task-key-word-input" type="text" name="task_method_details" style="width: 30%; display: inline-block;">';
        task_key_word_area +=   '&nbsp&nbsp&nbsp&nbsp搜索排序：<select class="form-control sort-type" name="sort_type" style="width: 15%; display: inline-block;">';
        task_key_word_area +=       '<option value="综合排序">综合排序</option>';
        task_key_word_area +=       '<option value="销量排序">销量排序</option>';
        task_key_word_area +=       '<option value="价格排序">价格排序</option>';
        task_key_word_area +=   '</select>';
        task_key_word_area +=   '&nbsp&nbsp&nbsp&nbsp单数：<input class="form-control task-task-number" type="number" name="task_number" style="width: 10%; display: inline-block;" value="1" onmousewheel="return false;" min="0">';
        task_key_word_area += '</div>';
        task_key_word_area += '<div class="col-md-1"><a class="btn-remove-key-word" href="javascript:;">&times;</a></div>';
    var task_key_word_area_add = '<div class="col-md-8"><a class="btn btn-sm btn-primary task-add-key-word">点击添加关键词方案</a></div>';
    
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


    // 拼多多任务模式
    $('.task_method').click(function () {
        var method = $(this).val();
        var target_ele = $('#task_method_details');
        if (method == 'App搜索模式') {
            if (parent_order_data_attribute != null && parent_order_data_attribute.task_method == 'App搜索模式' && parent_order_data_attribute.task_method_details != null) {
                target_ele.html('<input placeholder="搜索关键字" class="form-control" type="text" name="task_method_details" value="' + parent_order_data_attribute.task_method_details  + '">');
            }else{
                $('.task-key-word').html(task_key_word_area + task_key_word_area_add);
                $('#task-cnt-input').val("1");
                $('#task-cnt-input').attr('readonly', true);
                $('#sort_type').hide();
                target_ele.html(task_method_details_search);
                update_price();
            }
        } else if (method == 'Pid模式') {
            if (parent_order_data_attribute != null && parent_order_data_attribute.task_method == 'Pid模式' && parent_order_data_attribute.task_method_details != null) {
                target_ele.html('<input placeholder="输入Pid" class="form-control" type="text" name="task_method_details" value="' + parent_order_data_attribute.task_method_details  + '">');
            }else{
                $('.task-key-word').html(task_method_details_pid);
                $('#sort_type').show();
                $('#task-cnt-input').removeAttr("readonly");
                $('#task-cnt-input').val("");
            }
        } else {
            target_ele.html('');
        }
    });

    // 是否收藏单品
    $('.is_collection').click(function () {
        if ($(this).val() == NOT_AVAILABLE) {
            $('#tips-is-collection').html('');
        } else {
            $('#tips-is-collection').html('每单+ ' + CNY_PINDUODUO_SC + ' 元');
        }
        update_price();
    });
    // 是否分享到朋友圈
    $('.is_wechat_share').click(function () {
        if ($(this).val() == NOT_AVAILABLE) {
            $('#tips-is-wechat-share').html('');
        } else {
            $('#tips-is-wechat-share').html('每单+ ' + CNY_PINDUODUO_WECHAT_SHARE + ' 元');
        }
        update_price();
    });
    // 聊天
    $('.is_fake_chat').click(function () {
        if ($(this).val() == NOT_AVAILABLE) {
            $('#tips-is-fake-chat').html('');
        } else {
            $('#tips-is-fake-chat').html('每单+ ' + CNY_PINDUODUO_JIALIAO + ' 元');
        }
        update_price();
    });
    // 竞品收藏
    $('.is_compete_collection').click(function () {
        if ($(this).val() == NOT_AVAILABLE) {
            $('#tips-is-compete-collection').html('');
        } else {
            $('#tips-is-compete-collection').html('每单+ ' + CNY_PINDUODUO_JINGPIN_SC + ' 元');
        }
        update_price();
    });
    // 放单模式
    $('.is_preferred').click(function () {
        if ($(this).val() == NOT_AVAILABLE) {
            $('#tips-is-preferred').html('');
        } else {
            $('#tips-is-preferred').html('每单+ ' + CNY_PINDUODUO_YOUXIAN + ' 元');
        }
        update_price();
    });
    // 评价方式
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
            $('#task-cnt-input').removeAttr("readonly");
        } else if (c_type == COMMENT_TYPE_TEXT) {
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
            
            $('#task-cnt-input').attr('readonly', true);
            $('#task-cnt-input').val(1);
        } else if (c_type == COMMENT_TYPE_PICTURE) {
            $('#tips-comment-type').html('每单+ ' + CNY_COMMENT_TUPIAN + ' 元，请添加 ' + task_number + ' 组评论');
            $('.task-comment-area').html(comment_text_html + comment_img_html + comment_img_btn_html);
            $('#task-cnt-input').attr('readonly', true);
            $('#task-cnt-input').val(1);
        }
        update_price();
    });
    $('.express_type').click(function () {
        if ($(this).val() == NOT_AVAILABLE) {
            $('#tips-express-type').html('');
        } else {
            $('#tips-express-type').html(express_weight_html + '<div class="col-md-8">每单+ ' + CNY_PINDUODUO_EXPRESS + ' 元（0-40kg，保留小数点后一位）</div>');
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
    $(document).on("click", ".task-add-key-word", function (e) {
        e.preventDefault();
        $(this).parent('.col-md-8').before(task_key_word_area);
        var task_number = update_task_number();
        $('#task-cnt-input').val(task_number);
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

    $(document).on("click", ".task-comment-button", function (e) {
        e.preventDefault();
        $(this).parent('.col-md-8').before(comment_text_html);
        $('#task-cnt-input').val($('.task-comment-input').length);
        update_price();
    });
    $(document).on("click", ".btn-remove-text-comment", function (e) {
        e.preventDefault();
        $(this).parent(".col-md-1").prev().remove();
        $(this).parent(".col-md-1").remove();
        $('#task-cnt-input').val($('.task-comment-input').length);
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

    function update_price() {
        var form_data = $('.form-task-pinduoduo').formToJSON();
        var t_capital = string_to_float(form_data.task_capital).toFixed(2);
        var t_nums = string_to_int(form_data.num_of_pkg);
        var task_capital = t_capital * t_nums;
        var t_express = 0;
        var t_commission = CNY_PINDUODUO_BASIC + (task_capital * CNY_PINDUODUO_FEILV);
        if (form_data.comment_type && form_data.comment_type == COMMENT_TYPE_TEXT) {
            t_commission += CNY_COMMENT_WENZI;
        }
        if (form_data.comment_type && form_data.comment_type == COMMENT_TYPE_PICTURE) {
            t_commission += CNY_COMMENT_TUPIAN;
        }
        t_commission = t_commission * COMMISSION_DISCOUNT / 100;

        t_commission += CNY_HEIHAO;

        if (form_data.is_collection && form_data.is_collection != NOT_AVAILABLE) {
            t_commission += CNY_PINDUODUO_SC;
        }
        if (form_data.is_wechat_share && form_data.is_wechat_share != NOT_AVAILABLE) {
            t_commission += CNY_PINDUODUO_WECHAT_SHARE;
        }
        if (form_data.is_fake_chat && form_data.is_fake_chat != NOT_AVAILABLE) {
            t_commission += CNY_PINDUODUO_JIALIAO;
        }
        if (form_data.is_compete_collection && form_data.is_compete_collection != NOT_AVAILABLE) {
            t_commission += CNY_PINDUODUO_JINGPIN_SC;
        }
        if (form_data.is_preferred && form_data.is_preferred != NOT_AVAILABLE) {
            t_commission += CNY_PINDUODUO_YOUXIAN;
        }
        if (form_data.express_type && form_data.express_type != NOT_AVAILABLE) {
            t_express += CNY_PINDUODUO_EXPRESS;
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
    $('#btn-task-go').click(function (e) {
        e.preventDefault();
        var form_data = $('.form-task-dianfu').formToJSON();
        var that = $(this);
        hide_error_message();
        if (form_data.sku == "") { form_data.sku = "任意" }
        if (form_data.hand_out_interval == "") { form_data.hand_out_interval = "0"; }
        if (parseInt(form_data.hand_out_interval) > 500) { show_error_message('放单时间间隔不能大于500分钟'); return; }
        if (form_data.task_method == 'App搜索模式') {
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
                    }else{
                        task_number_total += parseInt(form_data.task_number[j]);
                    }
                }
                if (task_number_total != form_data.task_cnt) {show_error_message('关键词单数和任务单数不符'); return;}
            }

            if (parseInt(form_data.comment_type) == 2) {
                if (parseInt(form_data.task_cnt) != 1) {
                    if (form_data.comment_text.length != form_data.task_cnt) {show_error_message('任务单数与指定评论内容个数不符合'); return;}
                }
            }
            if (parseInt(form_data.comment_type) == 3) {
                if (parseInt(form_data.task_cnt) != 1) {
                    if (form_data.comment_text.length != form_data.task_cnt) {show_error_message('任务单数与指定图片内容个数不符合'); return;}
                }
            }
        }
        if (invalid_parameter(form_data)) { show_error_message('所有字段均不能为空，请填写所有字段'); return; }
        if (form_data.comment_type == COMMENT_TYPE_PICTURE) { form_data.comment_img = get_haoping_img(); }
        if (Date.parse(new Date(form_data.start_time)) > Date.parse(new Date(form_data.end_time))) {show_error_message('任务结束时间不能小于任务开始时间'); return;}
        if (Date.parse(new Date()) > Date.parse(new Date(form_data.end_time))) {show_error_message('任务结束时间不能小于当前时间'); return;}
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

// init field   
    if (parent_order_data_attribute != null) {
        // 模版ID
        if (parent_order_data_attribute.template_id != null) {
            $("#template_id").val(parent_order_data_attribute.template_id);
        }
        // 任务入口和入口详情
        var task_method =  parent_order_data_attribute.task_method;
        if (task_method != null) {
            var task_method_value = ['App搜索模式', 'Pid模式'];
            for (var i = 0; i < task_method_value.length; i++) {
                if (task_method_value[i] == parent_order_data_attribute.task_method) {
                    $('.task_method')[i].click();
                }
            }
        }
        // 人数
        if (parent_order_data_attribute.buyer_cnt > 0) {
            $(":input[name='buyer_cnt']").val(parent_order_data_attribute.buyer_cnt);
        }
        // 下单类型
        var order_type = parent_order_data_attribute.order_type;
        if (order_type != null) {
            var order_type_value = ['有团参团/无团再开', '开团', '单买', '必须参团'];
            for (var i = 0; i < order_type_value.length; i++) {
                if (order_type_value[i] == order_type) {
                    $('.order_type')[i].click();
                }
            }
        }else{
            $('.order_type')[0].click();
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
        //分享到朋友圈 
        if (parent_order_data_attribute.is_wechat_share != null) {
            var is_wechat_share_radio_id = (parent_order_data_attribute.is_wechat_share == 'na') ? 1 : 0;
            $(":input[name='is_wechat_share']")[is_wechat_share_radio_id].click();
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
        // 放单模式
        if (parent_order_data_attribute.is_preferred != null) {
            var is_preferred_radio_id = (parent_order_data_attribute.is_preferred == 'na') ? 0 : 1;
            $(":input[name='is_preferred']")[is_preferred_radio_id].click();
        }
        //任务单数
        if (parent_order_data_attribute.task_cnt != null) {
            $(":input[name='task_cnt']").val(parent_order_data_attribute.task_cnt);
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
    }else{        
        $('.task_method')[0].click();
    }
});