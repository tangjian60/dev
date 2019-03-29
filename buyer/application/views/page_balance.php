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
    <div data-page="page-bills" class="page" >
        <div class="page-content infinite-scroll">
            <div class="list-block hilton-infinite-list" style="margin-top:0;">
                <div class="item-content">
                    <div class="item-inner">
                        <span style="font-size:16px;color:black;margin-left:20px;">
                            本金金额<span class="important-numbers"><?php echo $balance->balance_capital; ?></span>元，
                            佣金金额<span class="important-numbers"><?php echo $balance->balance_commission; ?></span>元
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

