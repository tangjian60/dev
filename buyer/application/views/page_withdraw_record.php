<div class="navbar">
    <div class="navbar-inner">
        <div class="left sliding">
            <a href="#" class="back link"><i class="icon icon-back"></i><span>返回</span></a>
        </div>
        <div class="center sliding" style="margin-left: 53%;position: absolute;">
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
    <div data-page="page-withdraw-records" class="page">
        <div class="page-content">
            <div class="list-block hilton-infinite-list" style="margin-top:0;">
                <ul></ul>
            </div>
            <div class="infinite-scroll-preloader">
                <a id="load-more" href="#" class="button button-round" data-url="<?php echo base_url('fragment/withdraw_records'); ?>" style="margin:0 35%;color:#007aff;">加载更多</a>
                <div id="load-more-preloader" class="preloader" style="display:none;"></div>
            </div>
        </div>
    </div>
</div>