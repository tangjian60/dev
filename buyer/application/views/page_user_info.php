<div class="navbar">
    <div class="navbar-inner">
        <div class="left sliding">
            <a href="#" class="back link"><i class="icon icon-back"></i><span>返回</span></a>
        </div>
        <div class="center sliding" style="margin-left: 53%;position: absolute;">
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
    <div data-page="auth_taobao_list" id="auth_taobao_list" class="page">
        <div class="page-content ">
            <div class="content-block" style="margin: 0px;">
                <div class="content-block-inner">
                    <p style="text-align: center;">
                        <img src="<?php echo CDN_BINARY_URL; ?>icon/user_pic.png" style="margin: 0 auto;">
                    </p>
                </div>
            </div>
            <div class="list-block">
                <ul>
                    <li>
                        <div class="item-content">
                            <div class="item-media">
                                <span class="justify-words">账号</span>
                            </div>
                            <div class="item-inner">
                                <div class="label"><?php echo $user_info->user_name; ?></div>
                            </div>
                        </div>
                    </li>
                    <li>
                        <div class="item-content">
                            <div class="item-media">
                                <span class="justify-words">会员等级</span>
                            </div>
                            <div class="item-inner">
                                <div class="label"><?php echo user_rank($user_info->id); ?></div>
                            </div>
                        </div>
                    </li>
                    <li>
                        <div class="item-content">
                            <div class="item-media">
                                <span class="justify-words">注册时间</span>
                            </div>
                            <div class="item-inner">
                                <div class="label"><?php echo substr($user_info->reg_time, 0, 10); ?></div>
                            </div>
                        </div>
                    </li>
                    <?php if ( !empty($cert_info) ) : ?>
                    <li>
                        <div class="item-content">
                            <div class="item-media">
                                <span class="justify-words">姓名</span>
                            </div>
                            <div class="item-inner">
                                <div class="label"><?php echo $cert_info->true_name ?></div>
                            </div>
                        </div>
                    </li>
                    <li>
                        <div class="item-content">
                            <div class="item-media">
                                <span class="justify-words">身份证</span>
                            </div>
                            <div class="item-inner">
                                <div class="label"><?php echo desensitization( $cert_info->id_card_num ); ?></div>
                            </div>
                        </div>
                    </li>
                    <li>
                        <div class="item-content">
                            <div class="item-media">
                                <span class="justify-words">开户银行</span>
                            </div>
                            <div class="item-inner">
                                <div class="label"><?php echo $cert_info->bank_name; ?></div>
                            </div>
                        </div>
                    </li>
                    <li>
                        <div class="item-content">
                            <div class="item-media">
                                <span class="justify-words">银行卡号</span>
                            </div>
                            <div class="item-inner">
                                <div class="label"><?php echo desensitization( $cert_info->bank_card_num ); ?></div>
                            </div>
                        </div>
                    </li>
                    <li>
                        <div class="item-content">
                            <div class="item-media">
                                <span class="justify-words">开户地区</span>
                            </div>
                            <div class="item-inner">
                                <div class="label"><?php echo $cert_info->bank_province.$cert_info->bank_city.$cert_info->bank_county; ?></div>
                            </div>
                        </div>
                    </li>
                    <li>
                        <div class="item-content">
                            <div class="item-media">
                                <span class="justify-words">开户支行</span>
                            </div>
                            <div class="item-inner">
                                <div class="label"><?php echo $cert_info->bank_branch; ?></div>
                            </div>
                        </div>
                    </li>
                    <li>
                        <div class="item-content">
                            <div class="item-media">
                                <span class="justify-words">QQ号码</span>
                            </div>
                            <div class="item-inner">
                                <div class="label"><?php echo $cert_info->qq_num; ?></div>
                            </div>
                        </div>
                    </li>
                    <?php endif ?>
                </ul>
            </div>
        </div>
    </div>
</div>
