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
            <div class="list-block" style="margin:5px 0 5px 0;">
                <div class="list-group">
                    <ul>
                        <li class="list-group-title"><span class="info-title">注意：</span></li>
                        <li>
                            <div class="content-block inset contacts-block">
                                <div class="content-block-inner"><span style="color: red;">接手任务的买号和实际下单的买号必须一致，接单后必须在<?php echo ZUODAN_SHIJIAN_MIN; ?>分钟内完成，通过其它任何途径接过该商品的任务不能再接此单</span><br><?php echo $task_detail->task_note; ?></div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="list-block" style="margin:0;">
                <div class="list-group">
                    <ul>
                        <li class="list-group-title"><span class="info-title">任务信息</li>
                        <li class="item-content">
                            <div class="item-inner">
                                <div class="item-title">任务编号</div>
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
                    </ul>
                </div>
            </div>
            <div class="list-block media-list" style="margin:5px 0 5px 0;">
                <div class="list-group">
                    <ul>
                        <li class="list-group-title"><span class="info-title">请按照以下要求找到商品</span></li>
                        <li class="item-content">
                            <div class="item-inner">
                                <div class="item-title-row">
                                    <div class="item-title">商品入口</div>
                                    <div class="item-after list-text"><?php echo $task_detail->task_method; ?></div>
                                </div>
                            </div>
                        </li>
                        <?php if (in_array($task_detail->task_method, array('聚划算', '淘抢购', '天天特价'))): ?>
                            <li class="item-content">
                                <div class="item-media"><img class="img-show-gallery" src="<?php echo CDN_DOMAIN_TEMP . $task_detail->task_method_details; ?>" width="80px"></div>
                            </li>
                        <?php else: ?>
                            <li class="item-content">
                                <div class="item-inner">
                                    <div class="item-title-row">
                                        <?php if ($task_detail->task_method == '搜索'): ?>
                                            <div class="item-title">内容<p style="display: inline;color: red;font-size: 40%">(搜索关键词必须手动输入)</p></div>
                                            <div class="item-after list-text" style="-webkit-touch-callout: none; -webkit-user-select: none; -khtml-user-select: none; -moz-user-select: none; -ms-user-select: none; user-select: none;"><?php echo $task_detail->task_method_details; ?></div>
                                        <?php else:?>
                                            <div class="item-title">内容</div>
                                            <div class="item-after list-text"><?php echo $task_detail->task_method_details; ?></div>
                                        <?php endif;?>
                                    </div>
                                </div>
                            </li>

                        <?php endif; ?>
                        <li class="item-content">
                            <div class="item-inner">
                                <div class="item-title-row">
                                    <div class="item-title">排序方式</div>
                                    <div class="item-after list-text"><?php echo $task_detail->sort_type; ?></div>
                                </div>
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
                                <div class="item-title-row">
                                    <div class="item-title">页面显示价格</div>
                                    <div class="item-after list-text"><?php echo $task_detail->item_display_price; ?></div>
                                </div>
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
                                <div class="item-title">尺码规格</div>
                                <div class="item-after list-text"><?php echo $task_detail->sku; ?></div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="list-block" style="margin:5px 0 5px 0;">
                <form id="form-task-operation" method="post">
                    <input type="hidden" name="task_id" value="<?php echo $task_detail->id; ?>"/>
                    <input type="hidden" name="task_type" value="<?php echo $task_type; ?>"/>
                    <div class="list-group">
                        <ul>
                            <li class="list-group-title"><span class="info-title">操作任务</span></li>
                            <?php $step = 1; ?>
                            <li class="item-content" style="margin-left:0px;">
                                <section id="cd-timeline" class="cd-container">
                                    <div class="cd-timeline-block">
                                        <div class="cd-timeline-img cd-picture"><?php echo $step++; ?></div>
                                        <div class="cd-timeline-content">
                                            <div class="pic-title">主搜截图</div>
                                            <div class="pic-content">
                                                <div class="row">
                                                    <div class="col-50 align-center">
                                                        <div class="tieyu-icon image-upload-container">
                                                            <?php if (!empty($task_detail->zhusou_prove_pic)): ?>
                                                                <img data-input-name="zhusou_prove_pic" class="image-upload" src="<?php echo CDN_DOMAIN_TEMP . $task_detail->zhusou_prove_pic; ?>">
                                                                <div class="image-uppload-tips">主搜索<br>页面</div>
                                                                <input type="hidden" name="zhusou_prove_pic" value="<?php echo $task_detail->zhusou_prove_pic; ?>">
                                                            <?php else: ?>
                                                                <img data-input-name="zhusou_prove_pic" class="image-upload" src="<?php echo CDN_BINARY_URL; ?>cross.png">
                                                                <div class="image-uppload-tips">主搜索<br>页面</div>
                                                                <input type="hidden" name="zhusou_prove_pic">
                                                            <?php endif; ?>
                                                        </div>
                                                        <div class="picx-title">
                                                            <span class="f12-red">主搜索页面关键词+主宝贝</span>
                                                            <br>
                                                            <span class="f12-grass-green">(浏览≥1分钟)</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
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
                                                    <div style="padding:8px;">
                                                        <img src="<?php echo CDN_DOMAIN_TEMP . $task_detail->item_pic; ?>" height="80px">
                                                        <input name="check_content" type="text" placeholder="核对内容" style="ime-mode:disabled;background-color:white;">
                                                        <a href="#" class="button button-sm button-fill color-blue btn-check-item-url" data-url="<?php echo base_url('task/item_url_check_handle'); ?>">核对</a>
                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="cd-timeline-block">
                                        <div class="cd-timeline-img cd-picture"><?php echo $step++; ?></div>
                                        <div class="cd-timeline-content">
                                            <div class="pic-title">店铺浏览</div>
                                            <div class="pic-content">
                                                <div class="pic-tipk">
                                                    <div class="row no-gutter">
                                                        <div class="col-75">浏览目标商品和店内的其它宝贝，不可截图(请长按保存图片)，上传宝贝详情中的图片</div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-50 align-center">
                                                        <div class="tieyu-icon image-upload-container">
                                                            <?php if (!empty($task_detail->zhubaobei_prove_pic)): ?>
                                                                <img data-input-name="zhubaobei_prove_pic" class="image-upload" src="<?php echo CDN_DOMAIN_TEMP . $task_detail->zhubaobei_prove_pic; ?>">
                                                                <div class="image-uppload-tips">主宝贝<br>详情</div>
                                                                <input type="hidden" name="zhubaobei_prove_pic" value="<?php echo $task_detail->zhubaobei_prove_pic; ?>">
                                                            <?php else: ?>
                                                                <img data-input-name="zhubaobei_prove_pic" class="image-upload" src="<?php echo CDN_BINARY_URL; ?>cross.png">
                                                                <div class="image-uppload-tips">主宝贝<br>详情</div>
                                                                <input type="hidden" name="zhubaobei_prove_pic">
                                                            <?php endif; ?>
                                                        </div>
                                                        <div class="picx-title">
                                                            <span class="f12-red">不可截图(请长按保存图片)</span>
                                                            <br>
                                                            <span class="f12-grass-green">(浏览≥5分钟)</span>
                                                        </div>
                                                    </div>
                                                    <div class="col-50 align-center">
                                                        <div class="tieyu-icon image-upload-container">
                                                            <?php if (!empty($task_detail->fubaobei_prove_pic)): ?>
                                                                <img data-input-name="fubaobei_prove_pic" class="image-upload" src="<?php echo CDN_DOMAIN_TEMP . $task_detail->fubaobei_prove_pic; ?>">
                                                                <div class="image-uppload-tips">副宝贝<br>详情</div>
                                                                <input type="hidden" name="fubaobei_prove_pic" value="<?php echo $task_detail->fubaobei_prove_pic; ?>">
                                                            <?php else: ?>
                                                                <img data-input-name="fubaobei_prove_pic" class="image-upload" src="<?php echo CDN_BINARY_URL; ?>cross.png">
                                                                <div class="image-uppload-tips">副宝贝<br>详情</div>
                                                                <input type="hidden" name="fubaobei_prove_pic">
                                                            <?php endif; ?>
                                                        </div>
                                                        <div class="picx-title">
                                                            <span class="f12-red">不可截图(请长按保存图片)</span>
                                                            <br>
                                                            <span class="f12-grass-green">(浏览≥2分钟)</span>
                                                            <br>
                                                            <span>副宝贝:即同店铺，其他宝贝（非目标宝贝)</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php if ($task_detail->favorite_shop == STATUS_ENABLE): ?>
                                        <div class="cd-timeline-block">
                                            <div class="cd-timeline-img cd-picture"><?php echo $step++; ?></div>
                                            <div class="cd-timeline-content">
                                                <div class="pic-title">收藏店铺截图</div>
                                                <div class="pic-content">
                                                    <div class="row">
                                                        <div class="col-50 align-center">
                                                            <div class="tieyu-icon image-upload-container">
                                                                <?php if (!empty($task_detail->favorite_shop_prove_pic)): ?>
                                                                    <img data-input-name="favorite_shop_prove_pic" class="image-upload" src="<?php echo CDN_DOMAIN_TEMP . $task_detail->favorite_shop_prove_pic; ?>">
                                                                    <div class="image-uppload-tips">收藏店铺<br>截图</div>
                                                                    <input type="hidden" name="favorite_shop_prove_pic" value="<?php echo $task_detail->favorite_shop_prove_pic; ?>">
                                                                <?php else: ?>
                                                                    <img data-input-name="favorite_shop_prove_pic" class="image-upload" src="<?php echo CDN_BINARY_URL; ?>cross.png">
                                                                    <div class="image-uppload-tips">收藏店铺<br>截图</div>
                                                                    <input type="hidden" name="favorite_shop_prove_pic">
                                                                <?php endif; ?>
                                                            </div>
                                                            <div class="picx-title">
                                                                <span class="f12-red">(停留≥1分钟)</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                    <?php if ($task_detail->favorite_item == STATUS_ENABLE): ?>
                                        <div class="cd-timeline-block">
                                            <div class="cd-timeline-img cd-picture"><?php echo $step++; ?></div>
                                            <div class="cd-timeline-content">
                                                <div class="pic-title">收藏宝贝截图</div>
                                                <div class="pic-content">
                                                    <div class="row">
                                                        <div class="col-50 align-center">
                                                            <div class="tieyu-icon image-upload-container">
                                                                <?php if (!empty($task_detail->favorite_item_prove_pic)): ?>
                                                                    <img data-input-name="favorite_item_prove_pic" class="image-upload" src="<?php echo CDN_DOMAIN_TEMP . $task_detail->favorite_item_prove_pic; ?>">
                                                                    <div class="image-uppload-tips">收藏宝贝<br>截图</div>
                                                                    <input type="hidden" name="favorite_item_prove_pic" value="<?php echo $task_detail->favorite_item_prove_pic; ?>">
                                                                <?php else: ?>
                                                                    <img data-input-name="favorite_item_prove_pic" class="image-upload" src="<?php echo CDN_BINARY_URL; ?>cross.png">
                                                                    <div class="image-uppload-tips">收藏宝贝<br>截图</div>
                                                                    <input type="hidden" name="favorite_item_prove_pic">
                                                                <?php endif; ?>
                                                            </div>
                                                            <div class="picx-title">
                                                                <span class="f12-red">(停留≥1分钟)</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                    <?php if ($task_detail->add_cart == STATUS_ENABLE): ?>
                                        <div class="cd-timeline-block">
                                            <div class="cd-timeline-img cd-picture"><?php echo $step++; ?></div>
                                            <div class="cd-timeline-content">
                                                <div class="pic-title">加入购物车截图</div>
                                                <div class="pic-content">
                                                    <div class="row">
                                                        <div class="col-50 align-center">
                                                            <div class="tieyu-icon image-upload-container">
                                                                <?php if (!empty($task_detail->add_cart_prove_pic)): ?>
                                                                    <img data-input-name="add_cart_prove_pic" class="image-upload" src="<?php echo CDN_DOMAIN_TEMP . $task_detail->add_cart_prove_pic; ?>">
                                                                    <div class="image-uppload-tips">加购<br>截图</div>
                                                                    <input type="hidden" name="add_cart_prove_pic" value="<?php echo $task_detail->add_cart_prove_pic; ?>">
                                                                <?php else: ?>
                                                                    <img data-input-name="add_cart_prove_pic" class="image-upload" src="<?php echo CDN_BINARY_URL; ?>cross.png">
                                                                    <div class="image-uppload-tips">加购<br>截图</div>
                                                                    <input type="hidden" name="add_cart_prove_pic">
                                                                <?php endif; ?>
                                                            </div>
                                                            <div class="picx-title">
                                                                <span class="f12-red">(停留≥1分钟)</span>
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
            </div>
            <?php if ($task_detail->status == Taskengine::TASK_STATUS_MJSH_BTG): ?>
                <div class="row no-gutter" style="margin:20px 0;">
                    <div class="col-100" style="padding:15px;color:orangered;font-size:18px;">
                        做单审核不通过，原因：<?php echo $task_detail->reject_reason; ?>
                        <br>
                        请更正后再次提交审核
                    </div>
                </div>
            <?php endif; ?>
            <?php if ($task_detail->status == Taskengine::TASK_STATUS_DCZ || $task_detail->status == Taskengine::TASK_STATUS_MJSH_BTG): ?>
                <div class="row no-gutter" style="margin:30px 0 80px 0;">
                    <div class="col-50">
                        <a href="#" class="button button-big button-fill color-blue task-go-btn btn-task-save" data-url="<?php echo base_url('task/task_save_handle'); ?>">暂存</a>
                    </div>
                    <div class="col-50">
                        <a href="#" class="button button-big button-fill color-blue task-go-btn btn-task-commit" data-url="<?php echo base_url('task/task_commit_handle'); ?>">提交审核</a>
                    </div>
                </div>
            <?php endif; ?>
            <?php if ($task_detail->status == Taskengine::TASK_STATUS_DCZ): ?>
                <div class="row no-gutter" style="margin:20px 0;">
                    <div class="col-100">
                        <a href="<?php echo base_url('task/cancel_task?task_type=' . $task_detail->task_type . '&task_id=' . $task_detail->id); ?>" class="button button-big button-fill color-red task-go-btn">取消任务</a>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>