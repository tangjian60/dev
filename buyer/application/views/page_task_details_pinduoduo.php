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
                                <div class="item-title">接单拼多多昵称</div>
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
                                <div style="color: red">如店铺名核实通过并已仔细按是否使用优惠券使用，存在金额<?php echo PRICE_DIFFERENCE; ?>元之内差价可直接正常拍下，该笔本金到账时会自动多退少补。</div>
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
                                    <div class="item-after list-text"><span style="font-size: 30px;color: red;margin-top: -3%;"><?php echo $task_detail->item_display_price; ?></span></div>
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
                                <div class="content-block-inner"><span style="color: red;">接手任务的买号和实际下单的买号必须一致，接单后必须在<?php echo ZUODAN_SHIJIAN_MIN; ?>分钟内完成，通过其它任何途径接过该商品的任务不能再接此单，不得通过淘宝客、返利网购买，发现一律封ID！不能使用信用卡、花呗、淘金币抵扣和红包付款（除非商家特别要求），实际下单地址和平台上绑定的地址必须一致，一定要等到快递真实签收后才能确认收货并好评</span><br><?php echo $task_detail->task_note; ?></div>
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
                        <span style="color:green;font-size:18px;">如暂需离开做单页面，请点击底部“暂存”按钮</span>
                        <ul>
                            <li class="list-group-title"><span class="info-title">操作任务</span></li>
                            <?php $step = 1; ?>
                            <li class="item-content" style="margin-left:0px;">
                                <section id="cd-timeline" class="cd-container">
                                    <div class="cd-timeline-block">
                                        <div class="cd-timeline-img cd-picture"><?php echo $step++; ?></div>
                                        <div class="cd-timeline-content">
                                            <div class="pic-title">货比三家</div>
                                            <div class="pic-content">
                                                <div class="pic-tipk">
                                                    <div class="row no-gutter">
                                                        <div class="col-75">货比：对同类商品的浏览并截图上传，主搜必须截图</div>
                                                    </div>
                                                </div>
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
                                                    <div class="col-50 align-center">
                                                        <div class="tieyu-icon image-upload-container">
                                                            <?php if (!empty($task_detail->huobi_1st_prove_pic)): ?>
                                                                <img data-input-name="huobi_1st_prove_pic" class="image-upload" src="<?php echo CDN_DOMAIN_TEMP . $task_detail->huobi_1st_prove_pic; ?>">
                                                                <div class="image-uppload-tips">货比<br>第一家</div>
                                                                <input type="hidden" name="huobi_1st_prove_pic" value="<?php echo $task_detail->huobi_1st_prove_pic; ?>">
                                                            <?php else: ?>
                                                                <img data-input-name="huobi_1st_prove_pic" class="image-upload" src="<?php echo CDN_BINARY_URL; ?>cross.png">
                                                                <div class="image-uppload-tips">货比<br>第一家</div>
                                                                <input type="hidden" name="huobi_1st_prove_pic">
                                                            <?php endif; ?>
                                                        </div>
                                                        <div class="picx-title">
                                                            <span class="f12-grass-green">(浏览≥1分钟)</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-50 align-center">
                                                        <div class="tieyu-icon image-upload-container">
                                                            <?php if (!empty($task_detail->huobi_2nd_prove_pic)): ?>
                                                                <img data-input-name="huobi_2nd_prove_pic" class="image-upload" src="<?php echo CDN_DOMAIN_TEMP . $task_detail->huobi_2nd_prove_pic; ?>">
                                                                <div class="image-uppload-tips">货比<br>第二家</div>
                                                                <input type="hidden" name="huobi_2nd_prove_pic" value="<?php echo $task_detail->huobi_2nd_prove_pic; ?>">
                                                            <?php else: ?>
                                                                <img data-input-name="huobi_2nd_prove_pic" class="image-upload" src="<?php echo CDN_BINARY_URL; ?>cross.png">
                                                                <div class="image-uppload-tips">货比<br>第二家</div>
                                                                <input type="hidden" name="huobi_2nd_prove_pic">
                                                            <?php endif; ?>
                                                        </div>
                                                        <div class="picx-title">
                                                            <span class="f12-grass-green">(浏览≥1分钟)</span>
                                                        </div>
                                                    </div>
                                                    <div class="col-50 align-center">
                                                        <div class="tieyu-icon image-upload-container">
                                                            <?php if (!empty($task_detail->huobi_3rd_prove_pic)): ?>
                                                                <img data-input-name="huobi_3rd_prove_pic" class="image-upload" src="<?php echo CDN_DOMAIN_TEMP . $task_detail->huobi_3rd_prove_pic; ?>">
                                                                <div class="image-uppload-tips">货比<br>第三家</div>
                                                                <input type="hidden" name="huobi_3rd_prove_pic" value="<?php echo $task_detail->huobi_3rd_prove_pic; ?>">
                                                            <?php else: ?>
                                                                <img data-input-name="huobi_3rd_prove_pic" class="image-upload" src="<?php echo CDN_BINARY_URL; ?>cross.png">
                                                                <div class="image-uppload-tips">货比<br>第三家</div>
                                                                <input type="hidden" name="huobi_3rd_prove_pic">
                                                            <?php endif; ?>
                                                        </div>
                                                        <div class="picx-title">
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
                                                            <div class="col-75">请输入商品链接核对商品信息</div>
                                                        </div>
                                                    </div>
                                                    <div style="padding:8px;">
                                                        <img src="<?php echo CDN_DOMAIN_TEMP . $task_detail->item_pic; ?>" height="80px">
                                                        <input name="check_content" type="text" placeholder="核对内容" style="ime-mode:disabled;background-color:white;">
                                                        <a href="#" class="button button-sm button-fill color-blue btn-check-item-url" data-url="<?php echo base_url('task/item_url_check_handle_pinduoduo'); ?>">核对</a>
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
                                                        <div class="col-75">浏览目标商品和店内的其它宝贝，并截图上传</div>
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
                                                            <span class="f12-grass-green">(浏览≥2分钟)</span>
                                                            <br>
                                                            <span>副宝贝:即同店铺，其他宝贝（非目标宝贝)</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php if (!empty($task_detail->is_collection) && $task_detail->is_collection != NOT_AVAILABLE): ?>
                                        <div class="cd-timeline-block">
                                            <div class="cd-timeline-img cd-picture"><?php echo $step++; ?></div>
                                            <div class="cd-timeline-content">
                                                <div class="pic-title">收藏宝贝</div>
                                                <div class="pic-content">
                                                    <div class="pic-tipk">
                                                        <div class="row no-gutter">
                                                            <div class="col-75">该操作<span style="color:red;">必须完成</span>，无需截图，由平台进行技术监控</div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                    <?php if (!empty($task_detail->is_wechat_share) && $task_detail->is_wechat_share != NOT_AVAILABLE): ?>
                                        <div class="cd-timeline-block">
                                            <div class="cd-timeline-img cd-picture"><?php echo $step++; ?></div>
                                            <div class="cd-timeline-content">
                                                <div class="pic-title">分享到朋友圈</div>
                                                <div class="pic-content">
                                                    <div class="pic-tipk">
                                                        <div class="row no-gutter">
                                                            <div class="col-75">该操作<span style="color:red;">必须完成</span>，无需截图，由平台进行技术监控</div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                    <?php if (!empty($task_detail->is_fake_chat) && $task_detail->is_fake_chat != NOT_AVAILABLE): ?>
                                        <div class="cd-timeline-block">
                                            <div class="cd-timeline-img cd-picture"><?php echo $step++; ?></div>
                                            <div class="cd-timeline-content">
                                                <div class="pic-title">与卖家聊天</div>
                                                <div class="pic-content">
                                                    <div class="pic-tipk">
                                                        <div class="row no-gutter">
                                                            <div class="col-75">该操作<span style="color:red;">必须完成</span>，无需截图，由平台进行技术监控</div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                    <?php if (!empty($task_detail->is_compete_collection) && $task_detail->is_compete_collection != NOT_AVAILABLE): ?>
                                        <div class="cd-timeline-block">
                                            <div class="cd-timeline-img cd-picture"><?php echo $step++; ?></div>
                                            <div class="cd-timeline-content">
                                                <div class="pic-title">收藏其它店铺的商品</div>
                                                <div class="pic-content">
                                                    <div class="pic-tipk">
                                                        <div class="row no-gutter">
                                                            <div class="col-75">该操作<span style="color:red;">必须完成</span>，无需截图，由平台进行技术监控</div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                    <div class="cd-timeline-block">
                                        <div class="cd-timeline-img cd-picture"><?php echo $step++; ?></div>
                                        <div class="cd-timeline-content">
                                            <div class="pic-title">拼多多订单付款截图</div>
                                            <div class="pic-content">
                                                <div class="pic-tipk">
                                                    <div class="row no-gutter">
                                                        <div class="col-75">请在拼多多账单中的订单详情页面截图</div>
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
                                                        <div class="col-75">请将订单详情页中的商户订单号复制到文本框（<span style="color: red;font-size: +2px;">请输入数字</span>）</div>
                                                        <div class="col-25 f12-orange btn-show-tips" data-tip-url="<?php echo CDN_BINARY_URL; ?>tips/order_number.jpg">查看示例</div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-50 align-center">
                                                        <div class="tieyu-icon image-upload-container">
                                                            <input name="order_number" type="text" placeholder="拼多多订单号" style="ime-mode:disabled;background-color:white;width: 300px" value="<?php echo $task_detail->order_number;?>" <?php if($task_detail->status ==8 || $task_detail->status ==4){ echo "disabled='disabled'";};?>>
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
                                                                <input name="real_task_capital" type="number" placeholder="实际付款金额" style="ime-mode:disabled;background-color:white;width: 300px" value="<?php echo ($task_detail->real_task_capital > 0) ? $task_detail->real_task_capital : $task_detail->task_capital * $task_detail->num_of_pkg;?>" <?php if($task_detail->status ==8 || $task_detail->status ==4){ echo "disabled='disabled'";};?> onmousewheel="return false;" min="0">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php if ($task_detail->status == Taskengine::TASK_STATUS_DPJ || $task_detail->status == Taskengine::TASK_STATUS_HPSH_BTG): ?>
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
            <?php if ($task_detail->status == Taskengine::TASK_STATUS_HPSH_BTG): ?>
                <div class="row no-gutter" style="margin:20px 0;">
                    <div class="col-100" style="padding:15px;color:orangered;font-size:18px;">
                        好评审核不通过，原因：<?php echo $task_detail->reject_reason; ?>
                        <br>
                        请更正后再次提交审核
                    </div>
                </div>
            <?php endif; ?>
            <?php if ($task_detail->status == Taskengine::TASK_STATUS_DCZ || $task_detail->status == Taskengine::TASK_STATUS_MJSH_BTG): ?>
                <div class="row no-gutter" style="margin:30px 0;">
                    <div class="col-50">
                        <a href="#" class="button button-big button-fill color-blue task-go-btn btn-task-save" data-url="<?php echo base_url('task/task_save_handle'); ?>">暂存</a>
                    </div>
                    <div class="col-50">
                        <a href="#" class="button button-big button-fill color-blue task-go-btn btn-task-commit" data-url="<?php echo base_url('task/task_commit_handle'); ?>">提交审核</a>
                    </div>
                </div>
            <?php endif; ?>
            <?php if ($task_detail->status == Taskengine::TASK_STATUS_DPJ || $task_detail->status == Taskengine::TASK_STATUS_HPSH_BTG): ?>
                <div class="row no-gutter" style="margin:30px 0 80px 0;">
                    <div class="col-100">
                        <a href="#" class="button button-big button-fill color-blue task-go-btn btn-haoping-commit" data-url="<?php echo base_url('task/task_haoping_handle_pinduoduo'); ?>">提交好评审核</a>
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