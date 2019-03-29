<div class="list-block media-list" style="margin-top: 0px;">
    <ul>
        <li>
            <a href="<?php echo $url; ?>" class="item-content item-link">
                <div class="item-media"><img src="<?php echo CDN_BINARY_URL; ?>icon/user_pic.png"></div>
                <div class="item-inner">
                    <div class="item-title-row">
                        <div class="item-title" style="font-size:20px;font-weight:bold;color:#636369;margin-left:15px;">
                            <span class="tieyu-back-blue tieyu-max-font tieyu-icon-radius">
                                <?php
                                if ($isAuthed)
                                    echo "已通过实名认证";
                                else
                                    echo "账号未实名认证，去认证";
                                ?>
                            </span>
                            <br>
                            <?php echo $user_name;?>
                        </div>
                    </div>
                </div>
            </a>
        </li>
    </ul>
</div>
<div class="content-block-title">功能选项</div>
<div class="list-block">
    <ul>
        <li>
            <a href="<?php echo base_url('pages/bills'); ?>" class="item-content item-link">
                <div class="item-media"><img class="setting-icon" src="<?php echo CDN_BINARY_URL; ?>icon/bills.png"></div>
                <div class="item-inner">
                    <div class="item-title">账单</div>
                    <div class="item-after"></div>
                </div>
            </a>
        </li>
        <li>
            <a href="<?php echo base_url('pages/balance'); ?>" class="item-content item-link">
                <div class="item-media"><img class="setting-icon" src="<?php echo CDN_BINARY_URL; ?>icon/bills.png"></div>
                <div class="item-inner">
                    <div class="item-title">本金/佣金</div>
                    <div class="item-after"></div>
                </div>
            </a>
        </li>
        <li>
            <a href="<?php echo base_url('withdraw'); ?>" class="item-content item-link">
                <div class="item-media"><img class="setting-icon" src="<?php echo CDN_BINARY_URL; ?>icon/withdraw.png"></div>
                <div class="item-inner">
                    <div class="item-title">提现</div>
                    <div class="item-after"></div>
                </div>
            </a>
        </li>
        <li>
            <a href="<?php echo base_url('withdraw/records'); ?>" class="item-content item-link">
                <div class="item-media"><img class="setting-icon" src="<?php echo CDN_BINARY_URL; ?>icon/withdraw_record.png"></div>
                <div class="item-inner">
                    <div class="item-title">提现记录</div>
                    <div class="item-after"></div>
                </div>
            </a>
        </li>
        <li>
            <a href="<?php echo base_url('pages'); ?>" class="item-content item-link">
                <div class="item-media"><img class="setting-icon" src="<?php echo CDN_BINARY_URL; ?>icon/taobao.png"></div>
                <div class="item-inner">
                    <div class="item-title">绑定新的淘宝帐号</div>
                    <div class="item-after"></div>
                </div>
            </a>
        </li>
       <!--  <li>
            <a href="<?php echo base_url('pages/pdd_bind'); ?>" class="item-content item-link">
                <div class="item-media"><img class="setting-icon" src="<?php echo CDN_BINARY_URL; ?>icon/pinduoduo.jpg"></div>
                <div class="item-inner">
                    <div class="item-title">绑定新的拼多多帐号</div>
                    <div class="item-after"></div>
                </div>
            </a>
        </li> -->
        <li>
            <a href="<?php echo base_url('pages/binded_account'); ?>" class="item-content item-link">
                <div class="item-media"><img class="setting-icon" src="<?php echo CDN_BINARY_URL; ?>icon/bind_record.png"></div>
                <div class="item-inner">
                    <div class="item-title">已绑定的帐号</div>
                    <div class="item-after"></div>
                </div>
            </a>
        </li>
        <?php if (!$is_special):?>
        <li>
            <a href="<?php echo base_url('pages/promote'); ?>" class="item-content item-link">
                <div class="item-media"><img class="setting-icon" src="<?php echo CDN_BINARY_URL; ?>icon/promote.png"></div>
                <div class="item-inner">
                    <div class="item-title">推广赚金</div>
                    <div class="item-after"></div>
                </div>
            </a>
        </li>
        <?php endif;?>
        <li>
            <a href="<?php echo base_url('pages/rules'); ?>" class="item-content item-link">
                <div class="item-media"><img class="setting-icon" src="<?php echo CDN_BINARY_URL; ?>icon/promote.png"></div>
                <div class="item-inner">
                    <div class="item-title">买手必读</div>
                    <div class="item-after"></div>
                </div>
            </a>
        </li>
    </ul>
</div>
<div class="content-block-title">联系我们</div>
<div class="list-block">
    <div class="list-group">
        <ul>
            <li>
                <a href="#" class="item-content">
                    <div class="item-inner">
                        <div class="item-title">官方QQ群</div>
                        <div class="item-after"><?php echo CUSTOM_SERVICE_QQ; ?></div>
                    </div>
                </a>
            </li>
            <li>
                <a href="#" class="item-content">
                    <div class="item-inner">
                        <div class="item-title">官方微信</div>
                        <div class="item-after"><?php echo CUSTOM_SERVICE_WECHAT; ?></div>
                    </div>
                </a>
            </li>
        </ul>
    </div>
</div>
<div class="content-block inset">
    <p>
        <a class="button button-big button-fill color-red external" href="<?php echo base_url('user/log_out'); ?>">安全退出</a>
    </p>
</div>
<div style="height:80px;"></div>