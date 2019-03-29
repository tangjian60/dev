<div class="navbar">
    <div class="navbar-inner">
        <div class="center sliding">
            <script>
                function login_success_intercept (uid) {
                    console.log(uid);
                }
                //login_success_intercept("<?php echo $uid; ?>");
            </script>
            <?php
            if ( isset( $navbar_title ) ) {
                echo $navbar_title;
            } else {
                // echo HILTON_NAME;
            }
            ?>
        </div>
    </div>
</div>
<div class="pages navbar-through fixed-through">
    <div data-page="app-main" class="page tabs">
        <div id="task_hall"  class="page-content tab active">
            <div class="pull-to-refresh-layer">
                <div class="preloader"></div>
                <div class="pull-to-refresh-arrow"></div>
            </div>
            <div class="upscroll-data">
                <div class="content-block" style="text-align:center;">
                    <span style="width:45px;height:45px;margin-top:98px;" class="preloader"></span>
                </div>
            </div>
        </div>
        <div id="task_summaries" class="page-content tab pull-to-refresh-content" data-request="<?php echo base_url('fragment/task_summaries'); ?>">
            <div class="pull-to-refresh-layer">
                <div class="preloader"></div>
                <div class="pull-to-refresh-arrow"></div>
            </div>
            <div class="upscroll-data">
                <div class="content-block" style="text-align:center;">
                    <span style="width:45px;height:45px;margin-top:98px;" class="preloader"></span>
                </div>
            </div>
        </div>
        <div id="sd_notice" class="page-content tab pull-to-refresh-content" data-request="<?php echo base_url('fragment/messages'); ?>">
            <div class="pull-to-refresh-layer">
                <div class="preloader"></div>
                <div class="pull-to-refresh-arrow"></div>
            </div>
            <div class="upscroll-data">
                <div class="content-block" style="text-align:center;">
                    <span style="width:45px;height:45px;margin-top:98px;" class="preloader"></span>
                </div>
            </div>
        </div>
        <div id="settings" class="page-content tab">
            <div class="pull-to-refresh-layer">
                <div class="preloader"></div>
                <div class="pull-to-refresh-arrow"></div>
            </div>
            <div class="upscroll-data">
                <div class="content-block" style="text-align:center;">
                    <span style="width:45px;height:45px;margin-top:98px;" class="preloader"></span>
                </div>
            </div>
        </div>
        <div class="toolbar tabbar tabbar-labels">
            <div class="toolbar-inner">
                <a href="#task_hall" data-request="<?php echo base_url('fragment'); ?>" class="btn-tool-item tab-link active">
                    <i class="icon demo-icon-1"></i>
                    <span class="tabbar-label">接单</span>
                </a>
                <a href="#task_summaries" data-request="<?php echo base_url('fragment/task_summaries'); ?>" class="btn-tool-item tab-link">
                    <i class="icon demo-icon-2"></i>
                    <span class="tabbar-label">做单</span>
                </a>
                <a href="#sd_notice" data-request="<?php echo base_url('fragment/messages'); ?>" class="btn-tool-item tab-link">
                    <i class="icon demo-icon-3"></i>
                    <span class="tabbar-label">消息</span>
                </a>
                <a href="#settings" data-request="<?php echo base_url('fragment/settings'); ?>" class="btn-tool-item tab-link">
                    <i class="icon demo-icon-5"></i>
                    <span class="tabbar-label">我的</span>
                </a>
            </div>
        </div>
    </div>
</div>