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
    <div data-page="notice-list" class="page" >
        <div class="page-content">
            <div class="list-block accordion-list">
                <ul><?php foreach($notice_list as $row):?>
                    <li class="accordion-item"><a href="#" class="item-content item-link">
                            <div class="item-media ">
                                <i class="icon"><?php echo substr($row->gmt_create,5,5); ?></i>
                            </div>
                            <div class="item-inner">
                                <div class="item-title" style="color:grey;"><?php echo $row->title;?></div>
                            </div></a>
                        <div class="accordion-item-content">
                            <div class="content-block">
                                <p>
                                    <pre style="margin-left:25px;font-size:14px;"><?php echo $row->content;?></pre>
                                </p>
                            </div>
                        </div>
                    </li>
                <?php endforeach;?></ul>
            </div>
        </div>
    </div>
</div>