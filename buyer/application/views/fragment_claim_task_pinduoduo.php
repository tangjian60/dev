<?php if (isset($task_info) && isset($task_info->id) && !empty($accounts)) : ?>
    <div class="content-block" style="text-align:center;margin:10px 18px;">
        <span style="font-size:22px;color:black;">(●'ω'●)丿❤<br>哇~&nbsp;&nbsp;抢到<span style="margin:0 8px;color:#FF4400;font-size:26px;">1</span>单</span>
    </div>
    <?php if(SYSTEM_CODE_NAME == 'ZCM'): ?>
        客单价300以下提交审核立返，300以上需要全部完成后返款（收货好评）
    <?php endif; ?>
    <div class="list-block">
        <div class="list-group">
            <ul>
                <li>
                    <a href="#" class="item-content external">
                        <div class="item-inner">
                            <div class="item-title">店铺名：</div>
                            <div class="item-after" style="color:#FF4400;">
                                <?php
                                if (isset($task_info->shop_name)) {
                                    echo mb_substr($task_info->shop_name, 0, 1, "UTF-8") . '****' . mb_substr($task_info->shop_name, -1, 1, "UTF-8");
                                } else {
                                    echo '无';
                                }
                                ?>
                            </div>
                        </div>
                    </a>
                </li>
                <li>
                    <a href="#" class="item-content external">
                        <div class="item-inner">
                            <div class="item-title">任务收益：</div>
                            <div class="item-after" style="color:#FF4400;">
                                <?php
                                if (isset($task_info->commission_to_buyer)) {
                                    echo $task_info->commission_to_buyer . '元';
                                } else {
                                    echo '待定';
                                }
                                ?>
                            </div>
                        </div>
                    </a>
                </li>
                <li>
                    <a href="#" class="item-content external">
                        <div class="item-inner">
                            <div class="item-title">任务类型：</div>
                            <div class="item-after">
                                <?php
                                if (isset($task_info->device_type)) {
                                    switch ($task_info->device_type) {
                                        case DEVICE_TYPE_MOBILE :
                                            echo '手机单';
                                            break;
                                        case DEVICE_TYPE_COMPUTER :
                                            echo '电脑单';
                                            break;
                                        default:
                                            echo '无限制';
                                            break;
                                    }
                                } else {
                                    echo '无限制';
                                }
                                ?>
                            </div>
                        </div>
                    </a>
                </li>
            </ul>
        </div>
    </div>
    <div class="content-block" style="color:#FF4400;">
        <span style="font-size:16px;">重要提示：</span>
        <br>
        <span>如果你已经通过其它任何途径接过该店铺的任务，则不能再接此单，而且不得通过淘宝客、返利网等进入商家店铺，否则一律封账号。</span>
    </div>
    <div class="content-block claim-task">
        <?php foreach ($accounts as $v) {
            if ($v->id > 0) {
                echo '<a href="#" class="button button-big button-fill color-blue btn-task-accept" data-url="' . base_url('task/accept') . '" data-id="' . $task_info->id . '" data-nick-id="' . $v->id . '" data-task-info=\'' . json_encode($task_info) . '\'>使用账号【' . $v->tb_nick . '】接单</a>';
            } else {
                echo '<a href="#" class="button button-big button-fill color-gray">账号【' . $v->tb_nick . '】';
                echo $v->id== -1 ? "今日任务已满上限":"不符合要求" .'</a>';
            }
        }
        ?>
        <a href="#" id="btn-task-reject" class="button button-big button-fill color-red" data-url="<?php echo base_url('task/reject'); ?>" data-task-info='<?php echo json_encode($task_info); ?>'>不接</a>
    </div>
    <div class="content-block" style="color:#FF4400;">
        <span>温馨提示：账号不符合要求可能是由于你的拼多多账号不符合卖家设置的筛选规则，或已经超过了平台设置的每天最大允许的接单数量。</span>
    </div>
<?php endif ?>