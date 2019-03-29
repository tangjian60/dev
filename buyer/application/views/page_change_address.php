<div class="navbar">
    <div class="navbar-inner">
        <div class="left sliding">
            <a href="#" class="back link"><i class="icon icon-back"></i><span>返回</span></a>
        </div>
        <div class="center sliding"  style="margin-left: 53%;position: absolute;">
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
    <div data-page="bind-change-address" class="page" >
        <div class="page-content">
            <form id="bind_form">
                <input type="hidden" name="bind_id" value="<?php echo $bind_info->id; ?>">
                <div class="list-block">
                    <ul>
                        <li class="item-content">
                            <div class="item-inner">
                                <div class="item-title label">淘宝会员名</div>
                                <div class="item-input">
                                    <input type="text" name="tb_nick" value="<?php echo $bind_info->tb_nick; ?>" readonly>
                                </div>
                            </div>
                        </li>
                        <li class="item-content">
                            <div class="item-inner">
                                <div class="item-title label">收货地址</div>
                                <div class="item-input">
                                    <select name="province" id="province">
                                        <option value="">请选择省份</option>
                                    </select>
                                    <select name="city" id="city">
                                        <option value="">请选择城市</option>
                                    </select>
                                    <select name="county" id="county">
                                        <option value="">请选择地区</option>
                                    </select>
                                    <input type="text" name="tb_receiver_addr" placeholder="请填写街道地址">
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
                <div class="list-block inset">
                    <div>
                        <a href="#" id="btn_submit_bind" class="button button-big button-fill color-blue" data-url="<?php echo base_url('requests/change_address_handle'); ?>">提交</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>