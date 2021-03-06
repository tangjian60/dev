<h1 class="page-header">会员管理</h1>
<form id="form-filter" class="form-inline" action="" method="GET" style="background-color:#fefefe;line-height:65px;">
    <input type="hidden" id="i_page" name="i_page" value="<?php if (!empty($i_page)) echo $i_page; ?>">
    <div class="form-group">
        <label>会员ID</label>
        <input type="text" class="form-control filter-control" name="member_id" placeholder="会员ID" value="<?php if (!empty($member_id)) echo $member_id; ?>">
    </div>
    <div class="form-group">
        <label>会员名</label>
        <input type="text" class="form-control filter-control" name="user_name" placeholder="会员名" value="<?php if (!empty($user_name)) echo $user_name; ?>">
    </div>
    <div class="form-group">
        <label>注册日期</label>
        <input type="text" class="form-control filter-control format_date" name="regDate" value="<?php if (!empty($regDate)) echo $regDate; ?>">
    </div>
    <div class="form-group">
        <label>是否实名认证</label>
        <select class="form-control filter-control" name="auth_status">
            <option value="">不限</option>
            <?php
            $options = array(
                STATUS_ENABLE => '已实名认证',
                STATUS_DISABLE => '未实名认证'
            );

            foreach ($options as $k => $v) {
                echo '<option value="' . $k . '"';
                if (isset($auth_status) && $auth_status != '' && $k == $auth_status) {
                    echo ' selected';
                }
                echo '>' . $v . '</option>';
            }
            ?>
        </select>
    </div>
    <div class="form-group">
        <label>用户状态</label>
        <select class="form-control filter-control" name="status">
            <option value="">全部</option>
            <?php
            $options = array(
                STATUS_ENABLE => '正常',
                STATUS_DISABLE => '黑名单'
            );

            foreach ($options as $k => $v) {
                echo '<option value="' . $k . '"';
                if (isset($status) && $status != '' && $k == $status) {
                    echo ' selected';
                }
                echo '>' . $v . '</option>';
            }
            ?>
        </select>
    </div>
    <a href="javascript:;" class="btn btn-primary filter-btn">提交查询</a>
</form>
<?php if (!empty($data)): ?>
    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
            <tr>
                <th>序号</th>
                <th>会员ID</th>
                <th>会员名</th>
                <th>实名认证</th>
                <th>余额</th>
                <th>本金</th>
                <th>佣金</th>
                <th>冻结本金金额</th>
                <th>冻结佣金金额</th>
                <th>提现状态</th>
                <th>注册时间</th>
                <th>最后一次登录时间</th>
                <th>状态</th>
                <th>操作</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($data as $k=>$v): ?>
                <tr>
                    <td><?php echo ++$k; ?></td>
                    <td><?php echo encode_id($v->id); ?></td>
                    <td><?php echo $v->user_name; ?></td>
                    <td>
                        <?php
                        switch ($v->auth_status) {
                            case STATUS_ENABLE:
                                echo '通过';
                                break;
                            default:
                                echo '未通过';
                                break;
                        }
                        ?>
                    </td>
                    <td><?php echo $v->balance; ?></td>
                    <td><?php echo $v->balance_capital; ?></td>
                    <td><?php echo $v->balance_commission; ?></td>
                    <td><?php echo $v->freezing_capital_amount; ?></td>
                    <td><?php echo $v->freezing_commission_amount; ?></td>
                    <td>
                        <?php
                        switch ($v->withdraw_enabled) {
                            case STATUS_ENABLE:
                                echo '允许提现';
                                break;
                            default:
                                echo '不能提现';
                                break;
                        }
                        ?>
                    </td>
                    <td><?php echo $v->reg_time; ?></td>
                    <td><?php echo $v->last_active_time; ?></td>
                    <td>
                        <?php
                        switch ($v->status) {
                            case STATUS_ENABLE:
                                echo '正常';
                                break;
                            default:
                                echo '黑名单';
                                break;
                        }
                        ?>
                    </td>
                    <td>
                        <?php if ($v->status == STATUS_ENABLE): ?>
                            <a href="javascript:;" class="btn btn-sm btn-danger btn-set-blacklist right_space20" data-id="<?php echo $v->id; ?>" data-url="<?php echo base_url('member_manage/operation_handle'); ?>">拉入黑名单</a>
                        <?php else: ?>
                            <a href="javascript:;" class="btn btn-sm btn-default btn-free-blacklist right_space20" data-id="<?php echo $v->id; ?>" data-url="<?php echo base_url('member_manage/operation_handle'); ?>">解除黑名单</a>
                        <?php endif; ?>
                        <a class="btn btn-sm btn-primary" href="<?php echo base_url('member_manage/freezing?member_id=' . encode_id($v->id)); ?>">冻结资金</a>
                        <a class="btn btn-sm btn-primary" href="<?php echo base_url('transaction?user_type='. $v->user_type .'&member_id=' . encode_id($v->id)); ?>">资金操作</a>
                        <a class="btn btn-sm btn-primary" href="<?php echo base_url('member_manage/update?member_id=' . encode_id($v->id) . '&' . $params_get); ?>">信息修改</a>
                    </td>
                </tr>

            <?php endforeach; ?>
            <!--
            <tr>
                <form class="form-inline form-staff-manage" style="line-height: 35px">
                    <td colspan="1"><a href="<?php echo base_url('member_manage/channel');?>" class="btn btn-sm btn-primary" >添加渠道商</a></td>
                </form>
            </tr>
            -->
            </tbody>
        </table>
    </div>
    <?php $this->load->view('fragment_pagination'); ?>
<?php endif; ?>
<script>
    $(function () {
        $('.filter-btn').click(function (e) {
            e.preventDefault();
            $('#i_page').val(1);
            $('#form-filter').submit();
        });

        $(".btn-set-blacklist").click(function (e) {
            e.preventDefault();
            var that = $(this);

            if (window.confirm("确定将此账号列入黑名单吗？")) {

                that.addClass('disabled');
                that.attr("disabled", true);

                ajax_request(
                    that.data('url'),
                    {
                        act: 'set_black',
                        member_id: that.data('id')
                    },
                    function (e) {
                        if (e.code == CODE_SUCCESS) {
                            location.reload();
                        } else {
                            alert(e.msg);
                            that.removeClass('disabled');
                            that.attr("disabled", false);
                        }
                    });
            }
        });

        $(".btn-free-blacklist").click(function (e) {
            e.preventDefault();
            var that = $(this);

            if (window.confirm("确定解除此账号的黑名单吗？")) {

                that.addClass('disabled');
                that.attr("disabled", true);

                ajax_request(
                    that.data('url'),
                    {
                        act: 'unset_black',
                        member_id: that.data('id')
                    },
                    function (e) {
                        if (e.code == CODE_SUCCESS) {
                            location.reload();
                        } else {
                            alert(e.msg);
                            that.removeClass('disabled');
                            that.attr("disabled", false);
                        }
                    });
            }
        });

        $(".format_date").datetimepicker({
            minView: 'month',
            language: 'zh-CN',
            format: 'yyyy-mm-dd',
            autoclose: true
        });
    });
</script>