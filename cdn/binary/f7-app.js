const CODE_SUCCESS = 0;
const UPLOAD_IMAGE_SIZE = 1080;
const UPLOAD_IMAGE_QUALITY = 0.3;
const ITEMS_PER_LOAD = 30;
const MAX_WAITING_TIME = 60;
var $$ = Dom7;
var number = /^\d{1,}$/;
var mobile_num_pattern = /^1[0-9]{10}$/
const CDN_DOMAIN = '//cdn.zcm889.com';
const CDN_UPLOAD_URL = '//cdn.zcm889.com:7070';

var f7 = new Framework7(
    {
        pushState: false,
        modalTitle: false,
        modalButtonOk: "确认",
        modalButtonCancel: "取消",
        modalPreloaderTitle: "加载中...",
        cache: false,
        imagesLazyLoadThreshold: 10,
        imagesLazyLoadSequential: false,
        tapHold: true, 
        onAjaxStart: function (xhr) {
            f7.showIndicator();
        },
        onAjaxComplete: function (xhr) {
            f7.hideIndicator();
        },
        onAjaxError: function (xhr) {
            f7.hideIndicator();
        },
        onPageInit: function (app, page) {
            if (page.name == 'app-main') {
                app_init(app);
            } else if (page.name == 'cert-realname') {
                cert_init();
            }
        }
    }
);

var mainView = f7.addView('.view-main', {dynamicNavbar: true});

f7.onPageInit('page-withdraw', function () {
    $$('#btn-user-benjin-withdraw').click(function (e) {
        e.preventDefault();
        var balance_capital         = parseInt($$(this).data('balance-benjin'));
        var freezing_capital_amount = parseInt($$(this).data('freezing-amount-benjin'));
        var withdraw_amount         = parseInt($$('#input-user-benjin-withdraw').val());
        if (!number.test($$('#input-user-benjin-withdraw').val())) {
            f7.alert('请填写正确的提现金额');
            return;
        }

        if (withdraw_amount > balance_capital - freezing_capital_amount) {
            f7.alert('提现金额不能超出本金余额减去冻结本金金额');
            return;
        }

        $$(this).attr('disabled', true);

        ajax_request(
            $$(this).data('url'),
            {amount: withdraw_amount, tixian_type:"benjin"},
            function (e) {
                if (e.code == CODE_SUCCESS) {
                    f7.alert('您的提现请求已经受理，请在提现记录中查看', function () {
                        mainView.router.back();
                    });
                } else {
                    f7.alert(e.msg);
                    $$(this).removeAttr('disabled');
                }
            });

    });
    $$('#btn-user-yongjin-withdraw').click(function (e) {
        e.preventDefault();
        var min_amount                  = parseInt($$(this).data('min-amount-yongjin'));
        var balance_commission          = parseInt($$(this).data('balance-yongjin'));
        var freezing_commission_amount  = parseInt($$(this).data('freezing-amount-yongjin'));
        var withdraw_amount             = parseInt($$('#input-user-yongjin-withdraw').val());
        if (!number.test($$('#input-user-yongjin-withdraw').val())) {
            f7.alert('请填写正确的提现金额');
            return;
        }

        if (withdraw_amount < min_amount) {
            f7.alert('提现金额不能低于' + min_amount + '元');
            return;
        }

        if (withdraw_amount > balance_commission - freezing_commission_amount) {
            f7.alert('提现金额不能超出佣金余额减去冻结佣金金额');
            return;
        }

        $$(this).attr('disabled', true);

        ajax_request(
            $$(this).data('url'),
            {amount: withdraw_amount,tixian_type:"yongjin"},
            function (e) {
                if (e.code == CODE_SUCCESS) {
                    f7.alert('您的提现请求已经受理，请在提现记录中查看', function () {
                        mainView.router.back();
                    });
                } else {
                    f7.alert(e.msg);
                    $$(this).removeAttr('disabled');
                }
            });

    });
});

f7.onPageInit('page-withdraw-records', function () {
    var lastIndex = 0;

    $$('#load-more').on('click', function () {
        load_more_record(lastIndex);
        lastIndex += ITEMS_PER_LOAD;
    });
});

f7.onPageInit('bind-account-tb', function () {
    window.s = ["province", "city", "county"];
    window.def_select_name = ["请选择省份", "请选择城市", "请选择区县"];
    _init_area();

    $$('#btn-eula-confirm').click(function (e) {
        e.preventDefault();
        $$('.eula').remove();
        $$('#bind_form').show();
    });

    $$('.btn-show-tips').on('click', function (e) {
        show_photo_gallery($$(this).data('tip-url'));
    });
    $$('#btn_submit_bind').on('click', function (e) {
        var bind_form_data = f7.formToJSON('#bind_form');
        if (invalid_parameter(bind_form_data) || bind_form_data.city == "请选择城市" || bind_form_data.county == "请选择区县" || bind_form_data.province == "请选择省份") {
            f7.alert('所有字段均不能为空，请如实填写所有字段');
            return;
        }
            
        if ((typeof(bind_form_data.tb_receiver_tel) == "undefined") || !mobile_num_pattern.test(bind_form_data.tb_receiver_tel)) {
            f7.alert('请填写正确的手机号码');
            return;
        }

        $$(this).attr('disabled', true);

        ajax_request(
            $$(this).data('url'),
            bind_form_data,
            function (e) {
                if (e.code == CODE_SUCCESS) {
                    f7.alert('账号绑定成功，请等待审核', function () {
                        mainView.router.back();
                    });
                } else {
                    f7.alert(e.msg);
                    $$(this).removeAttr('disabled');
                }
            });
    });

    bind_image_upload_event();
});

f7.onPageInit('bind-account-huabei', function () {
    $$('.btn-show-tips').on('click', function (e) {
        show_photo_gallery($$(this).data('tip-url'));
    });

    $$('#btn_submit_bind').on('click', function (e) {
        var tb_huabei_pic = $$('#tb_huabei_pic').val();

        if (tb_huabei_pic == '') {
            f7.alert('请上传花呗截图');
            return;
        }

        $$(this).attr('disabled', true);

        ajax_request(
            $$(this).data('url'),
            {bind_id: $$(this).data('bind-id'), tb_huabei_pic: tb_huabei_pic},
            function (e) {
                if (e.code == CODE_SUCCESS) {
                    f7.alert('花呗信息提交成功，请等待审核', function () {
                        location.reload();
                    });
                } else {
                    f7.alert(e.msg);
                    $$(this).removeAttr('disabled');
                }
            });
    });

    bind_image_upload_event();
});

f7.onPageInit('bind-change-address', function () {
    window.s = ["province", "city", "county"];
    window.def_select_name = ["请选择省份", "请选择城市", "请选择区县"];
    _init_area();

    $$('#btn_submit_bind').on('click', function (e) {
        var bind_form_data = f7.formToJSON('#bind_form');

        if (invalid_parameter(bind_form_data)) {
            f7.alert('所有字段均不能为空，请如实填写所有字段');
            return;
        }

        $$(this).attr('disabled', true);

        ajax_request(
            $$(this).data('url'),
            bind_form_data,
            function (e) {
                if (e.code == CODE_SUCCESS) {
                    f7.alert('地址修改成功，请等待审核', function () {
                        location.reload();
                    });
                } else {
                    f7.alert(e.msg);
                    $$(this).removeAttr('disabled');
                }
            });
    });
});

f7.onPageInit('page-bills', function () {
    var lastIndex = 0;

    $$('#load-more').on('click', function () {
        load_more_record(lastIndex);
        lastIndex += ITEMS_PER_LOAD;
    });

    $$('#btn_bill_filter').on('click', function () {
        var buttons1 = [
            {
                text: '请选择账单的类型',
                label: true
            },
            {
                text: '全部',
                onClick: function () {
                    rebuild_load('0');
                }
            },
            {
                text: '本金',
                onClick: function () {
                    rebuild_load('1');
                }
            },
            {
                text: '佣金',
                onClick: function () {
                    rebuild_load('2');
                }
            },
            {
                text: '推广',
                onClick: function () {
                    rebuild_load('3');
                }
            },
            {
                text: '提现',
                onClick: function () {
                    rebuild_load('5');
                }
            },
            {
                text: '额外',
                onClick: function () {
                    rebuild_load('6');
                }
            }
        ];
        var buttons2 = [
            {
                text: '取消',
                color: 'red'
            }
        ];
        var groups = [buttons1, buttons2];
        f7.actions(groups);
    });

    function rebuild_load(t) {
        lastIndex = ITEMS_PER_LOAD;
        $$('#b_type').val(t);
        $$('.hilton-infinite-list ul').html('');
        load_more_record(0);
    }
});

f7.onPageAfterAnimation('page-bills page-withdraw-records page-task-list page-appeal-list', function () {
    $$('#load-more').click();
});

f7.onPageInit('page-task-list page-appeal-list', function (page) {
    var lastIndex = 0;
    $$('#load-more').on('click', function () {
        load_more_record(lastIndex);
        lastIndex += ITEMS_PER_LOAD;
    });
});

// TODO... Added by Ryan.
f7.onPageInit('page-task-details-tuotian', function (page) {

    //alert($$('.task_countdown_secs').val());

    $$('.img-show-gallery').on('click', function (e) {
        show_photo_gallery($$(this).attr('src'));
    });

    var ct_sec = $$('.task_countdown_secs').val();
    if (ct_sec > 0) {
        countDown(ct_sec, '.task_counter');
    }

    $$('.btn-check-item-url').on('click', function (e) {
        e.preventDefault();
        var form_data = f7.formToJSON('#form-task-operation');
        var that = $$(this);
        if ((typeof(form_data.check_content) == "undefined") || form_data.check_content == '') {
            f7.alert('请输入正确的店铺名称');
            return;
        }
        ajax_request(
            that.data('url'),
            form_data,
            function (e) {
                if (e.code == CODE_SUCCESS) {
                    that.attr('disabled', true);
                    that.html('核对成功');
                    f7.alert('核对成功');
                } else {
                    f7.alert(e.msg);
                }
            });
    });

    $$('.btn-task-commit').on('click', function (e) {
        e.preventDefault();
        var form_data = f7.formToJSON('#form-task-operation');
        var that = $$(this);

        console.log(form_data);

        if (invalid_parameter(form_data)) {
            f7.alert('请填写所有字段');
            return;
        }

        var is_last_step = $$('input[name="is_last_step"]').val();
        //var is_browse_inner = $$('input[name="is_browse_inner"]').val();

        if (is_last_step == '1') {
            if (parseFloat(form_data.real_task_capital) <= 0 ) {
                f7.alert('实际付款金额不能小于等于0');
                return;
            }
            var real_task_capital   = isNaN(parseFloat(form_data.real_task_capital)) ? 0 : parseFloat(form_data.real_task_capital);
            var pre_task_capital    = isNaN(parseFloat(form_data.pre_task_capital))  ? 0 : parseFloat(form_data.pre_task_capital);
            if (real_task_capital > pre_task_capital) {
                if ((real_task_capital - pre_task_capital) > PRICE_DIFFERENCE) {
                    f7.alert('实付金额与商家垫付本金差额' + PRICE_DIFFERENCE.toString() + '以上，请重新正确填写实付金额。<br>如确实差额' + PRICE_DIFFERENCE.toString() + '以上，请及时联系客服确认或者取消订单。');
                    return;
                }else{
                    f7.confirm('实际付款金额与商家要求垫付本金不同，请仔细核对是否填对实付金额，虚假填写会被封号。',function(){
                        task_commit_ajax(form_data);
                    });
                    return;
                }
            }else{
                task_commit_ajax(form_data);
            }
        } else {
            task_commit_ajax(form_data);
        }

        function task_commit_ajax(form_data){
            ajax_request(
                that.data('url'),
                form_data,
                function (e) {
                    if (e.code == CODE_SUCCESS) {
                        f7.alert('提交成功', function () {
                            location.reload();
                        });
                    } else {
                        f7.alert(e.msg);
                    }
                });
        }
    });


    $$('.btn-haoping-commit-dt').on('click', function (e) {
        e.preventDefault();
        var form_data = f7.formToJSON('#form-task-operation');
        var that = $$(this);
        if ((typeof(form_data.haoping_prove_pic) == "undefined") || form_data.haoping_prove_pic == '') {
            f7.alert('请上传好评截图');
            return;
        }
        ajax_request(
            that.data('url'),
            form_data,
            function (e) {
                if (e.code == CODE_SUCCESS) {
                    f7.alert('提交成功', function () {
                        location.reload();
                    });
                } else {
                    f7.alert(e.msg);
                }
            });
    });

    $$('.btn-show-tips').on('click', function (e) {
        show_photo_gallery($$(this).data('tip-url'));
    });


    bind_image_upload_event();


    //var secs = 60;
    //countDown(60, '.ddx');

    //带天数的倒计时
    function countDown(times, ele){
        var timer=null;
        timer=setInterval(function(){
            var day=0,
                hour=0,
                minute=0,
                second=0;//时间默认值
            if(times > 0){
                day = Math.floor(times / (60 * 60 * 24));
                hour = Math.floor(times / (60 * 60)) - (day * 24);
                minute = Math.floor(times / 60) - (day * 24 * 60) - (hour * 60);
                second = Math.floor(times) - (day * 24 * 60 * 60) - (hour * 60 * 60) - (minute * 60);
            }
            if (day <= 9) day = '0' + day;
            if (hour <= 9) hour = '0' + hour;
            if (minute <= 9) minute = '0' + minute;
            if (second <= 9) second = '0' + second;
            //
            var day_str = '';
            if (day>0) day_str = day + "天";
            var txt = "剩余时间：" + day_str + hour + "小时" + minute + "分钟" + second + "秒";
            //console.log(txt);
            $$(ele).html(txt);
            times--;
        },1000);
        if(times<=0){
            clearInterval(timer);
        }
    }

});



f7.onPageInit('page-task-details', function (page) {
    $$('.img-show-gallery').on('click', function (e) {
        show_photo_gallery($$(this).attr('src'));
    });

    $$('.btn-check-item-url').on('click', function (e) {
        e.preventDefault();
        var form_data = f7.formToJSON('#form-task-operation');
        var that = $$(this);
        if ((typeof(form_data.check_content) == "undefined") || form_data.check_content == '') {
            f7.alert('请输入正确的店铺名称');
            return;
        }
        ajax_request(
            that.data('url'),
            form_data,
            function (e) {
                if (e.code == CODE_SUCCESS) {
                    that.attr('disabled', true);
                    that.html('核对成功');
                    f7.alert('核对成功');
                } else {
                    f7.alert(e.msg);
                }
            });
    });

    $$('.btn-task-save').on('click', function (e) {
        e.preventDefault();
        var form_data = f7.formToJSON('#form-task-operation');
        ajax_request(
            $$(this).data('url'),
            form_data,
            function (e) {
                if (e.code == CODE_SUCCESS) {
                    f7.alert('保存成功');
                } else {
                    f7.alert(e.msg);
                }
            });
    });

    $$('.btn-task-commit').on('click', function (e) {
        e.preventDefault();
        var form_data = f7.formToJSON('#form-task-operation');
        var that = $$(this);

        if (invalid_parameter(form_data)) {
            f7.alert('请填写所有字段');
            return;
        }
        if (parseFloat(form_data.real_task_capital) <= 0 ) {
            f7.alert('实际付款金额不能小于等于0');
            return;
        }
        var real_task_capital   = isNaN(parseFloat(form_data.real_task_capital)) ? 0 : parseFloat(form_data.real_task_capital);
        var pre_task_capital    = isNaN(parseFloat(form_data.pre_task_capital))  ? 0 : parseFloat(form_data.pre_task_capital);
        if (real_task_capital > pre_task_capital) {
            if ((real_task_capital - pre_task_capital) > PRICE_DIFFERENCE) {
                f7.alert('实付金额与商家垫付本金差额' + PRICE_DIFFERENCE.toString() + '以上，请重新正确填写实付金额。<br>如确实差额' + PRICE_DIFFERENCE.toString() + '以上，请及时联系客服确认或者取消订单。');
                return;
            }else{
                f7.confirm('实际付款金额与商家要求垫付本金不同，请仔细核对是否填对实付金额，虚假填写会被封号。',function(){
                    task_commit_ajax(form_data);
                });
                return;
            }
        }else{
            task_commit_ajax(form_data);
        }
        
        function task_commit_ajax(form_data){
            ajax_request(
                that.data('url'),
                form_data,
                function (e) {
                    if (e.code == CODE_SUCCESS) {
                        f7.alert('提交成功', function () {
                            location.reload();
                        });
                    } else {
                        f7.alert(e.msg);
                    }
                });
        }
    });

    $$('.btn-haoping-commit').on('click', function (e) {
        e.preventDefault();
        var form_data = f7.formToJSON('#form-task-operation');
        var that = $$(this);
        if ((typeof(form_data.haoping_prove_pic) == "undefined") || form_data.haoping_prove_pic == '') {
            f7.alert('请上传好评截图');
            return;
        }
        ajax_request(
            that.data('url'),
            form_data,
            function (e) {
                if (e.code == CODE_SUCCESS) {
                    f7.alert('提交成功', function () {
                        location.reload();
                    });
                } else {
                    f7.alert(e.msg);
                }
            });
    });

    $$('.btn-show-tips').on('click', function (e) {
        show_photo_gallery($$(this).data('tip-url'));
    });

    bind_image_upload_event();
});

f7.onPageInit('page-cancel-task', function (page) {
    $$('#btn-cancel-task').on('click', function (e) {
        e.preventDefault();
        var form_data = f7.formToJSON('#form-cancel-task');
        var that = $$(this);

        if (invalid_parameter(form_data)) {
            f7.alert('请选择取消任务的原因');
            return;
        }

        ajax_request(
            that.data('url'),
            form_data,
            function (e) {
                if (e.code == CODE_SUCCESS) {
                    f7.alert('任务取消成功', function () {
                        location.reload();
                    });
                } else {
                    f7.alert(e.msg);
                }
            });
    });
});

f7.onPageInit('page-task-go', function (page) {
    var isec = 0;
    var tsec = 0;

    set_timer(get_random_num(), claim_task_result);

    function claim_task_result() {
        var task_go = $$('.task-go');
        var request_addr = task_go.data('url') + '?task_type=' + page.query.t;

        ajax_load_pages(request_addr, function (e) {
            if (e == "") {
                f7.alert('呀…没有抢到任务，请再试一次吧。<br>原因可能是：<br>1. 当前平台上没有任务<br>2. 你的淘宝号不满足商家的条件<br>3. 你今日的任务已达上限', function () {
                    mainView.router.back();
                });
            } else {
                task_go.html(e);
                bind_event();
            }
        });
    }

    function set_timer(sec, cb) {
        console.log(sec);
        if (!isFinite(sec)) {
            cb();
            return;
        }
        tsec = isec = sec;
        auto_count_down(cb);
    }

    function auto_count_down(cb) {
        $$('.task-go-time span').html(MAX_WAITING_TIME - tsec + isec);

        if (isec <= 0) {
            cb();
            return;
        }

        setTimeout(function () {
            isec--;
            auto_count_down(cb);
        }, 1000);
    }

    function get_random_num() {
        return Math.floor(Math.random() * 5) + 5;
    }

    function bind_event() {
        $$('#btn-task-reject').on('click', function (e) {
            $$(this).attr('disabled', true);
            $$('.btn-task-accept').attr('disabled', true);
            ajax_request(
                $$(this).data('url'),
                {
                    task_type: page.query.t,
                    task_info: $$(this).data('task-info')
                },
                function (e) {
                    mainView.router.back();
                });
        });

        $$('.btn-task-accept').on('click', function (e) {
            $$('.btn-task-accept').attr('disabled', true);
            $$('#btn-task-reject').attr('disabled', true);
            ajax_request(
                $$(this).data('url'),
                {
                    task_type: page.query.t,
                    task_id: $$(this).data('id'),
                    nick_id: $$(this).data('nick-id'),
                    task_info: $$(this).data('task-info')
                },
                function (e) {
                    if (e.code == CODE_SUCCESS) {
                        f7.alert('接单成功，请尽快完成做单', function () {
                            mainView.router.back();
                        });
                    } else {
                        f7.alert(e.msg, function () {
                            mainView.router.back();
                        });
                    }
                });
        });
    }
});

/////////////////////////////////////////////////////////////////////
function app_init(app) {
    $$('.btn-tool-item').click(function (e) {
        e.preventDefault();
        var html_id = $$(this).attr('href');
        ajax_load_pages($$(this).data('request'), function (e) {
            $$(html_id).find(".upscroll-data").html(e);
            var navbar_title = '接单';
            switch(html_id){
                case '#task_hall':
                    navbar_title = '接单';
                    break;
                case '#task_summaries':
                    navbar_title = '做单';
                    break;
                case '#sd_notice':
                    navbar_title = '消息';
                    break;
                case '#settings':
                    navbar_title = '我的';
                    break;
            }
            $$('.center').html(navbar_title);
        });
    });

    $$('.pull-to-refresh-content').on('refresh', function (e) {
        e.preventDefault();
        var target = $$(this).find(".upscroll-data");
        var url = $$(this).data('request');
        setTimeout(function () {
            ajax_load_pages(url, function (e) {
                target.html(e);
            });
            f7.pullToRefreshDone();
        }, 1500);
    });

    $$('.btn-tool-item')[0].click();
}
function cert_init() {
    window.s = ["province", "city", "county"];
    window.def_select_name = ["请选择省份", "请选择城市", "请选择区县"];
    _init_area();

    $$('.btn-show-tips').on('click', function (e) {
        show_photo_gallery($$(this).data('tip-url'));
    });

    $$('#btn-eula-confirm').on('click', function (e) {
        e.preventDefault();
        $$('.eula').remove();
        $$('#cert_form').show();
    });

    $$('#btn_submit_cert').on('click', function (e) {
        var cert_form_data = f7.formToJSON('#cert_form');

        if (invalid_parameter(cert_form_data) || cert_form_data.city == "请选择城市" || cert_form_data.county == "请选择区县" || cert_form_data.province == "请选择省份") {
            f7.alert('所有字段均不能为空，请如实填写所有字段');
            return;
        }

        if ((typeof(cert_form_data.qq_num) == "undefined") || !number.test(cert_form_data.qq_num)) {
            f7.alert('QQ号码格式不正确');
            return;
        }

        if ((typeof(cert_form_data.bank_card_num) == "undefined") || !number.test(cert_form_data.bank_card_num)) {
            f7.alert('银行卡号格式不正确');
            return;
        }

        var id_card = /(^\d{15}$)|(^\d{18}$)|(^\d{17}(\d|X|x)$)/;
        if ((typeof(cert_form_data.id_card_num) == "undefined") || !id_card.test(cert_form_data.id_card_num)) {
            f7.alert('身份证号码格式不正确');
            return;
        }

        $$(this).attr('disabled', true);

        ajax_request(
            $$(this).data('url'),
            cert_form_data,
            function (e) {
                if (e.code == CODE_SUCCESS) {
                    f7.alert('认证信息提交成功', function () {
                        location.reload();
                    });
                } else {
                    f7.alert(e.msg);
                    $('#btn_submit_cert').removeAttr('disabled');
                }
            });
    });

    bind_image_upload_event();
}

function show_photo_gallery(arg) {
    var iphotos = new Array();
    if (arg instanceof Array) {
        iphotos = arg;
    } else {
        iphotos[0] = arg;
    }

    f7.photoBrowser({
        photos: iphotos,
        theme: 'dark',
        toolbar: false,
        backLinkText: '返回',
        swipeToClose: false,
        expositionHideCaptions: true,
        zoom: true,
        ofText: '/',
    }).open();

    $$('.photo-browser-zoom-container').on('taphold',function(e){
        e.preventDefault();
        save_haoping_pic('http:'+iphotos[0]);
    });
}
function save_haoping_pic(url){
    var u = navigator.userAgent;
    if (u.indexOf('Android') > -1 || u.indexOf('Linux') > -1 || u.indexOf('android') > -1) { //安卓手机
        window.android.save_haoping_pic(url);
    }
    console.log(url);
}
function bind_image_upload_event() {
    $$('.image-upload').each(function (i, e) {
        var that = $$(this);
        var input = document.createElement('input');
        input.type = "file";
        input.accept = "image/*";
        input.className = "image-file-uploader";
        input.onchange = function (f) {
            if (!this.files[0]) return;
            lrz(this.files[0], {width: UPLOAD_IMAGE_SIZE, quality: UPLOAD_IMAGE_QUALITY}, function (results) {
                ajax_request(CDN_UPLOAD_URL + '/image_transport.php'
                    , {img_base: encodeURIComponent(results.base64)}
                    , function (data) {
                        if (data.code == CODE_SUCCESS) {
                            $$('input[name="' + that.data('input-name') + '"]').val(data.msg);
                            that.attr('src', CDN_DOMAIN + data.msg);
                        } else {
                            f7.alert(data.msg);
                        }
                    });
            });
        };
        $$(input).insertAfter($$(this));
    });
}

function load_more_record(d_index) {
    $$('#load-more').hide();
    $$('#load-more-preloader').css('display', 'inline-block');

    var request_addr = $$('#load-more').data('url') + '?d_index=' + d_index + '&d_per_page=' + ITEMS_PER_LOAD + '&b_type=' + $$('#b_type').val();
    ajax_load_pages(request_addr, function (e) {
        if (e == "") {
            $$('#load-more').hide();
            $$('#load-more-preloader').hide();
            return;
        } else {
            $$('.hilton-infinite-list ul').append(e);
            $$('#load-more').show();
            $$('#load-more-preloader').hide();
        }
    });
}

