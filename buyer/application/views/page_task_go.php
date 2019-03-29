<div class="navbar">
    <div class="navbar-inner">
        <div class="center sliding" >
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
    <div data-page="page-task-go" class="page">
        <div class="page-content">
            <div class="content-block task-go" data-url="<?php echo base_url('task/claim_task'); ?>">
                <div class="content-block-inner task-go-bg">
                    <p class="task-go-title">抢单中请稍后...</p>
                    <p class="task-go-time"><span></span></p>
                </div>
            </div>
        </div>
    </div>
</div>