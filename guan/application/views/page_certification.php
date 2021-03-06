<h1 class="page-header">实名认证审核</h1>
<form id="form-filter" class="form-inline" action="" method="GET" style="background-color:#fefefe;line-height:65px;">
    <input type="hidden" id="i_page" name="i_page" value="<?php if (!empty($i_page)) echo $i_page; ?>">
    <div class="form-group">
        <label>会员ID</label>
        <input type="text" class="form-control filter-control" name="member_id" placeholder="会员ID" value="<?php if (!empty($member_id)) echo $member_id; ?>">
    </div>
    <div class="form-group">
        <label>开始时间</label>
        <input type="text" class="form-control filter-control format_date" name="start_time" value="<?php if (!empty($start_time)) echo $start_time; ?>">
    </div>
    <div class="form-group">
        <label>结束时间</label>
        <input type="text" class="form-control filter-control format_date" name="end_time" value="<?php if (!empty($end_time)) echo $end_time; ?>">
    </div>
    <a href="javascript:;" class="btn btn-primary filter-btn">提交查询</a>
</form>

<!-- 模态框（Modal） -->
<?php $this->load->view('reject_modal')?>

<?php if (!empty($data)): ?>
    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
            <tr>
                <th>序号</th>
                <th>会员ID</th>
                <th>真实姓名</th>
                <th>身份证号码</th>
                <th>QQ号</th>
                <th>银行卡号</th>
                <th>开户行</th>
                <th>支行名称</th>
                <th>是否渠道</th>
                <th>身份照片</th>
                <th>半身照</th>
                <th>提交时间</th>
                <th>操作</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($data as $k=>$v): ?>
                <tr>
                    <td><?php echo ++$k; ?></td>
                    <td><?php echo encode_id($v->user_id); ?></td>
                    <td><?php echo $v->true_name; ?></td>
                    <td><?php echo $v->id_card_num; ?></td>
                    <td><?php echo $v->qq_num; ?></td>
                    <td><?php echo $v->bank_card_num; ?></td>
                    <td><?php echo $v->bank_name; ?></td>
                    <td><?php echo $v->bank_province . $v->bank_city . $v->bank_branch; ?></td>
                    <td>否</td>
                    <td><a href="<?php echo CDN_DOMAIN . $v->id_card_pic; ?>" class="fancybox"><img class="item-pic-box" src="<?php echo CDN_DOMAIN . $v->id_card_pic; ?>"></a></td>
                    <td><a href="<?php echo CDN_DOMAIN . $v->half_body_pic; ?>" class="fancybox"><img class="item-pic-box" src="<?php echo CDN_DOMAIN . $v->half_body_pic; ?>"></a></td>
                    <td><?php echo $v->gmt_create; ?></td>
                    <td>
                        <a href="javascript:;" class="btn btn-sm btn-success btn-approve" data-id="<?php echo $v->id; ?>" data-user-id="<?php echo $v->user_id; ?>" data-url="<?php echo base_url('certification_review/operation_handle'); ?>">通过</a>
                        <!--<a href="javascript:;" class="btn btn-sm btn-danger btn-reject" data-id="<?php echo $v->id; ?>" data-url="<?php echo base_url('certification_review/operation_handle'); ?>">拒绝</a>
                        <a class="btn btn-sm btn-danger btn-reject2" href="<?php echo base_url('certification_review/reject?id='. $v->id); ?>">拒绝</a>
                        -->
                        <button class="btn btn-sm btn-danger reject" data-id="<?php echo $v->id?>" data-url="<?php echo base_url('certification_review/reject_handle');?>" data-toggle="modal" data-target="#myModal">拒绝</button>
                    </td>
                </tr>
            <?php endforeach; ?>
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

        $(".btn-approve").click(function (e) {
            e.preventDefault();
            var that = $(this);

            if (window.confirm("确定通过此认证信息吗？")) {

                that.addClass('disabled');
                that.attr("disabled", true);

                ajax_request(
                    that.data('url'),
                    {
                        act: 'cert_approve',
                        cert_id: that.data('id'),
                        user_id: that.data('user-id'),
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
            language: 'zh-CN',
            format: 'yyyy-mm-dd hh:ii:00',
            autoclose: true
        });

        $(".fancybox").fancybox();

    });
</script>
<script type="text/javascript" src="<?php echo CDN_BINARY_URL; ?>reject-modal.js?v=1903201439"></script>
