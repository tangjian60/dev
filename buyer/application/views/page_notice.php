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
                <div class="content-block-title" style="font-weight: bold; font-size: 180%;"><?php echo $notice->title; ?></div>
                <div class="content-block-title"><?php echo $notice->gmt_create; ?></div>
                <div class="content-block" style="background-color:white;padding:8px 15px;">
                    <p>
                        <span style="font-size:16px;">
                            <?php  echo '<pre><h4>' . $notice->content . '</h4></pre>'; ?>
                        </span>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>