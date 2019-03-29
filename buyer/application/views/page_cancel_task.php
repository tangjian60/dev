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
    <div data-page="page-cancel-task" class="page">
        <div class="page-content">
            <div class="list-block">
                <form id="form-cancel-task" method="post">
                    <input type="hidden" name="task_id" value="<?php echo $task_id; ?>"/>
                    <input type="hidden" name="task_type" value="<?php echo $task_type; ?>"/>
                    <ul>
                        <li class="item-content">
                            <div class="item-inner">

                                <div class="item-title label">取消原因</div>
                                <div class="item-input">
                                    <select name="cancel_reason">
                                        <option value="找不到商品">找不到商品</option>
                                        <option value="不会做">不会做</option>
                                        <option value="找到商品了，但核对不了">找到商品了，但核对不了</option>
                                        <option value="时间不够了">时间不够了</option>
                                        <option value="商品本金与实际不符">商品本金与实际不符</option>
                                    </select>
                                </div>

                            </div>
                        </li>
                    </ul>
                </form>
            </div>
            <div class="list-block inset">
                <div>
                    <a href="#" id="btn-cancel-task" class="button button-big button-fill color-blue" data-url="<?php echo base_url('task/cancel_task_handle'); ?>">提交</a>
                </div>
            </div>
            <div style="height:60px;"></div>
        </div>
    </div>
</div>