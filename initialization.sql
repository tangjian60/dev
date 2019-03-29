
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+08:00";

CREATE DATABASE IF NOT EXISTS `zcm_go` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `zcm_go`;

/*
- create user
*/

CREATE USER 'zcm_go'@'%' IDENTIFIED BY 'zcm_go**zcm_go';

/*
- authorize
*/

GRANT SELECT,CREATE,INSERT,DELETE,UPDATE,DROP ON zcm_go.* TO 'zcm_go'@'%';

DROP TABLE IF EXISTS `hilton_managers`;
CREATE TABLE IF NOT EXISTS `hilton_managers` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `user_name` varchar(512) NOT NULL,
  `real_name` varchar(512) NOT NULL,
  `passwd` varchar(512) NOT NULL,
  `account_role` enum('boss','staff') NOT NULL,
  `gmt_create` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` tinyint unsigned NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`)
) ENGINE=InnoDb DEFAULT CHARSET=utf8;

-- init data
INSERT INTO `hilton_managers` VALUES (1,'admin','超级管理员','11016f87580f41dec47d132d00d4f580a24520cc','boss',CURRENT_TIMESTAMP,1);

CREATE TABLE IF NOT EXISTS `manager_authorize` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `manage_id` int unsigned NOT NULL,
  `authority_id` int unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDb DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `user_members` (
  `id` int unsigned NOT NULL AUTO_INCREMENT COMMENT '用户编号',
  `user_name` varchar(32) NOT NULL COMMENT '用户名',
  `passwd` varchar(64) NOT NULL COMMENT '密码',
  `user_type` tinyint unsigned NOT NULL COMMENT '用户类型1:买家2:卖家',
  `balance` decimal(15,2) NOT NULL DEFAULT 0 COMMENT '余额',
  `balance_capital` decimal(15,2) NOT NULL DEFAULT '0.00' COMMENT '本金余额',
  `balance_commission` decimal(15,2) NOT NULL DEFAULT '0.00' COMMENT '佣金余额',
  `commission_discount` tinyint unsigned NOT NULL DEFAULT 100 COMMENT '佣金折扣',
  `service_fee_discount` tinyint unsigned NOT NULL DEFAULT 0 COMMENT '服务费折扣',
  `withdraw_enabled` tinyint unsigned NOT NULL DEFAULT 1 COMMENT '是否允许提现',
  `freezing_amount` decimal(15,2) NOT NULL DEFAULT 0 COMMENT '冻结金额',
  `auth_status` tinyint unsigned NOT NULL DEFAULT 0 COMMENT '实名认证状态',
  `bank_edit_status` tinyint unsigned NOT NULL DEFAULT 0 COMMENT '银行信息编辑状态',
  `is_kaoshi` tinyint unsigned NOT NULL DEFAULT 0 COMMENT '是否考试通过',
  `reg_time` datetime NOT NULL COMMENT '注册时间',
  `last_active_time` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '最后活动时间',
  `login_cnt` int unsigned NOT NULL DEFAULT 0 COMMENT '登录次数',
  `task_cnt` int unsigned NOT NULL DEFAULT 0 COMMENT '做单数',
  `status` tinyint unsigned NOT NULL DEFAULT 1 COMMENT '用户状态',
  `first_reward` tinyint(3) DEFAULT '0' COMMENT '是否已完成首单奖励(暂留)',
  PRIMARY KEY (`id`),
  KEY (`user_name`)
) ENGINE=InnoDb DEFAULT CHARSET=utf8;

INSERT INTO `user_members` (`id`, `user_name`, `passwd`, `user_type`, `reg_time`) VALUES (1, 'SYSTEM', 'SYSTEM', '3', '2018-07-01 00:00:00');

DROP TABLE IF EXISTS `promote_relation`;
CREATE TABLE IF NOT EXISTS `promote_relation` (
  `id` int unsigned NOT NULL AUTO_INCREMENT COMMENT '编号',
  `owner_id` int unsigned NOT NULL COMMENT '推荐人id',
  `promote_id` int unsigned NOT NULL COMMENT '被推荐人id',
  `first_reward` tinyint unsigned NOT NULL DEFAULT 0 COMMENT '是否已完成首单奖励',
  `promote_time` datetime DEFAULT CURRENT_TIMESTAMP COMMENT '推荐时间',
  `validity_time` datetime NOT NULL COMMENT '推荐有效期',
  `status` tinyint unsigned NOT NULL DEFAULT 1 COMMENT '推广状态',
  PRIMARY KEY (`id`)
) ENGINE=InnoDb DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `platform_notice` (
  `id` int unsigned NOT NULL AUTO_INCREMENT COMMENT '编号',
  `oper_id` int unsigned NOT NULL COMMENT '操作员ID',
  `notice_type` tinyint unsigned NOT NULL COMMENT '通知类型1:所有2:针对买手3:针对商家',
  `title` varchar(512) NOT NULL COMMENT '通知标题',
  `content` text NOT NULL COMMENT '通知内容',
  `gmt_create` datetime DEFAULT CURRENT_TIMESTAMP COMMENT '推送时间',
  `expire_time` datetime NOT NULL COMMENT '过期时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDb DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `user_messages` (
  `id` int unsigned NOT NULL AUTO_INCREMENT COMMENT '编号',
  `oper_id` int unsigned NOT NULL COMMENT '操作员ID',
  `member_id` int unsigned NOT NULL COMMENT '目标会员id',
  `content` text NOT NULL COMMENT '通知内容',
  `read_status` tinyint unsigned NOT NULL DEFAULT 0 COMMENT '是否阅读',
  `gmt_create` datetime DEFAULT CURRENT_TIMESTAMP COMMENT '推送时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDb DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `user_certification` (
  `id` int unsigned NOT NULL AUTO_INCREMENT COMMENT '编号',
  `user_id` int unsigned NOT NULL COMMENT '用户ID',
  `oper_id` int unsigned DEFAULT NULL COMMENT '操作员ID',
  `true_name` varchar(64) NOT NULL COMMENT '真实姓名',
  `id_card_num` varchar(64) NOT NULL COMMENT '身份证号',
  `qq_num` varchar(32) NOT NULL COMMENT 'QQ',
  `bank_card_num` varchar(64) NOT NULL COMMENT '银行卡号',
  `bank_name` varchar(64) NOT NULL COMMENT '开户银行',
  `bank_province` varchar(128) NOT NULL COMMENT '开户银行的省份',
  `bank_city` varchar(128) NOT NULL COMMENT '开户银行的城市',
  `bank_county` varchar(128) NOT NULL COMMENT '开户银行的区县',
  `bank_branch` varchar(256) NOT NULL COMMENT '开户支行',
  `id_card_pic` varchar(512) NOT NULL COMMENT '身份证照片',
  `half_body_pic` varchar(512) NOT NULL COMMENT '半身照片',
  `gmt_create` datetime DEFAULT CURRENT_TIMESTAMP COMMENT '提交认证时间',
  `gmt_update` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP COMMENT '认证状态更新时间',
  `status` tinyint unsigned NOT NULL DEFAULT 0 COMMENT '实名认证状态',
  `edit_status` tinyint unsigned NOT NULL DEFAULT 0 COMMENT '编辑状态',
  PRIMARY KEY (`id`)
) ENGINE=InnoDb DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `user_bind_info` (
  `id` int unsigned NOT NULL AUTO_INCREMENT COMMENT '编号',
  `user_id` int unsigned NOT NULL COMMENT '用户ID',
  `oper_id` int unsigned DEFAULT NULL COMMENT '操作员ID',
  `account_type` tinyint unsigned NOT NULL COMMENT '绑定账号类型',
  `tb_nick` varchar(128) NOT NULL COMMENT '账号名称',
  `tb_rate` tinyint unsigned NOT NULL COMMENT '账号等级',
  `sex` varchar(32) NOT NULL COMMENT '性别',
  `age` tinyint unsigned NOT NULL COMMENT '年龄',
  `tb_receiver_name` varchar(32) NOT NULL COMMENT '收货人姓名',
  `tb_receiver_tel` varchar(32) NOT NULL COMMENT '收货人电话',
  `receiver_province` varchar(128) NOT NULL COMMENT '收货人的省份',
  `receiver_city` varchar(128) NOT NULL COMMENT '收货人的城市',
  `receiver_county` varchar(128) NOT NULL COMMENT '收货人的区县',
  `tb_receiver_addr` varchar(256) NOT NULL COMMENT '收货人街道地址',
  `tb_rate_pic` varchar(512) NOT NULL COMMENT '淘宝截图',
  `alipay_auth_pic` varchar(512) NOT NULL COMMENT '支付宝截图',
  `tb_huabei_pic` varchar(512) DEFAULT NULL COMMENT '花呗截图',
  `gmt_create` datetime DEFAULT CURRENT_TIMESTAMP COMMENT '提交绑定时间',
  `gmt_update` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  `status` tinyint unsigned NOT NULL DEFAULT 0 COMMENT '账号绑定状态',
  `huabei_status` tinyint unsigned NOT NULL DEFAULT 0 COMMENT '花呗绑定状态',
  PRIMARY KEY (`id`)
) ENGINE=InnoDb DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `seller_bind_shops`;
CREATE TABLE IF NOT EXISTS `seller_bind_shops` (
  `id` int unsigned NOT NULL AUTO_INCREMENT COMMENT '编号',
  `seller_id` int unsigned NOT NULL COMMENT '商家ID',
  `platform_type` tinyint unsigned NOT NULL COMMENT '平台类型',
  `oper_id` int unsigned DEFAULT NULL COMMENT '操作员ID',
  `shop_type` tinyint unsigned NOT NULL COMMENT '绑定账号类型',
  `shop_name` varchar(256) NOT NULL COMMENT '店铺名称',
  `shop_url` varchar(512) NOT NULL COMMENT '店铺链接',
  `shop_ww` varchar(128) NOT NULL COMMENT '店主旺旺ID',
  `shop_province` varchar(128) NOT NULL COMMENT '店铺省份',
  `shop_city` varchar(128) NOT NULL COMMENT '店铺城市',
  `shop_county` varchar(128) NOT NULL COMMENT '店铺区县',
  `shop_pic` varchar(512) NOT NULL COMMENT '店铺后台截图',
  `seller_to_nick_interval` smallint unsigned NOT NULL COMMENT '商家对旺旺规则',
  `seller_to_buyer_interval` smallint unsigned NOT NULL COMMENT '商家对买手规则',
  `shop_to_nick_interval` smallint unsigned NOT NULL COMMENT '店铺对旺旺规则',
  `shop_to_buyer_interval` smallint unsigned NOT NULL COMMENT '店铺对买手规则',
  `shop_liuliang_interval` smallint unsigned NOT NULL COMMENT '店铺流量任务规则',
  `shop_add_cart_interval` smallint unsigned NOT NULL COMMENT '店铺收藏加购任务规则',
  `gmt_create` datetime DEFAULT CURRENT_TIMESTAMP COMMENT '提交绑定时间',
  `gmt_update` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  `status` tinyint unsigned NOT NULL DEFAULT 0 COMMENT '店铺绑定状态',
  PRIMARY KEY (`id`)
) ENGINE=InnoDb DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `user_withdraw_record`;
CREATE TABLE IF NOT EXISTS `user_withdraw_record` (
  `id` int unsigned NOT NULL AUTO_INCREMENT COMMENT '编号',
  `user_id` int unsigned NOT NULL COMMENT '提现会员ID',
  `user_name` varchar(32) NOT NULL COMMENT '提现会员名',
  `oper_id` int unsigned DEFAULT NULL COMMENT '操作员ID',
  `amount` decimal(10,2) NOT NULL COMMENT '提现金额',
  `withdraw_service_fee` decimal(10,2) NOT NULL DEFAULT 0 COMMENT '提现手续费',
  `real_name` varchar(64) DEFAULT NULL COMMENT '真实姓名',
  `bank_card_num` varchar(64) NOT NULL COMMENT '银行卡号',
  `bank_name` varchar(64) NOT NULL COMMENT '开户银行',
  `bank_address` varchar(128) NOT NULL COMMENT '开户地区',
  `bank_branch` varchar(64) NOT NULL COMMENT '开户支行',
  `tixian_type`  tinyint(3) NOT NULL COMMENT '（1-本金；2-佣金）',
  `create_time` datetime DEFAULT CURRENT_TIMESTAMP COMMENT '提现时间',
  `update_time` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP COMMENT '处理时间',
  `status` tinyint unsigned NOT NULL DEFAULT 2 COMMENT '提现状态',
  PRIMARY KEY (`id`)
) ENGINE=InnoDb DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `user_top_up_records` (
 `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '编号',
  `seller_id` int(10) unsigned NOT NULL COMMENT '充值商家ID',
  `seller_name` varchar(32) NOT NULL COMMENT '充值商家会员名',
  `oper_id` int(10) unsigned DEFAULT NULL COMMENT '操作员ID',
  `bank_name` varchar(128) NOT NULL COMMENT '银行名称',
  `transfer_person` varchar(128) DEFAULT NULL COMMENT '转账人姓名',
  `transfer_amount` decimal(10,2) NOT NULL COMMENT '充值金额',
  `create_time` datetime DEFAULT CURRENT_TIMESTAMP COMMENT '充值时间',
  `update_time` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP COMMENT '处理时间',
  `status` tinyint(3) unsigned NOT NULL DEFAULT '2' COMMENT '充值状态',
  `zhuanru_bank_name` varchar(128) DEFAULT '' COMMENT '转入银行卡卡号',
  `huikuan_bank_name` varchar(128) DEFAULT '' COMMENT '汇款银行卡信息)',
  `transfer_contact` varchar(128) DEFAULT '' COMMENT '汇款人手机号',
  PRIMARY KEY (`id`)
) ENGINE=InnoDb DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `hilton_bills` (
  `id` int unsigned NOT NULL AUTO_INCREMENT COMMENT '编号',
  `user_id` int unsigned NOT NULL COMMENT '会员ID',
  `oper_id` int unsigned NOT NULL COMMENT '操作员ID',
  `bill_type` tinyint unsigned NOT NULL COMMENT '账单类型',
  `amount` decimal(10,2) NOT NULL COMMENT '金额',
  `balance` decimal(15,2) NOT NULL COMMENT '余额',
  `balance_capital` decimal(15,2) NOT NULL DEFAULT '0.00' COMMENT '本金余额',
  `balance_commission` decimal(15,2) NOT NULL DEFAULT '0.00' COMMENT '佣金余额',
  `gmt_pay` datetime DEFAULT CURRENT_TIMESTAMP COMMENT '支付时间',
  `memo` text COMMENT '账单备注',
  PRIMARY KEY (`id`,`user_id`)
) ENGINE=InnoDb DEFAULT CHARSET=utf8
PARTITION BY HASH(user_id)
PARTITIONS 32;

CREATE TABLE IF NOT EXISTS `task_templates` (
  `id` int unsigned NOT NULL AUTO_INCREMENT COMMENT '编号',
  `platform_type` tinyint unsigned NOT NULL COMMENT '平台类型',
  `seller_id` int unsigned NOT NULL COMMENT '商家ID',
  `shop_id` int unsigned NOT NULL COMMENT '关联的店铺ID',
  `template_name` varchar(128) NOT NULL COMMENT '模板名称',
  `device_type` tinyint unsigned NOT NULL COMMENT '使用设备类型',
  `item_id` varchar(32) NOT NULL COMMENT '宝贝ID',
  `item_title` varchar(256) NOT NULL COMMENT '宝贝名称',
  `item_url` varchar(512) NOT NULL COMMENT '宝贝链接',
  `item_display_price` decimal(10,2) NOT NULL COMMENT '宝贝展示价格',
  `item_pic` varchar(512) NOT NULL COMMENT '宝贝主图',
  `template_note` varchar(512) NOT NULL COMMENT '模板备注',
  `gmt_create` datetime DEFAULT CURRENT_TIMESTAMP COMMENT '模板创建时间',
  `gmt_update` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  `status` tinyint unsigned NOT NULL DEFAULT 1 COMMENT '模板状态',
  PRIMARY KEY (`id`)
) ENGINE=InnoDb DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `hilton_task_parent_orders`;
CREATE TABLE IF NOT EXISTS `hilton_task_parent_orders` (
  `id` int unsigned NOT NULL AUTO_INCREMENT COMMENT '编号',
  `task_type` varchar(32) NOT NULL COMMENT '任务类型',
  `seller_id` int unsigned NOT NULL COMMENT '商家ID',
  `oper_id` int unsigned DEFAULT NULL COMMENT '操作员ID',
  `platform_type` tinyint unsigned NOT NULL COMMENT '平台类型',
  `shop_id` int unsigned NOT NULL COMMENT '关联的店铺ID',
  `device_type` tinyint unsigned NOT NULL COMMENT '使用设备类型',
  `item_id` varchar(32) NOT NULL COMMENT '宝贝ID',
  `item_title` varchar(256) NOT NULL COMMENT '宝贝名称',
  `item_url` varchar(512) NOT NULL COMMENT '宝贝链接',
  `item_pic` varchar(512) NOT NULL COMMENT '宝贝主图',
  `start_time` datetime NOT NULL COMMENT '任务开始时间',
  `end_time` datetime NOT NULL COMMENT '任务结束时间',
  `hand_out_interval` tinyint unsigned NOT NULL COMMENT '放单时间间隔',
  `fee_order_total_capital` decimal(10,2) NOT NULL COMMENT '任务本金',
  `fee_order_total_commission` decimal(10,2) NOT NULL COMMENT '任务佣金',
  `task_cnt` int unsigned NOT NULL COMMENT '任务数',
  `commission_discount` tinyint unsigned NOT NULL DEFAULT 0 COMMENT '佣金折扣',
  `attributes` mediumtext COMMENT '任务参数',
  `gmt_create` datetime DEFAULT CURRENT_TIMESTAMP COMMENT '任务提交时间',
  `gmt_update` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP COMMENT '任务更新时间',
  `status` tinyint unsigned NOT NULL DEFAULT 1 COMMENT '任务状态',
  PRIMARY KEY (`id`)
) ENGINE=InnoDb DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `hilton_task_liuliang`;
CREATE TABLE IF NOT EXISTS `hilton_task_liuliang` (
  `id` int unsigned NOT NULL AUTO_INCREMENT COMMENT '编号',
  `task_type` varchar(32) NOT NULL COMMENT '任务类型',
  `seller_id` int unsigned NOT NULL COMMENT '商家ID',
  `oper_id` int unsigned DEFAULT NULL COMMENT '操作员ID',
  `parent_order_id` int unsigned DEFAULT NULL COMMENT '父订单编号',
  `shop_id` int unsigned NOT NULL COMMENT '关联的店铺ID',
  `shop_type` tinyint unsigned NOT NULL COMMENT '店铺类型',
  `shop_name` varchar(256) NOT NULL COMMENT '店铺名称',
  `shop_ww` varchar(128) NOT NULL COMMENT '店主旺旺ID',
  `device_type` tinyint unsigned NOT NULL COMMENT '使用设备类型',
  `item_id` varchar(32) NOT NULL COMMENT '宝贝ID',
  `item_title` varchar(256) NOT NULL COMMENT '宝贝名称',
  `item_url` varchar(512) NOT NULL COMMENT '宝贝链接',
  `item_display_price` varchar(32) NOT NULL COMMENT '宝贝展示价格',
  `item_pic` varchar(512) NOT NULL COMMENT '宝贝主图',
  `task_method` varchar(64) NOT NULL COMMENT '任务入口',
  `task_method_details` varchar(1024) NOT NULL COMMENT '任务入口',
  `sort_type` varchar(16) NOT NULL COMMENT '排序方式',
  `buyer_cnt` varchar(16) NOT NULL COMMENT '收货人数',
  `sku` varchar(64) NOT NULL COMMENT '尺码规格',
  `is_preferred` varchar(8) NOT NULL COMMENT '是否优先放单',
  `favorite_shop` varchar(8) NOT NULL COMMENT '是否收藏店铺',
  `favorite_item` varchar(8) NOT NULL COMMENT '是否收藏宝贝',
  `add_cart` varchar(8) NOT NULL COMMENT '是否加购',
  `start_time` datetime NOT NULL COMMENT '任务开始时间',
  `end_time` datetime NOT NULL COMMENT '任务结束时间',
  `task_note` varchar(512) NOT NULL COMMENT '任务备注',
  `buyer_id` int unsigned DEFAULT NULL COMMENT '接单会员ID',
  `buyer_tb_nick` varchar(128) NOT NULL COMMENT '接单淘宝nick',
  `gmt_taking_task` datetime DEFAULT NULL COMMENT '接单时间',
  `zhusou_prove_pic` varchar(512) DEFAULT NULL COMMENT '主搜截图',
  `item_check_status` tinyint unsigned NOT NULL DEFAULT 0 COMMENT '商品核对状态',
  `zhubaobei_prove_pic` varchar(512) DEFAULT NULL COMMENT '宝贝详情页',
  `fubaobei_prove_pic` varchar(512) DEFAULT NULL COMMENT '副宝贝详情页',
  `favorite_shop_prove_pic` varchar(512) DEFAULT NULL COMMENT '收藏店铺截图',
  `favorite_item_prove_pic` varchar(512) DEFAULT NULL COMMENT '收藏宝贝截图',
  `add_cart_prove_pic` varchar(512) DEFAULT NULL COMMENT '加购截图',
  `commission_discount` tinyint unsigned NOT NULL DEFAULT 0 COMMENT '佣金折扣',
  `single_task_commission` decimal(10,2) NOT NULL COMMENT '佣金金额',
  `single_task_commission_paid` decimal(10,2) NOT NULL COMMENT '卖家实付',
  `commission_to_buyer` decimal(10,2) NOT NULL COMMENT '支付给买家金额',
  `commission_to_platform` decimal(10,2) NOT NULL COMMENT '平台抽成金额',
  `service_to_platform` decimal(10,2) NOT NULL COMMENT '平台服务费',
  `gmt_create` datetime DEFAULT CURRENT_TIMESTAMP COMMENT '任务提交时间',
  `gmt_update` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP COMMENT '任务更新时间',
  `reject_reason` varchar(1024) NOT NULL COMMENT '审核不通过原因',
  `status` tinyint unsigned NOT NULL DEFAULT 1 COMMENT '任务状态',
  `refund_clearing_status` tinyint unsigned NOT NULL DEFAULT 0 COMMENT '退款资金清算状态',
  `commission_clearing_status` tinyint unsigned NOT NULL DEFAULT 0 COMMENT '任务佣金清算状态',
  PRIMARY KEY (`id`)
) ENGINE=InnoDb DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `hilton_task_dianfu`;
CREATE TABLE IF NOT EXISTS `hilton_task_dianfu` (
  `id` int unsigned NOT NULL AUTO_INCREMENT COMMENT '编号',
  `task_type` varchar(32) NOT NULL COMMENT '任务类型',
  `seller_id` int unsigned NOT NULL COMMENT '商家ID',
  `oper_id` int unsigned DEFAULT NULL COMMENT '操作员ID',
  `parent_order_id` int unsigned DEFAULT NULL COMMENT '父订单编号',
  `shop_id` int unsigned NOT NULL COMMENT '关联的店铺ID',
  `shop_type` tinyint unsigned NOT NULL COMMENT '店铺类型',
  `shop_name` varchar(256) NOT NULL COMMENT '店铺名称',
  `shop_ww` varchar(128) NOT NULL COMMENT '店主旺旺ID',
  `device_type` tinyint unsigned NOT NULL COMMENT '使用设备类型',
  `item_id` varchar(32) NOT NULL COMMENT '宝贝ID',
  `item_title` varchar(256) NOT NULL COMMENT '宝贝名称',
  `item_url` varchar(512) NOT NULL COMMENT '宝贝链接',
  `item_display_price` varchar(32) NOT NULL COMMENT '宝贝展示价格',
  `item_pic` varchar(512) NOT NULL COMMENT '宝贝主图',
  `task_method` varchar(64) NOT NULL COMMENT '任务入口',
  `task_method_details` varchar(1024) NOT NULL COMMENT '任务入口',
  `sort_type` varchar(16) NOT NULL COMMENT '排序方式',
  `buyer_cnt` varchar(16) NOT NULL COMMENT '收货人数',
  `sku` varchar(64) NOT NULL COMMENT '尺码规格',
  `task_capital` decimal(10,2) NOT NULL COMMENT '任务本金',
  `num_of_pkg` smallint unsigned NOT NULL COMMENT '每单拍的个数',
  `is_coupon`  varchar(32) NOT NULL COMMENT '是否使用优惠券',
  `refunds_mode` varchar(8) NOT NULL COMMENT '是否平台返款',
  `is_blacklist` varchar(8) NOT NULL COMMENT '是否过滤黑名单',
  `is_collection` varchar(8) NOT NULL COMMENT '是否收藏',
  `is_add_cart` varchar(8) NOT NULL COMMENT '是否加购',
  `is_fake_chat` varchar(8) NOT NULL COMMENT '是否假聊',
  `is_compete_collection` varchar(8) NOT NULL COMMENT '是否竞品收藏',
  `is_compete_add_cart` varchar(8) NOT NULL COMMENT '是否竞品加购',
  `is_preferred` varchar(8) NOT NULL COMMENT '是否优先放单',
  `is_huabei` varchar(8) NOT NULL COMMENT '是否仅限花呗会员',
  `sex_limit` varchar(8) NOT NULL COMMENT '性别限制',
  `age_limit` varchar(8) NOT NULL COMMENT '年龄限制',
  `tb_rate_limit` varchar(8) NOT NULL COMMENT '等级限制',
  `tb_area_limit` varchar(8) NOT NULL COMMENT '地区限制',
  `comment_type` tinyint unsigned NOT NULL COMMENT '评价方式',
  `comment_text` varchar(1024) COMMENT '评价内容',
  `comment_pic` varchar(1024) COMMENT '评价图片',
  `start_time` datetime NOT NULL COMMENT '任务开始时间',
  `end_time` datetime NOT NULL COMMENT '任务结束时间',
  `task_note` varchar(512) NOT NULL COMMENT '任务备注',
  `buyer_id` int unsigned DEFAULT NULL COMMENT '接单会员ID',
  `buyer_tb_nick` varchar(128) NOT NULL COMMENT '接单淘宝nick',
  `gmt_taking_task` datetime DEFAULT NULL COMMENT '接单时间',
  `zhusou_prove_pic` varchar(512) DEFAULT NULL COMMENT '主搜截图',
  `huobi_1st_prove_pic` varchar(512) DEFAULT NULL COMMENT '货比第一家截图',
  `huobi_2nd_prove_pic` varchar(512) DEFAULT NULL COMMENT '货比第二家截图',
  `huobi_3rd_prove_pic` varchar(512) DEFAULT NULL COMMENT '货比第三家截图',
  `item_check_status` tinyint unsigned NOT NULL DEFAULT 0 COMMENT '商品核对状态',
  `zhubaobei_prove_pic` varchar(512) DEFAULT NULL COMMENT '宝贝详情页',
  `fubaobei_prove_pic` varchar(512) DEFAULT NULL COMMENT '副宝贝详情页',
  `fukuan_prove_pic` varchar(512) DEFAULT NULL COMMENT '付款截图',
  `haoping_prove_pic` varchar(512) DEFAULT NULL COMMENT '好评截图',
  `single_task_capital` decimal(10,2) NOT NULL COMMENT '本金金额',
  `commission_discount` tinyint unsigned NOT NULL DEFAULT 0 COMMENT '佣金折扣',
  `single_task_commission` decimal(10,2) NOT NULL COMMENT '应收佣金',
  `single_task_commission_paid` decimal(10,2) NOT NULL COMMENT '实付佣金',
  `commission_to_buyer` decimal(10,2) NOT NULL COMMENT '支付给买家金额',
  `commission_to_platform` decimal(10,2) NOT NULL COMMENT '平台抽成金额',
  `service_to_platform` decimal(10,2) NOT NULL COMMENT '平台应收服务费',
  `gmt_create` datetime DEFAULT CURRENT_TIMESTAMP COMMENT '任务提交时间',
  `gmt_update` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP COMMENT '任务更新时间',
  `reject_reason` varchar(1024) NOT NULL COMMENT '审核不通过原因',
  `status` tinyint unsigned NOT NULL DEFAULT 1 COMMENT '任务状态',
  `refund_clearing_status` tinyint unsigned NOT NULL DEFAULT 0 COMMENT '退款资金清算状态',
  `capital_clearing_status` tinyint unsigned NOT NULL DEFAULT 0 COMMENT '任务本金清算状态',
  `commission_clearing_status` tinyint unsigned NOT NULL DEFAULT 0 COMMENT '任务佣金清算状态',
  `order_number` varchar(100) DEFAULT NULL COMMENT '订单号',
  PRIMARY KEY (`id`)
) ENGINE=InnoDb DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `hilton_task_pinduoduo`;
CREATE TABLE `hilton_task_pinduoduo` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '编号',
  `task_type` varchar(32) NOT NULL COMMENT '任务类型',
  `seller_id` int(10) unsigned NOT NULL COMMENT '商家ID',
  `oper_id` int(10) unsigned DEFAULT NULL COMMENT '操作员ID',
  `parent_order_id` int(10) unsigned DEFAULT NULL COMMENT '父订单编号',
  `shop_id` int(10) unsigned NOT NULL COMMENT '关联的店铺ID',
  `shop_type` tinyint(3) unsigned NOT NULL COMMENT '店铺类型',
  `shop_name` varchar(256) NOT NULL COMMENT '店铺名称',
  `shop_ww` varchar(128) NOT NULL COMMENT '店主ID',
  `device_type` tinyint(3) unsigned NOT NULL COMMENT '使用设备类型',
  `item_id` varchar(32) NOT NULL COMMENT '宝贝ID',
  `item_title` varchar(256) NOT NULL COMMENT '宝贝名称',
  `item_url` varchar(512) NOT NULL COMMENT '宝贝链接',
  `item_display_price` varchar(32) NOT NULL COMMENT '宝贝展示价格',
  `item_pic` varchar(512) NOT NULL COMMENT '宝贝主图',
  `task_method` varchar(64) NOT NULL COMMENT '任务入口',
  `task_method_details` varchar(1024) NOT NULL COMMENT '任务入口',
  `sort_type` varchar(16) NOT NULL COMMENT '排序方式',
  `buyer_cnt` varchar(16) NOT NULL COMMENT '拼单人数',
  `order_type` varchar(16) NOT NULL COMMENT '下单方式',
  `sku` varchar(64) NOT NULL COMMENT '尺码规格',
  `task_capital` decimal(10,2) NOT NULL COMMENT '任务本金',
  `num_of_pkg` smallint(5) unsigned NOT NULL COMMENT '每单拍的个数',
  `is_coupon` varchar(32) NOT NULL COMMENT '是否使用优惠券',
  `refunds_mode` varchar(8) NOT NULL COMMENT '是否平台返款',
  `is_blacklist` varchar(8) NOT NULL COMMENT '是否过滤黑名单',
  `is_collection` varchar(8) NOT NULL COMMENT '是否收藏',
  `is_wechat_share` varchar(8) NOT NULL COMMENT '是否分享朋友圈',
  `is_fake_chat` varchar(8) NOT NULL COMMENT '是否假聊',
  `is_compete_collection` varchar(8) NOT NULL COMMENT '是否竞品收藏',
  `is_preferred` varchar(8) NOT NULL COMMENT '是否优先放单',
  `comment_type` tinyint(3) unsigned NOT NULL COMMENT '评价方式',
  `comment_text` varchar(1024) DEFAULT NULL COMMENT '评价内容',
  `comment_pic` varchar(1024) DEFAULT NULL COMMENT '评价图片',
  `start_time` datetime NOT NULL COMMENT '任务开始时间',
  `end_time` datetime NOT NULL COMMENT '任务结束时间',
  `task_note` varchar(512) NOT NULL COMMENT '任务备注',
  `buyer_id` int(10) unsigned DEFAULT NULL COMMENT '接单会员ID',
  `buyer_tb_nick` varchar(128) NOT NULL DEFAULT '' COMMENT '接单拼多多nick',
  `gmt_taking_task` datetime DEFAULT NULL COMMENT '接单时间',
  `zhusou_prove_pic` varchar(512) DEFAULT NULL COMMENT '主搜截图',
  `huobi_1st_prove_pic` varchar(512) DEFAULT NULL COMMENT '货比第一家截图',
  `huobi_2nd_prove_pic` varchar(512) DEFAULT NULL COMMENT '货比第二家截图',
  `huobi_3rd_prove_pic` varchar(512) DEFAULT NULL COMMENT '货比第三家截图',
  `item_check_status` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '商品核对状态',
  `zhubaobei_prove_pic` varchar(512) DEFAULT NULL COMMENT '宝贝详情页',
  `fubaobei_prove_pic` varchar(512) DEFAULT NULL COMMENT '副宝贝详情页',
  `fukuan_prove_pic` varchar(512) DEFAULT NULL COMMENT '付款截图',
  `wechat_share_prove_pic` varchar(512) DEFAULT NULL COMMENT '分享截图',
  `haoping_prove_pic` varchar(512) DEFAULT NULL COMMENT '好评截图',
  `single_task_capital` decimal(10,2) NOT NULL COMMENT '本金金额',
  `commission_discount` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '佣金折扣',
  `single_task_commission` decimal(10,2) NOT NULL COMMENT '应收佣金',
  `single_task_commission_paid` decimal(10,2) NOT NULL COMMENT '实付佣金',
  `commission_to_buyer` decimal(10,2) NOT NULL COMMENT '支付给买家金额',
  `commission_to_platform` decimal(10,2) NOT NULL COMMENT '平台抽成金额',
  `service_to_platform` decimal(10,2) NOT NULL COMMENT '平台应收服务费',
  `gmt_create` datetime DEFAULT CURRENT_TIMESTAMP COMMENT '任务提交时间',
  `gmt_update` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP COMMENT '任务更新时间',
  `reject_reason` varchar(1024) NOT NULL COMMENT '审核不通过原因',
  `status` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT '任务状态',
  `refund_clearing_status` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '退款资金清算状态',
  `capital_clearing_status` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '任务本金清算状态',
  `commission_clearing_status` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '任务佣金清算状态',
  `order_number` varchar(100) DEFAULT NULL COMMENT '订单号',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `hilton_task_cancelled`;
CREATE TABLE IF NOT EXISTS `hilton_task_cancelled` (
  `id` int unsigned NOT NULL AUTO_INCREMENT COMMENT '编号',
  `task_type` varchar(32) NOT NULL COMMENT '任务类型',
  `task_id` int unsigned NOT NULL COMMENT '任务ID',
  `seller_id` int unsigned NOT NULL COMMENT '商家ID',
  `parent_order_id` int unsigned DEFAULT NULL COMMENT '父订单编号',
  `shop_id` int unsigned NOT NULL COMMENT '关联的店铺ID',
  `device_type` tinyint unsigned NOT NULL COMMENT '使用设备类型',
  `item_id` varchar(32) NOT NULL COMMENT '宝贝ID',
  `item_pic` varchar(512) NOT NULL COMMENT '宝贝主图',
  `buyer_id` int unsigned DEFAULT NULL COMMENT '接单会员ID',
  `buyer_tb_nick` varchar(128) NOT NULL COMMENT '接单淘宝nick',
  `gmt_cancelled` datetime DEFAULT CURRENT_TIMESTAMP COMMENT '取消订单时间',
  `cancel_reason` varchar(1024) NOT NULL COMMENT '取消原因',
  `status` tinyint unsigned NOT NULL DEFAULT 9 COMMENT '任务状态',
  PRIMARY KEY (`id`)
) ENGINE=InnoDb DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `promote_records`;
CREATE TABLE IF NOT EXISTS `promote_records` (
  `id` int unsigned NOT NULL AUTO_INCREMENT COMMENT '编号',
  `owner_id` int unsigned NOT NULL COMMENT '推荐人id',
  `promote_id` int unsigned NOT NULL COMMENT '被推荐人id',
  `promote_type` tinyint unsigned NOT NULL COMMENT '推广奖励类型',
  `task_type` varchar(32) NOT NULL COMMENT '任务类型',
  `task_id` int unsigned NOT NULL COMMENT '任务id',
  `amount` decimal(10,2) NOT NULL COMMENT '推广所得金额',
  `gmt_create` datetime DEFAULT CURRENT_TIMESTAMP COMMENT '时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDb DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `seller_bind_bankcards` (
  `id` int unsigned NOT NULL AUTO_INCREMENT COMMENT '编号',
  `seller_id` int unsigned NOT NULL COMMENT '商家ID',
  `true_name` varchar(64) NOT NULL COMMENT '真实姓名',
  `bank_card_num` varchar(64) NOT NULL COMMENT '银行卡号',
  `bank_name` varchar(64) NOT NULL COMMENT '开户银行',
  `bank_province` varchar(128) NOT NULL COMMENT '开户银行的省份',
  `bank_city` varchar(128) NOT NULL COMMENT '开户银行的城市',
  `bank_county` varchar(128) NOT NULL COMMENT '开户银行的区县',
  `bank_branch` varchar(256) NOT NULL COMMENT '开户支行',
  `gmt_create` datetime DEFAULT CURRENT_TIMESTAMP COMMENT '绑定时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDb DEFAULT CHARSET=utf8;