<div class="navbar">
    <div class="navbar-inner">
        <div class="left sliding">
            <a href="#" class="back link"><i class="icon icon-back"></i><span>返回</span></a>
        </div>
        <div class="center sliding" style="margin-left: 53%;position: absolute;">
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
    <div data-page="page-withdraw" class="page">
        <div class="page-content">
            <div class="list-block" style="margin-top:15px;">
                <ul>
                    <li>
                        <div class="item-content">
                            <div class="item-inner">
                                <input type="number" id="input-user-benjin-withdraw" placeholder="请输入本金提现金额" style="border:1px solid #a0a0a0;border-radius:5px;margin-right:12px;height:40px;width: 70%;" onmousewheel="return false;" min="0">
                                <a id="btn-user-benjin-withdraw" data-min-amount-benjin="<?php echo MIN_WITHDRAW_AMOUNT; ?>" data-balance-benjin="<?php echo $user_info->balance_capital; ?>" data-balance-benjin="<?php echo $user_info->balance_capital; ?>" data-freezing-amount-benjin="<?php echo $user_info->freezing_capital_amount; ?>" data-url="<?php echo base_url('requests/withdraw_handle'); ?>" href="#" class="button button-big button-fill" style="background-color:#FF4400;width:90px;height:40px;">本金提现</a>
                            </div>
                        </div>
                        <div class="item-content">
                            <div class="item-inner">
                                <span style="font-size:16px;color:black;margin-left:20px;">
                                    本金余额<span class="important-numbers"><?php echo $user_info->balance_capital; ?></span>元，
                                    <?php
                                        if ($user_info->freezing_capital_amount > 0) {
                                            echo '冻结本金金额<span class="important-numbers">' . $user_info->freezing_capital_amount . '</span>元，';
                                        }
                                    ?>
                                   可提<span class="important-numbers"><?php echo $user_info->balance_capital; ?></span>元
                                </span>
                            </div>
                        </div>
                    </li>
                    <li>
                        <div class="item-content">
                            <div class="item-inner">
                                <input type="number" id="input-user-yongjin-withdraw" placeholder="请输入佣金提现金额" style="border:1px solid #a0a0a0;border-radius:5px;margin-right:12px;height:40px;width:70%;" onmousewheel="return false;" min="100">
                                <a id="btn-user-yongjin-withdraw" data-min-amount-yongjin="<?php echo MIN_WITHDRAW_AMOUNT; ?>" data-balance-yongjin="<?php echo $user_info->balance_commission; ?>" data-freezing-amount-yongjin="<?php echo $user_info->freezing_commission_amount; ?>" data-url="<?php echo base_url('requests/withdraw_handle'); ?>" href="#" class="button button-big button-fill" style="background-color:#FF4400;width:90px;height:40px;">佣金提现</a>
                            </div>
                        </div>
                        <div class="item-content">
                            <div class="item-inner">
                                <span style="font-size:16px;color:black;margin-left:20px;">
                                    佣金余额<span class="important-numbers"><?php echo $user_info->balance_commission; ?></span>元，
                                    <?php
                                        if ($user_info->freezing_commission_amount > 0) {
                                            echo '冻结佣金金额<span class="important-numbers">' . $user_info->freezing_commission_amount . '</span>元，';
                                        }
                                    ?>
                                    最少提现金额<span class="important-numbers"><?php echo MIN_WITHDRAW_AMOUNT; ?></span>元
                                    佣金提现将收取<span class="important-numbers">1%</span>的手续费
                                </span>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
            <div class="content-block" style="margin-top:10px;">
                <p>
                <div style="font-size:20px;"><strong>重要提醒:</strong></div>
                <ol style="list-style-type:decimal;padding-left:15px;">
                    <li>提现金额单位是元，不支持角分提现</li>
                    <li>最少提现金额为<?php echo MIN_WITHDRAW_AMOUNT; ?>元</li>
                    <li>银行卡请绑定我们指定的银行</li>
                    <li>如提现未到帐,首先请检查所绑定的银行卡信息是否正确.（银行卡填写错误，请联系客服解绑重新绑定，如有银行退回，我们会重新返款）</li>
                    <li>提现时间16:00前，打款时间：16:00【16:00后提现的第二天16:00统一打款】，具体的到账时间根据银行受理情况决定，头一天下午四点后提现的和当天下午四点前提现的总金额会一笔打过去，请注意核对金额</li>
                    <li>如需查询您的金额是否到账，请在1-3个工作日之内查询。（双休，节假日，特殊情况除外）</li>
                    <li>如未收到提现金额，请联系平台客服。（请通过网上银行，手机银行，银行营业大厅去查询。不要通过非银行的第三方软件查询，否则不予受理)</li>
                    <li>平台周日和法定节假日休息，提现不打款，统一在下一个工作日16:00打款</li>
                </ol>
                </p>
            </div>
        </div>
    </div>
</div>
