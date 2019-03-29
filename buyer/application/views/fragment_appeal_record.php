<?php
$options = array(
    1 => '申诉中',
    2 => '已处理-订单继续',
    3 => '已处理-关闭订单',
    4 => '放弃申诉'
);
foreach ($data as $v): ?>
    <li>
        <a href="<?php echo base_url('task/appeal_details?apply_id=' . $v->id); ?>" class="item-link item-content">
            <div class="item-media ">
                <img src="<?php echo CDN_DOMAIN . $v->item_pic; ?>" width="60px">
            </div>
            <div class="item-inner">
                <div class="item-title-row">
                    <div class="item-title">#<?php echo encode_id($v->task_id); ?></div>
                    <div class="item-after">
                        <!--<span class="tieyu-back-blue tieyu-max-font tieyu-icon-radius"><?php /*echo Taskengine::get_status_name($v->task_status); */?></span>-->
                        <span class="tieyu-back-blue tieyu-max-font tieyu-icon-radius"><?php echo isset($options[$v->state]) ? $options[$v->state] : '未知状态'; ?></span>
                    </div>
                </div>
                <div class="item-subtitle" style="font-size: 14px;color:#999999">
                    接单淘宝账号：<span style="font-size:16px;color:orangered;"><?php echo $v->buyer_tb_nick; ?></span><br>
                    <?php
                        echo '申诉时间：' . $v->gmt_create;
                    ?>
                </div>
            </div>
        </a>
    </li>
<?php endforeach; ?>