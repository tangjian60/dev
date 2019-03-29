<?php foreach ($data as $v): ?>
    <li>
        <a href="<?php echo base_url('task/details?task_type=' . $task_type . '&task_id=' . $v->id); ?>" class="item-link item-content">
            <div class="item-media ">
                <img src="<?php echo CDN_DOMAIN_TEMP . $v->item_pic; ?>" width="60px">
            </div>
            <div class="item-inner">
                <div class="item-title-row">
                    <div class="item-title">#<?php echo encode_id($v->id); ?></div>
                    <div class="item-after">
                        <span class="tieyu-back-blue tieyu-max-font tieyu-icon-radius"><?php echo Taskengine::get_status_name($v->status); ?></span>
                    </div>
                </div>
                <div class="item-subtitle" style="font-size: 14px;color:#999999">
                    接单淘宝账号：<span style="font-size:16px;color:orangered;"><?php echo $v->buyer_tb_nick; ?></span><br>
                    <?php
                    if ($v->status == Taskengine::TASK_STATUS_DCZ) {
                        if ($v->cur_task_day > 1) {
                            echo '下次做单时间：<span style="font-size:16px;color:orangered;margin:0 3px;">' . $v->next_start_time . '</span>';
                        } else {
                            echo '剩余做单时间：<span style="font-size:16px;color:orangered;margin:0 3px;">' . calc_task_remain_time($v->gmt_taking_task) . '</span>分钟';
                        }
                    } elseif ($v->status == Taskengine::TASK_STATUS_YCX) {
                        echo '任务取消时间：' . $v->gmt_cancelled;
                    } else {
                        echo '接单时间：' . $v->gmt_taking_task;
                        echo "<br>";
                        echo '最近提交时间：' . $v->task_submit_time;
                    }
                    ?>
                </div>
                <?php if ($v->status != Taskengine::TASK_STATUS_YCX): ?>
                    <div class="item-text" style="font-size:14px;height:22px;color:orangered;">
                        <?php
                        if (!empty($v->df_single_task_capital)) {
                            echo '本金￥' . $v->df_single_task_capital . '，';
                        }
                        if (!empty($v->df_commission_to_buyer)) {
                            echo '收益￥' . $v->df_commission_to_buyer . '元';
                        } elseif (!empty($v->ll_commission_to_buyer)) {
                            echo '收益￥' . $v->ll_commission_to_buyer . '元';
                        }
                        ?>
                    </div>
                <?php endif; ?>
            </div>
        </a>
    </li>
<?php endforeach; ?>