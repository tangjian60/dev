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
        <div class="right sliding">
            <a id="btn_bill_filter" href="#" class="link icon-only" style="margin-right:15px;" class=" external">筛选</a>
        </div>
    </div>
</div>
<div class="pages navbar-through fixed-through">
    <div data-page="page-bills" class="page" >
        <div class="page-content infinite-scroll">
            <div class="list-block hilton-infinite-list" style="margin-top:0;">
                <input type="hidden" id="b_type" value="">
                <ul></ul>
            </div>
            <div class="infinite-scroll-preloader">
                <a id="load-more" href="#" class="button button-round" data-url="<?php echo base_url('fragment/bill_records'); ?>" style="margin:0 35%;color:#007aff;">加载更多</a>
                <div id="load-more-preloader" class="preloader" style="display:none;"></div>
            </div>
        </div>
    </div>
</div>