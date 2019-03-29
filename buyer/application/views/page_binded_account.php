<div class="navbar">
    <div class="navbar-inner">
        <div class="left sliding">
            <a href="#" class="back link"><i class="icon icon-back"></i><span>返回</span></a>
        </div>
        <div class="center sliding" style="margin-left: 45%;position: absolute;">
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
    <div data-page="binded-list" class="page">
        <div class="page-content">
            <div class="list-block media-list" style="margin-top:0;">
                <ul>
                    <?php foreach ($binded_account_list as $v): ?>
                        <li class="item-content item-link">
                            <div class="item-media">
                                <?php
                                    if ($v->account_type == PLATFORM_TYPE_TAOBAO){
                                        echo $v->status == STATUS_PASSED ? '<img src="' . CDN_BINARY_URL . 'taobao_bind_ok.png">' : '<img src="' . CDN_BINARY_URL . 'taobao.png">';
                                    }elseif ($v->account_type == PLATFORM_TYPE_PINDUODUO){
                                        echo $v->status == STATUS_PASSED ? '<p>拼多多已审核</p>' : '<p>拼多多未通过</p>';
                                    }
                                ?>
                            </div>
                            <div class="item-inner">
                                <div class="item-title-row">
                                    <div class="item-title">
                                        <?php
                                        echo $v->tb_nick;
                                        switch ($v->status) {
                                            case STATUS_CHECKING :
                                                echo '<span class="tieyu-back-darkmagenta tieyu-max-font tieyu-icon-radius unbind-account">等待审核</span>';
                                                break;
                                            case STATUS_FAILED :
                                                echo '<span class="tieyu-back-darkgray tieyu-max-font tieyu-icon-radius unbind-account">审核未通过</span>';
                                                break;
                                            case STATUS_CANCEL :
                                                echo '<span class="tieyu-back-darkgray tieyu-max-font tieyu-icon-radius unbind-account">已解除绑定</span>';
                                                break;
                                        }
                                        switch ($v->huabei_status) {
                                            case STATUS_CHECKING :
                                                echo '<span class="tieyu-back-darkmagenta tieyu-max-font tieyu-icon-radius unbind-account">花呗审核中</span>';
                                                break;
                                            case STATUS_PASSED :
                                                echo '<span class="tieyu-back-green tieyu-max-font tieyu-icon-radius unbind-account">花呗已绑定</span>';
                                                break;
                                            case STATUS_FAILED :
                                                echo '<span class="tieyu-back-darkgray tieyu-max-font tieyu-icon-radius unbind-account">花呗未通过</span>';
                                                break;
                                        }
                                        ?>
                                    </div>
                                    <?php if ($v->status == STATUS_PASSED && $v->huabei_status != STATUS_PASSED && $v->huabei_status != STATUS_CHECKING && $v->account_type == PLATFORM_TYPE_TAOBAO) : ?>
                                        <div class="item-after">
                                            <span class="tieyu-back-blue tieyu-max-font tieyu-icon-radius unbind-account"><a href="<?php echo base_url('pages/bind_huabei?bind_id=' . $v->id); ?>" style="color:white;">绑定花呗</a></span>
                                        </div>
                                    <?php endif ?>
                                    <?php if ($v->status == STATUS_PASSED) : ?>
                                        <div class="item-after">
                                            <span class="tieyu-back-red tieyu-max-font tieyu-icon-radius unbind-account"><a href="<?php echo base_url('pages/change_address?bind_id=' . $v->id); ?>" style="color:white;">修改地址</a></span>
                                        </div>
                                    <?php endif ?>
                                </div>
                                <div class="item-subtitle">
                                    <?php if ($v->account_type == PLATFORM_TYPE_TAOBAO): ?>
                                        <?php echo '<img src="' . CDN_BINARY_URL . '/level/level_' . $v->tb_rate . '.gif">'; ?>
                                    <?php endif; ?>
                                </div>
                                <div class="item-text" style="height:auto;">
                                    <?php echo $v->tb_receiver_name . ' ' . $v->tb_receiver_tel; ?>
                                    <br><?php echo $v->receiver_province . $v->receiver_city . $v->receiver_county . $v->tb_receiver_addr; ?>
                                </div>
                            </div>
                        </li>
                    <?php endforeach ?>
                    <div align="center">
                        <span style="color:#ff4400">温馨提示：</span>
                        <br/>
                        <span style="color:#ff4400">除非是收货地址真的换了才去修改地址，否则别更换地址，容易造成通过的账号重回待审核状态！</span>
                    </div>
                </ul>
            </div>
            <div style="height:50px;"></div>
        </div>
    </div>
</div>