<div class="navbar">
    <div class="navbar-inner">
        <div class="left sliding">
            <a href="#" class="back link"><i class="icon icon-back"></i><span>返回</span></a>
        </div>
        <div class="center sliding">
            <?php
            if ( isset( $navbar_title ) ) {
                echo $navbar_title;
            } else {
                echo HILTON_NAME;
            }
            ?>
        </div>
    </div>
</div>
<div class="pages navbar-through fixed-through">
    <div data-page="message-display" class="page" >
        <div class="page-content ">
            <div class="content-block" style="text-align:center;margin:140px 18px;">
                <span style="font-size:28px;color:black;">
                <?php
                    if ( isset($message) ) { echo $message; }
                ?>
                </span>
            </div>
            <?php if ( isset($btn_type) && $btn_type == BTN_TYPE_LOGOUT ) { ?>
                <div class="content-block" style="margin-top:20px;">
                    <p>
                        <a class="button button-big button-fill color-blue external" href="<?php echo base_url('user/log_out'); ?>">安全退出</a>
                    </p>
                </div>
            <?php } elseif ( isset($btn_type) && $btn_type == BTN_TYPE_BACK ){ ?>
                <div class="content-block" style="margin-top:80px;">
                    <p>
                        <a class="button button-big button-fill color-blue back link" href="#">返回</a>
                    </p>
                </div>
            <?php } ?>
        </div>
    </div>
</div>