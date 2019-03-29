<div class="navbar">
    <div class="navbar-inner">
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
    <div data-page="login-index" class="page" >
        <div class="page-content">
        <form method="post" id="user_login">
            <div class="content-block-title" style="font-size: 16px;">帐号登录</div>
            <div class="list-block inset">
                <ul style="border: 1px solid #cccccc;">
                    <li class="item-content">
                        <div class="item-media"><i class="icon icon-name"></i></div>
                        <div class="item-inner">
                            <div class="item-input">
                                <input type="text" id="login_account" placeholder="手机号"/>
                            </div>
                        </div>
                    </li>
                    <li class="item-content">
                        <div class="item-media"><i class="icon icon-pos"></i></div>
                        <div class="item-inner">
                            <div class="item-input">
                                <input type="password" id="login_password" placeholder="密码"/>
                            </div>
                        </div>
                    </li>
                </ul>
                <div class="row no-gutter" style="margin-top: 5px;margin-bottom:5px;">

                    <!--<div class="col-50" style="text-align: left;padding-left: 10px;">

                       <a href="<?php /*echo base_url('user/register'); */?>" class="link" id="new_user_register" style="display:inline-block;line-height: 40px">

                            <div style="width: 100px;color: #007aff;">新账号注册

                            </div>
                        </a>

                    </div>-->
                    <div class="col-50" style="text-align: left;padding-left: 10px;"> <a class="link" href="<?php echo base_url('user/forget_passwd'); ?>" style="display:inline-block;line-height: 40px"><div style="width: 100px;color: #007aff;">忘记密码</div></a></div>

                </div>
                <div>
                    <a href="#" id="btn_user_login" class="button button-big button-fill color-blue" data-url="<?php echo base_url('user/login_handler'); ?>">登录</a>
                </div>
            </div>

        </form>
    </div>
</div>
</div>