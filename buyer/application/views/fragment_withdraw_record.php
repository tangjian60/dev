<?php foreach ($withdraw_records as $v): ?>
    <li class="item-content">
        <div class="item-media ">
            <i class="icon">
                <?php echo substr($v->create_time, 5, 5); ?>
                <br>
                <?php echo substr($v->create_time, 11, 5); ?>
            </i>
        </div>
        <?php
        $options = array(
            STATUS_CHECKING => '提现处理中',
            STATUS_REMITING => '打款处理中',
            //STATUS_REMITED => '已打款',
            STATUS_PASSED => '提现成功',
            STATUS_CANCELING => '待退款',
            STATUS_FAILED => '提现失败',

        );
        ?>

        <div class="item-inner">
            <div class="item-title" style="font-size:15px;color: grey;">提现
                <?php if ($v->tixian_type == 1) {
                    echo "本金";
                } elseif ($v->tixian_type == 2) {
                    echo "佣金";
                } ?>
                <span style="color:orange;margin:1px 8px;"><?php echo $v->amount; ?></span>元
            </div>
        </div>
        <div class="item-after">
            <span class="tieyu-back-darkmagenta tieyu-max-font tieyu-icon-radius" style="margin-right:14px;"> <?php echo $options[$v->status];?> </span>
        </div>
    </li>
<?php endforeach; ?>