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
    <div data-page="page-task-details" class="page">
        <div class="page-content">
            <div class="list-block" style="margin:0;">
                <div class="list-group">
                    <ul>
                        <li class="list-group-title"><span class="info-title">任务信息</li>
                        <li class="item-content">
                            <div class="item-inner">
                                <div class="item-title">任务编号</div>
                                <div class="item-after list-text"><?php echo encode_id($task_detail->task_id); ?></div>
                            </div>
                        </li>
                        <li class="item-content">
                            <div class="item-inner">
                                <div class="item-title">任务状态</div>
                                <div class="item-after list-text"><?php echo Taskengine::get_status_name($task_detail->status); ?></div>
                            </div>
                        </li>
                        <li class="item-content">
                            <div class="item-inner">
                                <div class="item-title">接单淘宝nick</div>
                                <div class="item-after list-text"><?php echo $task_detail->buyer_tb_nick; ?></div>
                            </div>
                        </li>
                        <li class="item-content">
                            <div class="item-inner">
                                <div class="item-title">取消时间</div>
                                <div class="item-after list-text"><?php echo $task_detail->gmt_cancelled; ?></div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>