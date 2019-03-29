<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2019-03-20 06:05:09 --> 查找用户无session时间3.0994415283203E-6
ERROR - 2019-03-20 06:05:18 --> 查找用户信息时间0.038102149963379<br/>sql->SELECT *
FROM `user_members_copy1`
WHERE `user_name` = '18767193790'
AND `passwd` = 'aa28b675e5a446485cef83284e904376b3835bd6'
AND `user_type` = 1
 LIMIT 1
ERROR - 2019-03-20 06:05:19 --> 更新用户login_cnt时间0.035694122314453<br/>sql->UPDATE `user_members_copy1` SET `login_cnt` = 366
WHERE `id` = '12414'
ERROR - 2019-03-20 06:05:19 --> 用户信息写入redis时间0.0019991397857666
ERROR - 2019-03-20 06:05:19 --> 查找用户信息写入redis总时间0.07757306098938
ERROR - 2019-03-20 06:05:19 --> 用户信息写入session时间1.1920928955078E-5
ERROR - 2019-03-20 06:05:19 --> 查找用户session登陆验证时间5.0067901611328E-6
ERROR - 2019-03-20 06:05:19 --> 查找用户消息时间0.15732622146606<br/>sql->SELECT *
FROM `user_messages_copy1`
WHERE `member_id` IN(0, '12414')
AND `read_status` =0
ORDER BY `read_status` ASC, `id` ASC
ERROR - 2019-03-20 06:05:19 --> 查找用户消息总的时间0.157879114151
ERROR - 2019-03-20 06:05:20 --> 公告时间0.037010908126831<br/>sql->SELECT `title`, `id`
FROM `platform_notice_copy1`
WHERE `notice_type` IN(1, 2)
AND `expire_time` >= '2019-03-20 06:05:19'
ORDER BY `is_top` DESC, `sort` DESC, `id` DESC
 LIMIT 1
ERROR - 2019-03-20 06:05:20 --> 查用户session status时间4.7683715820312E-6
ERROR - 2019-03-20 06:05:20 --> 查找用户绑定信息0.085893154144287<br/>sql->SELECT *
FROM `user_bind_info_copy1`
WHERE `user_id` = '12414'
AND `status` = 1
 LIMIT 1
