<div class="navbar">
    <div class="navbar-inner">
        <div class="left sliding">
            <a href="#" class="back link"><i class="icon icon-back"></i><span>返回</span></a>
        </div>
        <div class="center sliding"  >
            <?php
            if ( isset( $navbar_title ) ) {
                echo $navbar_title;
            } else {
                echo HILTON_NAME;
            }
            ?>
        </div>

    </div>
</div>
<div class="pages navbar-through fixed-through">
    <div data-page="cert-realname" class="page" >
        <div class="page-content">
            <div class="eula eula-area"><?php $this->load->view('eula_cert'); ?><a id="btn-eula-confirm" href="#" class="button button-big button-fill color-green">我已阅读并接受</a></div>
            <?php if ( isset($cert_msg) ) : ?>
            <div class="content-block" style="margin:10px 5px;text-align:center;">
                <span style="font-size:20px;color:red;"><?php echo $cert_msg; ?></span>
            </div>
            <?php endif ?>
            <form id="cert_form" style="display:none;">
                <div class="list-block">
                    <ul>
                        <li class="item-content">
                            <div class="item-inner">
                                <div class="item-title label">真实姓名</div>
                                <div class="item-input">
                                    <input type="text" name="true_name" placeholder="请填写姓名">
                                </div>
                            </div>
                        </li>
                        <li class="item-content">
                            <div class="item-inner">
                                <div class="item-title label">身份证号</div>
                                <div class="item-input">
                                    <input type="text" name="id_card_num" placeholder="请填写身份证号码">
                                </div>
                            </div>
                        </li>
                        <li class="item-content">
                            <div class="item-inner">
                                <div class="item-title label">QQ号</div>
                                <div class="item-input">
                                    <input type="number" name="qq_num" placeholder="请填写QQ号码" onmousewheel="return false;" min="0"/>
                                </div>
                            </div>
                        </li>
                        <li class="item-content">
                            <div class="item-inner">
                                <div class="item-title label">银行卡号<br><span style="font-size:8px;color:red;">必须为本人银行卡</span></div>
                                <div class="item-input">
                                    <input type="number" name="bank_card_num" placeholder="请填写本人的银行卡" onmousewheel="return false;" min="0">
                                </div>
                            </div>
                        </li>
                        <li class="item-content">
                            <div class="item-inner">
                                <div class="item-title label">开户银行</div>
                                <div class="item-input">
                                    <select name="bank_name">
                                        <option value="" selected>请选择开户银行</option>
                                        <option value="招商银行">招商银行</option>
                                        <option value="中国工商银行">中国工商银行</option>
                                        <option value="中国农业银行">中国农业银行</option>
                                        <option value="中国银行">中国银行</option>
                                        <option value="中国建设银行">中国建设银行</option>
                                        <option value="交通银行">交通银行</option>
                                        <option value="中信银行">中信银行</option>
                                        <option value="光大银行">光大银行</option>
                                        <option value="华夏银行">华夏银行</option>
                                        <option value="民生银行">民生银行</option>
                                        <option value="广发银行">广发银行</option>
                                        <option value="平安银行">平安银行</option>
                                        <option value="兴业银行">兴业银行</option>
                                        <option value="上海浦东发展银行">上海浦东发展银行</option>
                                        <option value="北京银行">北京银行</option>
                                        <option value="南京银行">南京银行</option>
                                        <option value="江苏银行">江苏银行</option>
                                        <option value="宁波银行">宁波银行</option>
                                        <option value="上海银行">上海银行</option>
                                        <option value="杭州银行">杭州银行</option>
                                        <option value="农村商业银行">农村商业银行</option>
                                    </select>
                                </div>
                            </div>
                        </li>
                        <li class="item-content">
                            <div class="item-inner">
                                <div class="item-title label">开户地区</div>
                                <div class="item-input">
                                    <select name="province" id="province">
                                        <option value="">请选择省份</option>
                                    </select>
                                    <select name="city" id="city">
                                        <option value="">请选择城市</option>
                                    </select>
                                    <select name="county" id="county">
                                        <option value="">请选择地区</option>
                                    </select>
                                </div>
                            </div>
                        </li>
                        <li class="item-content">
                            <div class="item-inner">
                                <div class="item-title label">开户支行<br><span style="font-size:8px;color:red;">可联系发卡银行咨询</span></div>
                                <div class="item-input">
                                    <input type="text" name="bank_branch" placeholder="请填写开户支行">
                                </div>
                            </div>
                        </li>
                        <li class="item-content" style="display:block;padding:15px 10px;">
                            <div class="row" style="margin-top:20px;">
                                <div class="col-50" style="text-align:center;">
                                    <div class="btn-show-tips" data-tip-url="<?php echo CDN_BINARY_URL; ?>tips/id_card.jpg">查看示例</div>
                                    <div class="tieyu-icon image-upload-container">
                                        <img data-input-name="id_card_pic" class="image-upload" src="<?php echo CDN_BINARY_URL; ?>cross.png">
                                        <div class="image-uppload-tips">身份证<br/>正面照</div>
                                        <input type="hidden" name="id_card_pic">
                                    </div>
                                </div>
                                <div class="col-50" style="text-align:center;">
                                    <div class="btn-show-tips" data-tip-url="<?php echo CDN_BINARY_URL; ?>tips/half_body.jpg">查看示例</div>
                                    <div class="tieyu-icon image-upload-container">
                                        <img data-input-name="half_body_pic" class="image-upload" src="<?php echo CDN_BINARY_URL; ?>cross.png">
                                        <div class="image-uppload-tips">手持身份证<br/>正面半身照</div>
                                        <input type="hidden" name="half_body_pic">
                                    </div>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
                <div class="list-block inset">
                    <div>
                        <a href="#" id="btn_submit_cert" class="button button-big button-fill color-blue" data-url="<?php echo base_url('requests/cert_handle'); ?>">提交认证</a>
                    </div>
                </div>
                <div class="list-block inset">
                    <div>
                        <a class="button button-big button-fill color-red external" href="<?php echo base_url('user/log_out'); ?>">安全退出</a>
                    </div>
                </div>
                <div style="height:50px;"></div>
            </form>
        </div>
    </div>
</div>