
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
    <div data-page="user-spread" class="page">
        <div class="page-content">
            <div class="list-block">
                <div class="content-block" style="background-color:white;padding:8px 15px;">
                    <p>
                        <span style="font-size:18px;font-weight:bold;">推</span>荐用户注册，当受邀人完成第一单任务，您和受邀人都能获取<?php echo PROMOTION_FIRST_REWARD; ?>元赏金作为奖励哦，以后受邀人每完成一单首单任务并获得佣金的同时，您都能获取其佣金的<?php echo $promote_rate; ?>%作为奖励。
                        <br>
                        目前您已经推广了<span class="important-numbers"><?php echo $promote_cnt; ?></span>位有效会员
                    </p>

                    <table border="1" width="100%" style="text-align:center;border-collapse:collapse;" >
                        <tr>
                            <th>推荐人数</th>
                            <th>提成比率</th>
                        </tr>
                        <tr>
                            <td>80人以下</td>
                            <td>5%</td>
                        </tr>
                        <tr>
                            <td>81~280人</td>
                            <td>10%</td>
                        </tr>
                        <tr>
                            <td>281~580人</td>
                            <td>15%</td>
                        </tr>
                        <tr>
                            <td>580人以上</td>
                            <td>20%</td>
                        </tr>
                    </table>


                </div>

                <!-- <div class="content-block-title">推荐链接</div>
                <div class="content-block" style="background-color:white; padding:8px 15px;">
                    <p>
                        <span style="font-size:16px;">
                            <?php echo BUYER_PROMOTE_LINK . encode_id($r); ?>
                        </span>
                    </p>
                </div> -->
                <div>
                    <img src="<?php echo $promote_qrcode; ?>" style="width: 93%; padding:8px 15px;">
                </div>
                <div class="content-block inset">
                    <p>
                        <a class="button button-big button-fill color-red external" onclick="click_copy_link('<?php echo BUYER_PROMOTE_LINK . encode_id($r); ?>');">复制邀请链接</a>
                    </p>
                </div>
                <div class="content-block inset">
                    <p>
                        <a class="button button-big button-fill color-red external" onclick="click_share_link('<?php echo $promote_qrcode; ?>');">分享邀请海报</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>