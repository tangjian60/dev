<div class="navbar">
    <div class="navbar-inner">
        <div class="left sliding">
            <a href="#" class="back link"><i class="icon icon-back"></i><span>返回</span></a>
        </div>
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
    <div data-page="bind-account-tb" class="page" >
        <div class="page-content">
            <div class="eula eula-area"><?php $this->load->view('eula_bind'); ?><a id="btn-eula-confirm" href="#" class="button button-big button-fill color-green">我已阅读并接受</a></div>
            <form id="bind_form" style="display:none;">
                <div class="list-block">
                    <ul>
                        <li class="item-content">
                            <div class="item-inner">
                                <div class="item-title label">拼多多会员名</div>
                                <div class="item-input">
                                    <input type="text" name="tb_nick" placeholder="请填写拼多多会员名">
                                </div>
                            </div>
                        </li>
                        <li class="item-content">
                            <div class="item-inner">
                                <div class="item-title label">性别<br></div>
                                <div class="item-input">
                                    <select name="sex">
                                        <option value="">请选择</option>
                                        <option value="男">男</option>
                                        <option value="女">女</option>
                                    </select>
                                </div>
                            </div>
                        </li>
                        <li class="item-content">
                            <div class="item-inner">
                                <div class="item-title label">年龄</div>
                                <div class="item-input">
                                    <select name="age">
                                        <option value="">请选择</option>
                                        <option value="15">15-25岁</option>
                                        <option value="26">26-35岁</option>
                                        <option value="36">36-45岁</option>
                                        <option value="46">46-55岁</option>
                                        <option value="56">56岁以上</option>
                                    </select>
                                </div>
                            </div>
                        </li>
                        <li class="item-content">
                            <div class="item-inner">
                                <div class="item-title label">收货人姓名</div>
                                <div class="item-input">
                                    <input type="text" name="tb_receiver_name" placeholder="请填写收货人姓名">
                                </div>
                            </div>
                        </li>
                        <li class="item-content">
                            <div class="item-inner">
                                <div class="item-title label">收货人电话</div>
                                <div class="item-input">
                                    <input type="number" name="tb_receiver_tel" placeholder="请填写收货人电话"  onmousewheel="return false;" min="0">
                                </div>
                            </div>
                        </li>
                        <li class="item-content">
                            <div class="item-inner">
                                <div class="item-title label">收货地址
                                    <p style="color: red; font-size: 70%">不同买号的地址不能相同，<br>否则审核不过</p>
                                </div>
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
                        <a href="#" id="btn_submit_bind" class="button button-big button-fill color-blue" data-url="<?php echo base_url('requests/bind_pdd_handle'); ?>">提交</a>
                    </div>
                </div>
                <div style="height:60px;"></div>
            </form>
        </div>
    </div>
</div>