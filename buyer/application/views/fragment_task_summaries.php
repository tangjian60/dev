<?php if (isset($LatestNotice)) { ?>
    <a class="link" href="<?php echo base_url('pages/notice/' . $LatestNotice->id); ?>" style="vertical-align:middle;text-align:center;">
        <div class="notice-block"><?php echo $LatestNotice->title; ?></div>
    </a>
<?php } ?>
<div class="content-block">
    <div class="row no-gutter">
        <div class="col-50">
            <a class="item-link" href="<?php echo base_url('task/index?task_type=' . TASK_TYPE_LL); ?>">
                <div class="task-status task-status-2">流量任务</div>
            </a>
        </div>
        <div class="col-50">
            <a class="item-link" href="<?php echo base_url('task/index?task_type=' . TASK_TYPE_DF); ?>">
                <div class="task-status task-status-3">垫付任务</div>
            </a>
        </div>
        <div class="col-50">
            <a class="item-link" href="<?php echo base_url('task/index?task_type=' . TASK_TYPE_DT); ?>">
                <div class="task-status task-status-3">多天垫付单</div>
            </a>
        </div>
        <div class="col-50">
            <a class="item-link" href="<?php echo base_url('task/index?task_type=' . TASK_TYPE_PDD); ?>">
                <div class="task-status task-status-5">拼多多任务</div>
            </a>
        </div>
        <div class="col-50">
            <a class="item-link" href="<?php echo base_url('task/index?task_type=' . TASK_TYPE_CANCELLED); ?>">
                <div class="task-status task-status-6">取消的任务</div>
            </a>
        </div>
        <div class="col-50">
            <a class="item-link" href="<?php echo base_url('task/appeal'); ?>">
                <div class="task-status task-status-4">申诉的任务</div>
            </a>
        </div>
    </div>
</div>