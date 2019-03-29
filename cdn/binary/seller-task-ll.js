$(function () {
    var task_method_details_search = '<input placeholder="搜索关键字" class="form-control" type="text" name="task_method_details">';
    var task_method_details_share = '<input placeholder="推广链接" class="form-control" type="text" name="task_method_details">';
    var task_method_details_tkl = '<input placeholder="淘口令" class="form-control" type="text" name="task_method_details">';
    var task_method_details_pic = '<div class="tieyu-icon image-upload-container"><img data-upload-server="' + CDN_UPLOAD_URL + '" data-input-name="task_method_details" class="image-upload" src="' + CDN_BINARY_URL + 'cross.png"><input type="hidden" name="task_method_details"></div>';
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
    $('.task_method').click(function () {
        var method = $(this).val();
        var target_ele = $('#task_method_details');
        if (method == '搜索') {
            if (parent_order_data_attribute != null && parent_order_data_attribute.task_method == '搜索' && parent_order_data_attribute.task_method_details != null) {
                target_ele.html('<input placeholder="搜索关键字" class="form-control" type="text" name="task_method_details" value="' + parent_order_data_attribute.task_method_details  + '">');
                $('.task-key-word').html(task_key_word_area + task_key_word_area_add);
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
                $('#input_order_cnt').val("1");
                $('#input_order_cnt').attr('readonly', true);
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
                $('#input_order_cnt').removeAttr("readonly");
                $('#input_order_cnt').val("");
            }
        } else if (method == '淘口令') {
            if (parent_order_data_attribute != null && parent_order_data_attribute.task_method == '淘口令' && parent_order_data_attribute.task_method_details != null) {
                $('.task-key-word').html('<input placeholder="淘口令" class="form-control" type="text" name="task_method_details" value="' + parent_order_data_attribute.task_method_details  + '">');
                $('#sort_type').show();
            }else{
                $('.task-key-word').html(task_method_details_tkl);
                $('#sort_type').show();
                $('#input_order_cnt').removeAttr("readonly");
                $('#input_order_cnt').val("");
            }
        } else if (method == '聚划算') {
            if (parent_order_data_attribute != null && parent_order_data_attribute.task_method == '聚划算' && parent_order_data_attribute.task_method_details != null) {
                $('.task-key-word').html('<div class="tieyu-icon image-upload-container"><img data-upload-server="' + CDN_UPLOAD_URL + '" data-input-name="task_method_details" class="image-upload" src="' + CDN_DOMAIN + parent_order_data_attribute.task_method_details + '"><input type="hidden" name="task_method_details" value="' + parent_order_data_attribute.task_method_details + '"></div>');
                $('#sort_type').show();
            }else{
                $('.task-key-word').html(task_method_details_pic);
                $('#sort_type').show();
                $('#input_order_cnt').removeAttr("readonly");
                $('#input_order_cnt').val("");
            }
            bind_image_upload_event();
        } else if (method == '淘抢购') {
            if (parent_order_data_attribute != null && parent_order_data_attribute.task_method == '淘抢购' && parent_order_data_attribute.task_method_details != null) {
                $('.task-key-word').html('<div class="tieyu-icon image-upload-container"><img data-upload-server="' + CDN_UPLOAD_URL + '" data-input-name="task_method_details" class="image-upload" src="' + CDN_DOMAIN + parent_order_data_attribute.task_method_details + '"><input type="hidden" name="task_method_details" value="' + parent_order_data_attribute.task_method_details + '"></div>');
                $('#sort_type').show();
            }else{
                $('.task-key-word').html(task_method_details_pic);
                $('#sort_type').show();
                $('#input_order_cnt').removeAttr("readonly");
                $('#input_order_cnt').val("");
            }
            bind_image_upload_event();
        } else if (method == '天天特价') {
            if (parent_order_data_attribute != null && parent_order_data_attribute.task_method == '天天特价' && parent_order_data_attribute.task_method_details != null) {
                $('.task-key-word').html('<div class="tieyu-icon image-upload-container"><img data-upload-server="' + CDN_UPLOAD_URL + '" data-input-name="task_method_details" class="image-upload" src="' + CDN_DOMAIN + parent_order_data_attribute.task_method_details + '"><input type="hidden" name="task_method_details" value="' + parent_order_data_attribute.task_method_details + '"></div>');
                $('#sort_type').show();
            }else{
                $('.task-key-word').html(task_method_details_pic);
                $('#sort_type').show();
                $('#input_order_cnt').removeAttr("readonly");
                $('#input_order_cnt').val("");
            }
            bind_image_upload_event();
        } else {
            $('.task-key-word').html('');
        }
    });
    $(document).on("keyup", ".task-task-number", function (e) {
        e.preventDefault();
        var task_number = update_task_number();
        $('#input_order_cnt').attr('readonly', true);
        $('#input_order_cnt').val(task_number);
        update_price();
    });
    $(document).on("click", ".task-add-key-word", function (e) {
        e.preventDefault();
        $(this).parent('.col-md-8').before(task_key_word_area);
        var task_number = update_task_number();
        $('#input_order_cnt').val(task_number);
        update_price();
    });
    $(document).on("click", ".btn-remove-key-word", function (e) {
        e.preventDefault();
        $(this).parent(".col-md-1").prev().remove();
        $(this).parent(".col-md-1").remove();
        var task_number = update_task_number();
        $('#input_order_cnt').val(task_number);
        update_price();
    });
    // $('.sort_type').click(function () {
    //     if ($(this).val() == '销量') {
    //         $('.buyer_count_label').html('收货');
    //     } else {
    //         $('.buyer_count_label').html('付款');
    //     }
    // });
    $('.is_preferred').click(function () {
        if ($(this).val() == NOT_AVAILABLE) {
            $('#tips-is-preferred').html('');
        } else {
            $('#tips-is-preferred').html('+ ' + CNY_YOUXIAN + ' 元');
        }
        update_price();
    });
    $('.favorite_shop').click(function () {
        if ($(this).val() == NOT_AVAILABLE) {
            $('#tips-favorite-shop').html('');
        } else {
            $('#tips-favorite-shop').html('+ ' + CNY_SC_DIANPU + ' 元');
        }
        update_price();
    });
    $('.favorite_item').click(function () {
        if ($(this).val() == NOT_AVAILABLE) {
            $('#tips-favorite-item').html('');
        } else {
            $('#tips-favorite-item').html('+ ' + CNY_SC_SHANGPIN + ' 元');
        }
        update_price();
    });
    $('.add_cart').click(function () {
        if ($(this).val() == NOT_AVAILABLE) {
            $('#tips-add-cart').html('');
        } else {
            $('#tips-add-cart').html('+ ' + CNY_JIAGOU + ' 元');
        }
        update_price();
    });
    $('#input_order_cnt').keyup(function () {
        update_price();
    });
    $('#btn-task-go').click(function (e) {
        e.preventDefault();
        var form_data = $('.form-task-liuliang').formToJSON();
        var that = $(this);
        hide_error_message();
        if (form_data.sku == "") {form_data.sku = "任意"}
        if (form_data.hand_out_interval == "") {form_data.hand_out_interval = "0";}
        if (parseInt(form_data.hand_out_interval) > 500) { show_error_message('放单时间间隔不能大于500分钟'); return; }
        if (form_data.task_method == '搜索') {
            if (typeof(form_data.sort_type) == 'string') {
                if (!form_data.task_method_details || !form_data.task_number) {show_error_message('关键词和单数不能为空'); return;}
            }else{
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

        if (invalid_parameter(form_data)) {show_error_message('所有字段均不能为空，请填写所有字段');return;}
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
    function update_price() {
        var form_data = $('.form-task-liuliang').formToJSON();
        var t_commission = CNY_LIULIANG;
        if (form_data.is_preferred && form_data.is_preferred != NOT_AVAILABLE) {
            t_commission += CNY_YOUXIAN;
        }
        if (form_data.favorite_shop && form_data.favorite_shop != NOT_AVAILABLE) {
            t_commission += CNY_SC_DIANPU;
        }
        if (form_data.favorite_item && form_data.favorite_item != NOT_AVAILABLE) {
            t_commission += CNY_SC_SHANGPIN;
        }
        if (form_data.add_cart && form_data.add_cart != NOT_AVAILABLE) {
            t_commission += CNY_JIAGOU;
        }
        var t_cnt = string_to_int(form_data.task_cnt);
        var total = t_cnt * t_commission;
        $('#commission_amount').html(t_commission.toFixed(2));
        $('#task_cnt').html(t_cnt);
        $('#total_amount').html(total.toFixed(2));
    }
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
        // 任务入口和入口详情
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
        // 放单模式
        if (parent_order_data_attribute.is_preferred != null) {
            var is_preferred_radio_id = (parent_order_data_attribute.is_preferred == 'na') ? 0 : 1;
            $(":input[name='is_preferred']")[is_preferred_radio_id].click();
        }
        //收藏店铺
        if (parent_order_data_attribute.favorite_shop != null) {
            var favorite_shop_radio_id = (parent_order_data_attribute.favorite_shop == 'na') ? 1 : 0;
            $(":input[name='favorite_shop']")[favorite_shop_radio_id].click();
        }
        //收藏宝贝
        if (parent_order_data_attribute.favorite_item != null) {
            var favorite_item_radio_id = (parent_order_data_attribute.favorite_item == 'na') ? 1 : 0;
            $(":input[name='favorite_item']")[favorite_item_radio_id].click();
        }
        //加购物车
        if (parent_order_data_attribute.add_cart != null) {
            var add_cart_radio_id = (parent_order_data_attribute.add_cart == 'na') ? 1 : 0;
            $(":input[name='add_cart']")[add_cart_radio_id].click();
        }
        //任务时间范围
        // if (parent_order_data_attribute.start_time != null) {
        //     $(":input[name='start_time']").val(parent_order_data_attribute.start_time);
        // }
        // if (parent_order_data_attribute.end_time != null) {
        //     $(":input[name='end_time']").val(parent_order_data_attribute.end_time);
        // }
        //任务单数
        if (parent_order_data_attribute.task_cnt != null) {
            $(":input[name='task_cnt']").val(0);
        }
        //放单时间间隔（分钟）
        if (parent_order_data_attribute.hand_out_interval != null) {
            $(":input[name='hand_out_interval']").val(parent_order_data_attribute.hand_out_interval);
        }
        update_price();
    }else{
        $('.favorite_item')[0].click();
        $('.favorite_shop')[0].click();
        $('.add_cart')[0].click();
        $('.task_method')[0].click();
    }
});