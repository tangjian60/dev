<div class="navbar">
    <div class="navbar-inner">
        <div class="left sliding">
            <a href="#" class="back link"><i class="icon icon-back"></i><span>返回</span></a>
        </div>
        <div class="center sliding" >
            <?php
            if (isset($navbar_title)) {
                echo $navbar_title;
            } else {
                echo HILTON_NAME;
            }
            ?>
        </div>
    </div>
</div>
<div class="pages navbar-through fixed-through">
    <div data-page="bind-account-huabei" class="page">
        <div class="page-content">
            <div class="list-block">
                <ul>
                    <li class="item-content">
                        <div class="item-inner">
                            <div class="item-title label">淘宝会员名</div>
                            <div class="item-input">
                                <input type="text" name="tb_nick" value="<?php echo $bind_info->tb_nick; ?>" readonly>
                            </div>
                        </div>
                    </li>
                    <li class="item-content" style="display:block;padding:15px 10px;">
                        <div class="row" style="margin-top:20px;">
                            <div class="col-50" style="text-align:center;">
                                <div class="btn-show-tips" data-tip-url="<?php echo CDN_BINARY_URL; ?>tips/tb_huabei.jpg">查看示例</div>
                                <div class="tieyu-icon image-upload-container">
                                    <img data-input-name="tb_huabei_pic" class="image-upload" src="<?php echo CDN_BINARY_URL; ?>cross.png">
                                    <div class="image-uppload-tips">花呗<br>截图</div>
                                    <input id="tb_huabei_pic" type="hidden" name="tb_huabei_pic">
                                </div>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
            <div class="list-block inset">
                <div>
                    <a href="#" id="btn_submit_bind" class="button button-big button-fill color-blue" data-url="<?php echo base_url('requests/bind_huabei_handle'); ?>" data-bind-id="<?php echo $bind_info->id; ?>">提交</a>
                </div>
            </div>
        </div>
    </div>
</div>