
<div class="navbar">
    <div class="navbar-inner">
        <div class="left sliding">
            <a href="#" class="back link"><i class="icon icon-back"></i><span>返回</span></a>
        </div>
        <div class="center sliding" style="margin-left: 53%;position: absolute;" >
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
<div class="pages navbar-through fixed-through" id="registersss">
    <div data-page="registry-user" class="page" >
        <div class="page-content">
            <div id="qrcode_img" style="display: none;">
                <div class="content-block" style="background-color:white;padding:8px 15px;">
                    <p style="font-size: 21px;">
                        恭喜你注册成为<?php echo HILTON_NAME; ?>会员
                        <br>
                        扫一扫下载app加入赚钱大军吧
                        <br>
                        微信扫一扫下载app
                    </p>
                </div>
                    <img src="<?php echo CDN_BINARY_URL . 'qrcode/' . SYSTEM_CODE_NAME . '_app.png'; ?>" style="width: 100%;">
                </div>
            <form method="post" id="user_register">
                <div class="list-block">
                    <ul>
                        <li class="item-content">
                            <div class="item-inner">
                                <div class="item-title label">手机号码</div>
                                <div class="item-input">
                                    <input type="text" name="user_account" id="user_account" placeholder="请输入手机号">
                                </div>
                            </div>
                        </li>
                        <li class="item-content">
                            <div class="item-inner">
                                <div class="item-title label">图文验证码</div>
                                <div class="item-input">
                                    <table width="100%" border="0">
                                        <tr>
                                            <td width="60%"><input type="text" id="inputCode" placeholder="请输入验证码"></td>
                                            <td width="40%">
                                                <div class="code changecheckcode" id="checkcode" style="
                                                     font-family:Arial;
                                                     font-style:italic;
                                                     background-color:#F79709;
                                                     font-size:20px;
                                                     border:0;
                                                     padding:1px 1.5px;
                                                     letter-spacing:1.5px;
                                                     font-weight:bolder;
                                                     float:left;
                                                     cursor:pointer;
                                                     width:100%;
                                                     height:30px;
                                                     line-height:30px;
                                                     text-align:center;
                                                     vertical-align:middle;"></div>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </li>
                        <li class="item-content">
                            <div class="item-inner">
                                <div class="item-title label">手机验证码</div>
                                <div class="item-input">
                                    <table width="100%" border="0">
                                        <tr>
                                            <td width="60%"><input type="text" id="prov_code" placeholder="请输入手机验证码"/></td>
                                            <td><a href="#" class="button button-fill color-orange" id="CheckMobileReg" data-url="<?php echo base_url('user/send_sms_code'); ?>">获取验证码</a></td>
                                        </tr>
                                    </table>

                                </div>
                            </div>
                        </li>


                        <li class="item-content">
                            <div class="item-inner">
                                <div class="item-title label">登录密码</div>
                                <div class="item-input">
                                    <input type="password" id="passwd" placeholder="请输入密码"/>
                                </div>
                            </div>
                        </li>
                        <li class="item-content">
                            <div class="item-inner">
                                <div class="item-title label">确认密码</div>
                                <div class="item-input">
                                    <input type="password" id="confirmPasswd" placeholder="再次输入密码"/>
                                </div>
                            </div>
                        </li>
                        <?php
                            if ( isset($recommend) && isset($recommend_user) ) {
                        ?>
                        <li class="item-content">
                            <div class="item-inner">
                                <div class="item-title label">推荐人</div>
                                <div class="item-input">
                                    <input type="text"  placeholder="推荐人ID" value="<?php echo $recommend_user; ?>" disabled="disabled"/>
                                    <input type="hidden" name="r" id="r" value="<?php echo $recommend; ?>" />
                                </div>
                            </div>
                        </li>
                        <?php } ?>
                    </ul>
                </div>
                <div class="list-block">
                    <div class="row no-gutter" style="margin-bottom:10px;padding:10px;">
                        <div class="col-50">
                            <a href="#" id="btn_commit_registry" data-url="<?php echo base_url('user/registry_handle'); ?>" class="button button-big button-fill color-red">注册</a>
                        </div>
                        <div class="col-50">
                            <a href="#" class="button button-big button-fill color-green back link">返回登录</a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

