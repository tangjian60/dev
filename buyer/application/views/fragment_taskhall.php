<?php if ( isset( $LatestNotice ) ) : ?>
    <a class="link" href="<?php echo base_url('pages/notices'); ?>" style="vertical-align:middle;text-align:center;">
        <div class="notice-block"><?php echo $LatestNotice->title;?></div>
    </a>
<?php endif ?>
<?php if ($auth_status != STATUS_PASSED):?>
    <div class="content-block" style="text-align:center;margin:140px 18px;">
        <span style="font-size:28px;color:black;">很抱歉，您需要先完成实名认证才能接单，<a href='certification' style="color: #ff0000">去认证</a></span>
    </div>
<?php elseif ( empty( $have_binded_account ) ) : ?>
    <div class="content-block" style="text-align:center;margin:140px 18px;">
        <span style="font-size:28px;color:black;">很抱歉，您需要先绑定账号才能接单</span>
        <span style="font-size:28px;color:black;"><a href="<?php echo base_url('pages')?>">去绑定淘宝账号</a></span>
        <span style="font-size:28px;color:black;"><a href="<?php echo base_url('pages/pdd_bind')?>">去绑定拼多多账号</a></span>
    </div>
<?php else : ?>
<div class="content-block task-content" style="margin-top:80px;">
    <div class="row no-gutter">
        <div class="col-50" style="border-right: 1px solid #d6d7dc;">
            <a class="link" href="<?php echo base_url('task/go?t='.TASK_TYPE_LL); ?>">
                <div class="task-hall-icon">
                    <img src="<?php echo CDN_BINARY_URL; ?>task_ll.png">
                </div>
                <div class="task-hall-title">流量任务</div>
                <div class="task-hall-desc">无需垫钱，快速方便</div>
            </a>
        </div>
        <div class="col-50">
            <a class="link" href="<?php echo base_url('task/go?t='.TASK_TYPE_DF); ?>">
                <div class="task-hall-icon">
                    <img src="<?php echo CDN_BINARY_URL; ?>task_df.png">
                </div>
                <div class="task-hall-title">垫付任务</div>
                <div class="task-hall-desc">需要垫钱，收益更高</div>
            </a>
        </div>
    </div>
    <div class="row no-gutter" style="border-top: 1px solid #d6d7dc;">
        <div class="col-50" style="border-right: 1px solid #d6d7dc;">
            <a class="link" href="#">
                <div class="task-hall-icon">
                    <img src="<?php echo CDN_BINARY_URL; ?>task_jd.jpg">
                </div>
                <div class="task-hall-title">京东任务</div>
                <div class="task-hall-desc">即将上线</div>
            </a>
        </div>
        <div class="col-50">
            <a class="link" href="#">
                <div class="task-hall-icon">
                    <img src="<?php echo CDN_BINARY_URL; ?>task_pdd.png">
                </div>
                <div class="task-hall-title">拼多多任务</div>
                <div class="task-hall-desc">拼多多 拼多多 拼得多省得多</div>
            </a>
        </div>
    </div>
    <div class="row no-gutter" style="border-top: 1px solid #d6d7dc;">
        <div class="col-50" style="border-right: 1px solid #d6d7dc;">
            <a class="link" href="<?php echo base_url('task/go?t='.TASK_TYPE_DT); ?>">
            <!--<a class="link" href="#">-->
                <div class="task-hall-icon">
                    <img src="<?php echo CDN_BINARY_URL; ?>task_df.png">
                </div>
                <div class="task-hall-title">多天垫付任务</div>
            </a>
        </div>
    </div>

</div>
<?php endif ?>

