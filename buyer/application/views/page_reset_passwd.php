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
    </div>
</div>
<div class="pages navbar-through fixed-through">
    <!-- Page, data-page contains page name-->
    <div data-page="reset-password" class="page" >
        <div class="page-content">
            <form method="post" id="user_repasswd">
                <div class="list-block">
                    <ul>
                        <li class="item-content">
                            <div class="item-inner">
                                <div class="item-title label">登录手机号</div>
                                <div class="item-input">
                                    <input type="text" id="user_account" placeholder="请输入手机号"/>
                                </div>
                            </div>
                        </li>
                        <li class="item-content">
                            <div class="item-inner">
                                <div class="item-title label">图文验证码</div>
                                <div class="item-input">
                                    <table width="100%" border="0">
                                        <tr>
                                            <td width="60%"><input type="text" name="inputCode" id="inputCode" placeholder="请输入验证码"/></td>
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
                                                     vertical-align:middle;" ></div>
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
                                            <td width="60%"><input type="text" id="prov_code" placeholder="验证码"/></td>
                                            <td><a href="#" class="button button-fill color-orange" id="CheckMobile" data-url="<?php echo base_url('user/send_reset_sms_code'); ?>">获取验证码</a></td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </li>
                        <li class="item-content">
                            <div class="item-inner">
                                <div class="item-title label">新的密码</div>
                                <div class="item-input">
                                    <input type="password" id="passwd" placeholder="请输入密码"/>
                                </div>
                            </div>
                        </li>
                        <li class="item-content">
                            <div class="item-inner">
                                <div class="item-title label">确认新密码</div>
                                <div class="item-input">
                                    <input type="password" id="confirmPasswd" placeholder="再次输入密码"/>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>

                <div class="list-block">
                    <div class="row no-gutter" style="margin-bottom: 10px;padding:10px;">
                        <div class="col-50">
                            <a href="#" class="button button-big button-fill color-red tieyu-buy" id="btn_reset_passwd" data-url="<?php echo base_url('user/reset_pwd_handle'); ?>">提交</a>
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