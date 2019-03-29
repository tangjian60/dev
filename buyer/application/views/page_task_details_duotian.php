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
    <div data-page="page-task-details-tuotian" class="page">
        <div class="page-content">
            <div class="list-block" style="margin:0;">
                <!-- 任务开始时间没到，显示倒计时 -->
                <?php if ($ext['is_dcz'] == 1 && $ext['is_start'] == 0):?>
                    <div class="list-group" style="margin: 30px 0px 30px 0px;">
                        <ul>
                            <li class="item-content"><span style="font-size: 20px;">已完成今天的任务要求，请明天8:00后再来继续任务，你现在可以接其他的订单</span></li>
                            <li class="item-content" style="margin-left:0px;">
                                <span class="task_counter" style="color: #FF0000;font-size: 20px;">任务开始时间没到，显示倒计时</span>
                            </li>
                        </ul>
                    </div>
                <?php endif;?>

                <div class="list-group">
                    <ul>
                        <li class="list-group-title"><span class="info-title">任务信息</li>
                        <li class="item-content">
                            <div class="item-inner">
                                <div class="item-title ddx">任务类型</div>
                                <div class="item-after list-text"><?php echo $task_type_txt; ?></div>
                            </div>
                        </li>
                        <li class="item-content">
                            <div class="item-inner">
                                <div class="item-title ddx">任务编号</div>
                                <div class="item-after list-text"><?php echo encode_id($task_detail->id); ?></div>
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
                                <div class="item-title">任务进度（天）</div>
                                <div class="item-after list-text"><?php echo $task_detail->cur_task_day,' / ',$task_detail->task_days; ?></div>
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
                                <div class="item-title">接单时间</div>
                                <div class="item-after list-text"><?php echo $task_detail->gmt_taking_task; ?></div>
                            </div>
                        </li>
                        <li class="item-content">
                            <div class="item-inner">
                                <div class="item-title">赚佣金</div>
                                <div class="item-after list-text"><?php echo $task_detail->commission_to_buyer; ?></div>
                            </div>
                        </li>
                        <li class="item-content">
                            <div class="item-inner">
                                <div class="item-title">垫付本金</div>
                                <div class="item-after list-text"><span style="font-size: 30px;color: red;margin-top: -3%;"><?php echo $task_detail->task_capital * $task_detail->num_of_pkg; ?></span></div>
                            </div>
                        </li>

                        <li class="item-content">
                            <div class="item-inner">
                                <div class="item-title-row">
                                    <div class="item-title">付款人数</div>
                                    <div class="item-after list-text"><?php echo $task_detail->buyer_cnt; ?></div>
                                </div>
                            </div>
                        </li>
                        <li class="item-content">
                            <div class="item-inner">
                                <div class="item-title">页面显示价格</div>
                                <div class="item-after list-text"><span style="font-size: 30px;color: red;margin-top: -3%;"><?php echo $task_detail->item_display_price; ?></span> </div>
                            </div>
                        </li>

                        <li class="item-content">
                            <div class="item-inner">
                                <div style="color: red">如店铺名核实通过并已仔细按是否使用优惠券使用，存在金额<?php echo PRICE_DIFFERENCE; ?>元之内差价可直接正常拍下，该笔本金到账时会自动多退少补。</div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="list-block" style="margin:5px 0 5px 0;">
                <div class="list-group">
                    <ul>
                        <li class="list-group-title"><span class="info-title">任务要求</span>（必须严格按照要求操作）</li>
                        <li class="item-content">
                            <div class="item-inner">
                                <div class="item-title">购买件数</div>
                                <div class="item-after list-text"><?php echo $task_detail->num_of_pkg; ?></div>
                            </div>
                        </li>
                        <li class="item-content">
                            <div class="item-inner">
                                <div class="item-title">尺码规格</div>
                                <div class="item-after list-text"><?php echo $task_detail->sku; ?></div>
                            </div>
                        </li>
                        <li class="item-content">
                            <div class="item-inner">
                                <div class="item-title">优惠券</div>
                                <div class="item-after list-text"><?php echo $task_detail->is_coupon; ?></div>
                            </div>
                        </li>
                        <li class="item-content">
                            <div class="item-inner">
                                <div class="item-title">评价要求</div>
                                <div class="item-after list-text">
                                    <?php
                                    switch ($task_detail->comment_type) {
                                        case COMMENT_TYPE_TEXT:
                                            echo '指定内容好评';
                                            break;
                                        case COMMENT_TYPE_PICTURE:
                                            echo '指定晒图和文字好评';
                                            break;
                                        default:
                                            echo '普通好评';
                                            break;
                                    }
                                    ?>
                                </div>
                            </div>
                        </li>
                        <?php if ($task_detail->comment_type == COMMENT_TYPE_TEXT || $task_detail->comment_type == COMMENT_TYPE_PICTURE): ?>
                            <li class="item-content">
                                <div class="item-inner">
                                    <div class="item-title">好评内容</div>
                                    <div class="item-after list-text"><?php echo $task_detail->comment_text; ?></div>
                                </div>
                            </li>
                        <?php endif; ?>
                        <?php if ($task_detail->comment_type == COMMENT_TYPE_PICTURE): ?>
                            <li class="item-content">
                                <div class="item-inner">
                                    <div class="item-title">好评图片</div>
                                    <div class="item-after">
                                        <?php
                                        $pic_arr = explode('^^^', $task_detail->comment_pic);
                                        if (!empty($pic_arr)) {
                                            foreach ($pic_arr as $v) {
                                                echo '<img class="img-show-gallery image-comment" src="' . $v . '">';
                                            }
                                        }
                                        ?>
                                    </div>
                                </div>
                            </li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
            <div class="list-block" style="margin:5px 0 5px 0;">
                <div class="list-group">
                    <ul>
                        <li class="list-group-title"><span class="info-title">额外要求</span></li>
                        <li>
                            <div class="content-block inset contacts-block">
                                <div class="content-block-inner"><?php echo $task_detail->task_note; ?></div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="list-block" style="margin:5px 0 5px 0;">
                <input type="hidden" name="task_countdown_secs" class="task_countdown_secs" value="<?php echo $ext['ct_sec']; ?>"/>
                <?php if ($ext['is_dcz'] == 1):?>
                    <?php if ($ext['is_start'] == 1):?>
                        <form id="form-task-operation" method="post">
                            <input type="hidden" name="task_id" value="<?php echo $task_detail->id; ?>"/>
                            <input type="hidden" name="task_type" value="<?php echo $task_type; ?>"/>
                            <input type="hidden" name="pre_task_capital" value="<?php echo $task_detail->task_capital * $task_detail->num_of_pkg; ?>"/>
                            <input type="hidden" name="is_last_step" value="<?php echo $ext['is_last_step']; ?>"/>
                            <input type="hidden" name="is_browse_inner" value="<?php echo $ext['is_browse_inner']; ?>"/>
                            <input type="hidden" name="ct_mo_arr" value="<?php echo count($ext['mo_arr']); ?>"/>
                            <div class="list-group">
                                <!--<span style="color:green;font-size:18px;">如暂需离开做单页面，请点击底部“暂存”按钮</span>-->
                                <ul>
                                    <li class="list-group-title"><span class="info-title">操作任务</span></li>
                                    <?php $step = 1; ?>
                                    <li class="item-content" style="margin-left:0px;">
                                        <section id="cd-timeline" class="cd-container">
                                            <div class="cd-timeline-block">
                                                <div class="cd-timeline-img cd-picture"><?php echo $step++; ?></div>
                                                <div class="cd-timeline-content">
                                                    <div class="pic-title">请按照以下要求完成任务</div>
                                                    <div class="pic-content">
                                                        <div class="pic-tipk">
                                                            <div class="row no-gutter">
                                                                <div class="col-75"><?php echo $ext['op_flow']?></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="cd-timeline-block">
                                                <div class="cd-timeline-img cd-picture"><?php echo $step++; ?></div>
                                                <div class="cd-timeline-content">
                                                    <div class="pic-title">上传截图</div>
                                                    <div class="pic-content">

                                                        <div class="row" style="color: #FF0000">
                                                            截图图片：<?php echo implode('，', $ext['mo_arr'])?>
                                                            <br><br>
                                                        </div>
                                                        <div class="row col-100">
                                                            <?php foreach($ext['mo_arr'] as $i => $v) {?>
                                                                <div class="col-50 align-center">
                                                                    <div class="tieyu-icon image-upload-container">
                                                                        <img data-input-name="browse_pic_<?php echo $i?>" class="image-upload" src="<?php echo CDN_BINARY_URL; ?>cross.png">
                                                                        <input type="hidden" name="browse_pic_<?php echo $i?>">
                                                                    </div>
                                                                    <div class="picx-title">
                                                                        <span class="f12-red"><?php echo $v?></span>
                                                                        <br><br>
                                                                        <span class="f12-grass-green"></span>
                                                                    </div>
                                                                </div>
                                                            <?php }?>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>

                                        <?php if ($ext['is_browse_inner'] == 1):?>
                                            <div class="cd-timeline-block">
                                                <div class="cd-timeline-img cd-picture"><?php echo $step++; ?></div>
                                                <div class="cd-timeline-content">
                                                    <div class="pic-title">商品核对</div>
                                                    <div class="pic-content">
                                                        <?php if ($task_detail->item_check_status == STATUS_ENABLE): ?>
                                                            <a href="#" class="button button-sm button-fill color-blue" disabled="disabled">已核对成功</a>
                                                        <?php else: ?>
                                                            <div class="pic-tipk">
                                                                <div class="row no-gutter">
                                                                    <div class="col-75">请输入店铺名称核对</div>
                                                                </div>
                                                            </div>
                                                            <div style="padding:5px;">
                                                                <img src="<?php echo CDN_DOMAIN_TEMP . $task_detail->item_pic; ?>" height="80px">
                                                                <input name="check_content" type="text" placeholder="核对内容" style="ime-mode:disabled;background-color:white;">
                                                                <a href="#" class="button button-sm button-fill color-blue btn-check-item-url" data-url="<?php echo base_url('task/item_url_check_handle'); ?>">核对</a>
                                                            </div>
                                                        <?php endif; ?>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endif; ?>

                                        <?php if ($task_detail->cur_task_day == $task_detail->task_days):?>

                                            <div class="cd-timeline-block">
                                                <div class="cd-timeline-img cd-picture"><?php echo $step++; ?></div>
                                                <div class="cd-timeline-content">
                                                    <div class="pic-title">支付宝订单付款截图</div>
                                                    <div class="pic-content">
                                                        <div class="pic-tipk">
                                                            <div class="row no-gutter">
                                                                <div class="col-75">请在支付宝账单中的订单详情页面截图</div>
                                                                <div class="col-25 f12-orange btn-show-tips" data-tip-url="<?php echo CDN_BINARY_URL; ?>tips/alipay_bills.jpg">查看示例&nbsp;&gt;</div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-50 align-center">
                                                                <div class="tieyu-icon image-upload-container">
                                                                    <?php if (!empty($task_detail->fukuan_prove_pic)): ?>
                                                                        <img data-input-name="fukuan_prove_pic" class="image-upload" src="<?php echo CDN_DOMAIN_TEMP . $task_detail->fukuan_prove_pic; ?>">
                                                                        <div class="image-uppload-tips">付款<br>截图</div>
                                                                        <input type="hidden" name="fukuan_prove_pic" value="<?php echo $task_detail->fukuan_prove_pic; ?>">
                                                                    <?php else: ?>
                                                                        <img data-input-name="fukuan_prove_pic" class="image-upload" src="<?php echo CDN_BINARY_URL; ?>cross.png">
                                                                        <div class="image-uppload-tips">付款<br>截图</div>
                                                                        <input type="hidden" name="fukuan_prove_pic">
                                                                    <?php endif; ?>
                                                                </div>
                                                                <div class="picx-title">
                                                                    <span class="f12-red">付款成功后订单详情</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="cd-timeline-block">
                                                <div class="cd-timeline-img cd-picture"><?php echo $step++; ?></div>
                                                <div class="cd-timeline-content">
                                                    <div class="pic-title">关键信息提交</div>
                                                    <div class="pic-content">
                                                        <div class="pic-tipk">
                                                            <div class="row no-gutter">
                                                                <div class="col-75">请将订单详情页中的商户订单号复制到文本框（<span style="color: red;font-size: +2px;">T200P后的数字</span>）</div>
                                                                <div class="col-25 f12-orange btn-show-tips" data-tip-url="<?php echo CDN_BINARY_URL; ?>tips/order_number.jpg">查看示例</div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-50 align-center">
                                                                <div class="tieyu-icon image-upload-container">
                                                                    <input name="order_number" type="text" placeholder="商品订单号" style="ime-mode:disabled;background-color:white;width: 300px" value="<?php echo $task_detail->order_number;?>" <?php if($task_detail->status ==8 || $task_detail->status ==4){ echo "disabled='disabled'";};?>>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="pic-content">
                                                        <div class="pic-tipk">
                                                            <div class="row no-gutter">
                                                                <div class="col-75">请将实际付款金额输入到文本框</div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-50 align-center">
                                                                <div class="tieyu-icon image-upload-container">
                                                                    <input name="real_task_capital" type="number" placeholder="实际付款金额" style="ime-mode:disabled;background-color:white;width: 300px" value="<?php echo ($task_detail->real_task_capital > 0) ? $task_detail->real_task_capital : '';?>" <?php if($task_detail->status ==8 || $task_detail->status ==4){ echo "disabled='disabled'";};?> onmousewheel="return false;" min="0.1">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endif; ?>
                                        </section>
                                    </li>
                                </ul>
                            </div>
                        </form>
                    <?php else: ?>
                        <!-- 任务开始时间没到，显示倒计时 -->
                    <?php endif; ?>

                <?php else: ?>
                    <!--展示全部-->
                    <div class="list-group">
                        <!--<span style="color:green;font-size:18px;">如暂需离开做单页面，请点击底部“暂存”按钮</span>-->
                        <ul>
                            <li class="list-group-title"><span class="info-title">操作任务</span></li>
                            <?php $step = 1; ?>
                            <li class="item-content" style="margin-left:0px;">
                                <section id="cd-timeline" class="cd-container">
                                    <?php foreach($show_data as $k => $val) {?>
                                        <div class="cd-timeline-block">
                                            <div class="cd-timeline-img cd-picture"><?php echo $step++; ?></div>
                                            <div class="cd-timeline-content">
                                                <div class="pic-title">第<?php echo $k; ?>天</div>
                                                <div class="pic-content">
                                                    <div class="row" style="color: #FF0000">
                                                        任务要求：<?php echo $val['of']?>
                                                    </div>
                                                    <div class="row" style="color: #FF0000">
                                                        截图图片：<?php echo implode('，', $val['mo'])?>
                                                        <br><br>
                                                    </div>
                                                    <div class="row col-100">
                                                        <?php foreach($val['imgs'] as $k => $val2) {?>
                                                            <div class="col-50 align-center">
                                                                <div class="tieyu-icon image-upload-container">
                                                                    <img class="image-show" src="<?php echo CDN_DOMAIN_TEMP , $val2; ?>" >
                                                                </div>
                                                                <div class="picx-title">
                                                                    <span class="f12-red"><?php echo $val['mo'][$k]?></span>
                                                                    <br><br>
                                                                    <span class="f12-grass-green"></span>
                                                                </div>
                                                            </div>
                                                        <?php }?>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    <?php }?>

                                    <?php if ($ext['is_browse_inner'] == 1):?>
                                        <div class="cd-timeline-block">
                                            <div class="cd-timeline-img cd-picture"><?php echo $step++; ?></div>
                                            <div class="cd-timeline-content">
                                                <div class="pic-title">商品核对</div>
                                                <div class="pic-content">
                                                    <?php if ($task_detail->item_check_status == STATUS_ENABLE): ?>
                                                        <a href="#" class="button button-sm button-fill color-blue" disabled="disabled">已核对成功</a>
                                                    <?php else: ?>
                                                        <div class="pic-tipk">
                                                            <div class="row no-gutter">
                                                                <div class="col-75">请输入店铺名称核对</div>
                                                            </div>
                                                        </div>
                                                        <div style="padding:5px;">
                                                            <img src="<?php echo CDN_DOMAIN_TEMP . $task_detail->item_pic; ?>" height="80px">
                                                            <input name="check_content" type="text" placeholder="核对内容" style="ime-mode:disabled;background-color:white;">
                                                            <a href="#" class="button button-sm button-fill color-blue btn-check-item-url" data-url="<?php echo base_url('task/item_url_check_handle'); ?>">核对</a>
                                                        </div>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endif; ?>

                                    <?php if ($task_detail->cur_task_day == $task_detail->task_days):?>

                                        <div class="cd-timeline-block">
                                            <div class="cd-timeline-img cd-picture"><?php echo $step++; ?></div>
                                            <div class="cd-timeline-content">
                                                <div class="pic-title">支付宝订单付款截图</div>
                                                <div class="pic-content">

                                                    <div class="row col-100">
                                                            <div class="col-50 align-center" style="padding:5px;">
                                                                <div class="tieyu-icon image-upload-container">
                                                                    <img class="image-show" src="<?php echo CDN_DOMAIN_TEMP , $task_detail->fukuan_prove_pic; ?>" >
                                                                </div>
                                                                <div class="picx-title">
                                                                    <span class="f12-red">付款截图</span>
                                                                </div>
                                                            </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="cd-timeline-block">
                                            <div class="cd-timeline-img cd-picture"><?php echo $step++; ?></div>
                                            <div class="cd-timeline-content">
                                                <div class="pic-title">关键信息提交</div>
                                                <div class="pic-content">
                                                    <div class="pic-tipk">
                                                        <div class="row no-gutter">
                                                            <div class="col-75">请将订单详情页中的商户订单号复制到文本框（<span style="color: red;font-size: +2px;">T200P后的数字</span>）</div>
                                                            <div class="col-25 f12-orange btn-show-tips" data-tip-url="<?php echo CDN_BINARY_URL; ?>tips/order_number.jpg">查看示例</div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-50 align-center">
                                                            <div class="tieyu-icon image-upload-container">
                                                                <input name="order_number" type="text" placeholder="商品订单号" style="ime-mode:disabled;background-color:white;width: 300px" value="<?php echo $task_detail->order_number;?>" <?php if($task_detail->status ==8 || $task_detail->status ==4){ echo "disabled='disabled'";};?>>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="pic-content">
                                                    <div class="pic-tipk">
                                                        <div class="row no-gutter">
                                                            <div class="col-75">请将实际付款金额输入到文本框</div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-50 align-center">
                                                            <div class="tieyu-icon image-upload-container">
                                                                <input name="real_task_capital" type="number" placeholder="实际付款金额" style="ime-mode:disabled;background-color:white;width: 300px" value="<?php echo ($task_detail->real_task_capital > 0) ? $task_detail->real_task_capital : '';?>" <?php if($task_detail->status ==8 || $task_detail->status ==4){ echo "disabled='disabled'";};?> onmousewheel="return false;" min="0.1">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="cd-timeline-block">
                                            <div class="cd-timeline-img cd-picture"><?php echo $step++; ?></div>
                                            <div class="cd-timeline-content">
                                                <div class="pic-title">好评截图</div>
                                                <div class="pic-content">

                                                    <div class="row col-100">
                                                        <div class="col-50 align-center" style="padding:5px;">
                                                            <div class="tieyu-icon image-upload-container">
                                                                <img class="image-show" src="<?php echo CDN_DOMAIN_TEMP , $task_detail->haoping_prove_pic; ?>" >
                                                            </div>
                                                            <div class="picx-title">
                                                                <span class="f12-red">好评截图</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    <?php endif; ?>

                                    <?php if ($task_detail->status == Taskengine::TASK_STATUS_DPJ || $task_detail->status == Taskengine::TASK_STATUS_HPSH_BTG): ?>
                                    <form id="form-task-operation" method="post">
                                        <input type="hidden" name="task_id" value="<?php echo $task_detail->id; ?>"/>
                                        <div class="cd-timeline-block">
                                            <div class="cd-timeline-img cd-picture"><?php echo $step++; ?></div>
                                            <div class="cd-timeline-content">
                                                <div class="pic-title">好评截图</div>
                                                <div class="pic-content">
                                                    <div class="pic-tipk">
                                                        <div class="row no-gutter">
                                                            <div class="col-75">需要完整的显示好评的文字和图片</div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-50 align-center">
                                                            <div class="tieyu-icon image-upload-container">
                                                                <?php if (!empty($task_detail->haoping_prove_pic)): ?>
                                                                    <img data-input-name="haoping_prove_pic" class="image-upload" src="<?php echo CDN_DOMAIN_TEMP . $task_detail->haoping_prove_pic; ?>">
                                                                    <div class="image-uppload-tips">好评<br>截图</div>
                                                                    <input type="hidden" name="haoping_prove_pic" value="<?php echo $task_detail->haoping_prove_pic; ?>">
                                                                <?php else: ?>
                                                                    <img data-input-name="haoping_prove_pic" class="image-upload" src="<?php echo CDN_BINARY_URL; ?>cross.png">
                                                                    <div class="image-uppload-tips">好评<br>截图</div>
                                                                    <input type="hidden" name="haoping_prove_pic">
                                                                <?php endif; ?>
                                                            </div>
                                                            <div class="picx-title">
                                                                <span class="f12-red">收货以及好评必须在快递签收以后</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                    <?php endif; ?>

                                </section>
                            </li>
                        </ul>
                    </div>
                <?php endif; ?>
            </div>

            <?php if ($task_detail->status == Taskengine::TASK_STATUS_DCZ): ?>
                <div class="row no-gutter" style="margin:20px 0;">

                    <?php if ($ext['is_start'] == 1):?>
                    <div class="col-100">
                        <a href="#" class="button button-big button-fill color-blue task-go-btn btn-task-commit" data-url="<?php echo base_url('task/duotian_task_commit_handle'); ?>">
                            <?php if ($task_detail->cur_task_day == $task_detail->task_days):?>
                                提交审核
                            <?php else: ?>
                                下一步
                            <?php endif; ?>
                        </a>
                    </div>
                    <?php endif; ?>

                    <div class="col-100">
                        <a href="<?php echo base_url('task/cancel_task?task_type=' . $task_detail->task_type . '&task_id=' . $task_detail->id); ?>" class="button button-big button-fill color-red task-go-btn">取消任务</a>
                    </div>
                </div>
            <?php endif; ?>

            <?php if ($task_detail->status == Taskengine::TASK_STATUS_DPJ || $task_detail->status == Taskengine::TASK_STATUS_HPSH_BTG): ?>
                <div class="row no-gutter" style="margin:30px 0 80px 0;">
                    <div class="col-100">
                        <a href="#" class="button button-big button-fill color-blue task-go-btn btn-haoping-commit-dt" data-url="<?php echo base_url('task/task_haoping_handle'); ?>">提交好评审核</a>
                    </div>
                </div>
            <?php endif; ?>

        </div>
    </div>
</div>