<div class="navbar">
    <div class="navbar-inner">
        <div class="left sliding">
            <a href="#" class="back link"><i class="icon icon-back"></i><span>返回</span></a>
        </div>
        <div class="center sliding" style="margin-left: 53%;position: absolute;">
            <?php
            $options = array(
                1 => '申诉中',
                2 => '已处理-订单继续',
                3 => '已处理-关闭订单',
                4 => '放弃申诉'
            );
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
                        <li class="list-group-title"><span class="info-title">申诉信息</li>
                        <li class="item-content">
                            <div class="item-inner">
                                <div class="item-title">任务编号</div>
                                <div class="item-after list-text"><?php echo encode_id($task_detail->task_id); ?></div>
                            </div>
                        </li>
                        <li class="item-content">
                            <div class="item-inner">
                                <div class="item-title">申诉处理状态</div>
                                <div class="item-after list-text"><?php echo isset($options[$task_detail->state]) ? $options[$task_detail->state] : '未知状态'; ?></div>
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
                                <div class="item-title">申诉时间时间</div>
                                <div class="item-after list-text"><?php echo $task_detail->gmt_create; ?></div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>