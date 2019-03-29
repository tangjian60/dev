<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2019-03-19 17:28:56 --> 查找用户无session时间5.0067901611328E-6
ERROR - 2019-03-19 17:29:01 --> 查找用户信息时间0.038862943649292<br/>sql->SELECT *
FROM `user_members_copy1`
WHERE `user_name` = '18767193790'
AND `passwd` = 'aa28b675e5a446485cef83284e904376b3835bd6'
AND `user_type` = 1
 LIMIT 1
ERROR - 2019-03-19 17:29:01 --> 更新用户login_cnt时间0.060034036636353<br/>sql->UPDATE `user_members_copy1` SET `login_cnt` = 361
WHERE `id` = '12414'
ERROR - 2019-03-19 17:29:01 --> 用户信息写入redis时间0.0015039443969727
ERROR - 2019-03-19 17:29:01 --> 查找用户信息写入redis总时间0.1071240901947
ERROR - 2019-03-19 17:29:01 --> 用户信息写入session时间2.598762512207E-5
ERROR - 2019-03-19 17:29:01 --> 查找用户session登陆验证时间6.1988830566406E-6
ERROR - 2019-03-19 17:29:02 --> 查找用户消息时间0.16042900085449<br/>sql->SELECT *
FROM `user_messages_copy1`
WHERE `member_id` IN(0, '12414')
AND `read_status` =0
ORDER BY `read_status` ASC, `id` ASC
ERROR - 2019-03-19 17:29:02 --> 查找用户消息总的时间0.16813993453979
ERROR - 2019-03-19 17:29:02 --> 公告时间0.037837982177734<br/>sql->SELECT `title`, `id`
FROM `platform_notice_copy1`
WHERE `notice_type` IN(1, 2)
AND `expire_time` >= '2019-03-19 17:29:02'
ORDER BY `is_top` DESC, `sort` DESC, `id` DESC
 LIMIT 1
ERROR - 2019-03-19 17:29:02 --> 查用户session status时间2.0980834960938E-5
ERROR - 2019-03-19 17:29:02 --> 查找用户绑定信息0.086222887039185<br/>sql->SELECT *
FROM `user_bind_info_copy1`
WHERE `user_id` = '12414'
AND `status` = 1
 LIMIT 1
ERROR - 2019-03-19 17:29:20 --> 查找用户无session时间4.0531158447266E-6
ERROR - 2019-03-19 17:29:42 --> 查找用户无session时间4.7683715820312E-6
ERROR - 2019-03-19 17:30:11 --> 查找用户无session时间5.0067901611328E-6
ERROR - 2019-03-19 17:30:37 --> 查找用户无session时间4.0531158447266E-6
ERROR - 2019-03-19 17:30:46 --> 查找用户信息时间0.04019021987915<br/>sql->SELECT *
FROM `user_members_copy1`
WHERE `user_name` = '18767193790'
AND `passwd` = 'aa28b675e5a446485cef83284e904376b3835bd6'
AND `user_type` = 1
 LIMIT 1
ERROR - 2019-03-19 17:30:46 --> 更新用户login_cnt时间0.034924030303955<br/>sql->UPDATE `user_members_copy1` SET `login_cnt` = 362
WHERE `id` = '12414'
ERROR - 2019-03-19 17:30:46 --> 用户信息写入redis时间0.0015017986297607
ERROR - 2019-03-19 17:30:46 --> 查找用户信息写入redis总时间0.083659887313843
ERROR - 2019-03-19 17:30:46 --> 用户信息写入session时间2.6226043701172E-5
ERROR - 2019-03-19 17:30:46 --> 查找用户session登陆验证时间5.0067901611328E-6
ERROR - 2019-03-19 17:30:47 --> 查找用户消息时间0.16120910644531<br/>sql->SELECT *
FROM `user_messages_copy1`
WHERE `member_id` IN(0, '12414')
AND `read_status` =0
ORDER BY `read_status` ASC, `id` ASC
ERROR - 2019-03-19 17:30:47 --> 查找用户消息总的时间0.16953682899475
ERROR - 2019-03-19 17:30:47 --> 公告时间0.037406921386719<br/>sql->SELECT `title`, `id`
FROM `platform_notice_copy1`
WHERE `notice_type` IN(1, 2)
AND `expire_time` >= '2019-03-19 17:30:47'
ORDER BY `is_top` DESC, `sort` DESC, `id` DESC
 LIMIT 1
ERROR - 2019-03-19 17:30:47 --> 查用户session status时间9.0599060058594E-6
ERROR - 2019-03-19 17:30:47 --> 查找用户绑定信息0.090605020523071<br/>sql->SELECT *
FROM `user_bind_info_copy1`
WHERE `user_id` = '12414'
AND `status` = 1
 LIMIT 1
ERROR - 2019-03-19 17:38:37 --> 查找用户消息时间0.15897083282471<br/>sql->SELECT *
FROM `user_messages_copy1`
WHERE `member_id` IN(0, '12414')
AND `read_status` =0
ORDER BY `read_status` ASC, `id` ASC
ERROR - 2019-03-19 17:38:37 --> 查找用户消息总的时间0.1673731803894
ERROR - 2019-03-19 17:38:37 --> 公告时间0.037649869918823<br/>sql->SELECT `title`, `id`
FROM `platform_notice_copy1`
WHERE `notice_type` IN(1, 2)
AND `expire_time` >= '2019-03-19 17:38:37'
ORDER BY `is_top` DESC, `sort` DESC, `id` DESC
 LIMIT 1
ERROR - 2019-03-19 17:38:37 --> 查用户session status时间7.1525573730469E-6
ERROR - 2019-03-19 17:38:37 --> 查找用户绑定信息0.08712100982666<br/>sql->SELECT *
FROM `user_bind_info_copy1`
WHERE `user_id` = '12414'
AND `status` = 1
 LIMIT 1
ERROR - 2019-03-19 17:45:54 --> 查找用户消息时间0.16332912445068<br/>sql->SELECT *
FROM `user_messages_copy1`
WHERE `member_id` IN(0, '12414')
AND `read_status` =0
ORDER BY `read_status` ASC, `id` ASC
ERROR - 2019-03-19 17:45:54 --> 查找用户消息总的时间0.17170095443726
ERROR - 2019-03-19 17:45:55 --> 公告时间0.038902997970581<br/>sql->SELECT `title`, `id`
FROM `platform_notice_copy1`
WHERE `notice_type` IN(1, 2)
AND `expire_time` >= '2019-03-19 17:45:55'
ORDER BY `is_top` DESC, `sort` DESC, `id` DESC
 LIMIT 1
ERROR - 2019-03-19 17:45:55 --> 查用户session status时间9.0599060058594E-6
ERROR - 2019-03-19 17:45:55 --> 查找用户绑定信息0.089786052703857<br/>sql->SELECT *
FROM `user_bind_info_copy1`
WHERE `user_id` = '12414'
AND `status` = 1
 LIMIT 1
ERROR - 2019-03-19 17:47:13 --> 查找用户消息时间0.17119717597961<br/>sql->SELECT *
FROM `user_messages_copy1`
WHERE `member_id` IN(0, '12414')
AND `read_status` =0
ORDER BY `read_status` ASC, `id` ASC
ERROR - 2019-03-19 17:47:13 --> 查找用户消息总的时间0.17863798141479
ERROR - 2019-03-19 17:47:14 --> 公告时间0.040292024612427<br/>sql->SELECT `title`, `id`
FROM `platform_notice_copy1`
WHERE `notice_type` IN(1, 2)
AND `expire_time` >= '2019-03-19 17:47:14'
ORDER BY `is_top` DESC, `sort` DESC, `id` DESC
 LIMIT 1
ERROR - 2019-03-19 17:47:14 --> 查用户session status时间7.8678131103516E-6
ERROR - 2019-03-19 17:47:14 --> 查找用户绑定信息0.08796501159668<br/>sql->SELECT *
FROM `user_bind_info_copy1`
WHERE `user_id` = '12414'
AND `status` = 1
 LIMIT 1
ERROR - 2019-03-19 17:50:37 --> 查找用户消息时间0.15800309181213<br/>sql->SELECT *
FROM `user_messages_copy1`
WHERE `member_id` IN(0, '12414')
AND `read_status` =0
ORDER BY `read_status` ASC, `id` ASC
ERROR - 2019-03-19 17:50:37 --> 查找用户消息总的时间0.16570711135864
ERROR - 2019-03-19 17:50:37 --> 公告时间0.036226987838745<br/>sql->SELECT `title`, `id`
FROM `platform_notice_copy1`
WHERE `notice_type` IN(1, 2)
AND `expire_time` >= '2019-03-19 17:50:37'
ORDER BY `is_top` DESC, `sort` DESC, `id` DESC
 LIMIT 1
ERROR - 2019-03-19 17:50:37 --> 查用户session status时间0
ERROR - 2019-03-19 17:50:37 --> 查找用户绑定信息0.085706949234009<br/>sql->SELECT *
FROM `user_bind_info_copy1`
WHERE `user_id` = '12414'
AND `status` = 1
 LIMIT 1
ERROR - 2019-03-19 17:50:37 --> Severity: Notice --> Undefined variable: auth_status /Library/WebServer/Documents/dev/buyer/application/views/fragment_taskhall.php 6
ERROR - 2019-03-19 17:53:33 --> 查找用户消息时间0.16131091117859<br/>sql->SELECT *
FROM `user_messages_copy1`
WHERE `member_id` IN(0, '12414')
AND `read_status` =0
ORDER BY `read_status` ASC, `id` ASC
ERROR - 2019-03-19 17:53:33 --> 查找用户消息总的时间0.16969895362854
ERROR - 2019-03-19 17:53:33 --> 公告时间0.0366530418396<br/>sql->SELECT `title`, `id`
FROM `platform_notice_copy1`
WHERE `notice_type` IN(1, 2)
AND `expire_time` >= '2019-03-19 17:53:33'
ORDER BY `is_top` DESC, `sort` DESC, `id` DESC
 LIMIT 1
ERROR - 2019-03-19 17:53:33 --> 查用户session status时间4.0531158447266E-6
ERROR - 2019-03-19 17:53:34 --> 查找用户绑定信息0.086611986160278<br/>sql->SELECT *
FROM `user_bind_info_copy1`
WHERE `user_id` = '12414'
AND `status` = 1
 LIMIT 1
ERROR - 2019-03-19 17:53:58 --> 查找用户消息时间0.1619119644165<br/>sql->SELECT *
FROM `user_messages_copy1`
WHERE `member_id` IN(0, '12414')
AND `read_status` =0
ORDER BY `read_status` ASC, `id` ASC
ERROR - 2019-03-19 17:53:58 --> 查找用户消息总的时间0.16943693161011
ERROR - 2019-03-19 17:53:59 --> 公告时间0.036723852157593<br/>sql->SELECT `title`, `id`
FROM `platform_notice_copy1`
WHERE `notice_type` IN(1, 2)
AND `expire_time` >= '2019-03-19 17:53:59'
ORDER BY `is_top` DESC, `sort` DESC, `id` DESC
 LIMIT 1
ERROR - 2019-03-19 17:53:59 --> 查用户session status时间1.5974044799805E-5
ERROR - 2019-03-19 17:53:59 --> 查找用户绑定信息0.087424993515015<br/>sql->SELECT *
FROM `user_bind_info_copy1`
WHERE `user_id` = '12414'
AND `status` = 1
 LIMIT 1
ERROR - 2019-03-19 17:54:25 --> 查找用户消息时间0.162113904953<br/>sql->SELECT *
FROM `user_messages_copy1`
WHERE `member_id` IN(0, '12414')
AND `read_status` =0
ORDER BY `read_status` ASC, `id` ASC
ERROR - 2019-03-19 17:54:25 --> 查找用户消息总的时间0.17075419425964
ERROR - 2019-03-19 17:54:25 --> 公告时间0.044938087463379<br/>sql->SELECT `title`, `id`
FROM `platform_notice_copy1`
WHERE `notice_type` IN(1, 2)
AND `expire_time` >= '2019-03-19 17:54:25'
ORDER BY `is_top` DESC, `sort` DESC, `id` DESC
 LIMIT 1
ERROR - 2019-03-19 17:54:25 --> 查用户session status时间2.3126602172852E-5
ERROR - 2019-03-19 17:54:25 --> 查找用户绑定信息0.089058876037598<br/>sql->SELECT *
FROM `user_bind_info_copy1`
WHERE `user_id` = '12414'
AND `status` = 1
 LIMIT 1
ERROR - 2019-03-19 17:54:38 --> 查找用户消息时间0.16233682632446<br/>sql->SELECT *
FROM `user_messages_copy1`
WHERE `member_id` IN(0, '12414')
AND `read_status` =0
ORDER BY `read_status` ASC, `id` ASC
ERROR - 2019-03-19 17:54:38 --> 查找用户消息总的时间0.17069315910339
ERROR - 2019-03-19 17:54:38 --> 公告时间0.040428876876831<br/>sql->SELECT `title`, `id`
FROM `platform_notice_copy1`
WHERE `notice_type` IN(1, 2)
AND `expire_time` >= '2019-03-19 17:54:38'
ORDER BY `is_top` DESC, `sort` DESC, `id` DESC
 LIMIT 1
ERROR - 2019-03-19 17:54:38 --> 查用户session status时间1.0013580322266E-5
ERROR - 2019-03-19 17:54:38 --> 查找用户绑定信息0.086926937103271<br/>sql->SELECT *
FROM `user_bind_info_copy1`
WHERE `user_id` = '12414'
AND `status` = 1
 LIMIT 1
ERROR - 2019-03-19 17:55:24 --> 查找用户消息时间0.16220092773438<br/>sql->SELECT *
FROM `user_messages_copy1`
WHERE `member_id` IN(0, '12414')
AND `read_status` =0
ORDER BY `read_status` ASC, `id` ASC
ERROR - 2019-03-19 17:55:24 --> 查找用户消息总的时间0.17059588432312
ERROR - 2019-03-19 17:55:24 --> 公告时间0.039753913879395<br/>sql->SELECT `title`, `id`
FROM `platform_notice_copy1`
WHERE `notice_type` IN(1, 2)
AND `expire_time` >= '2019-03-19 17:55:24'
ORDER BY `is_top` DESC, `sort` DESC, `id` DESC
 LIMIT 1
ERROR - 2019-03-19 17:55:24 --> 查用户session status时间8.8214874267578E-6
ERROR - 2019-03-19 17:55:24 --> 查找用户绑定信息0.094637155532837<br/>sql->SELECT *
FROM `user_bind_info_copy1`
WHERE `user_id` = '12414'
AND `status` = 1
 LIMIT 1
ERROR - 2019-03-19 17:55:45 --> 查找用户消息时间0.18780303001404<br/>sql->SELECT *
FROM `user_messages_copy1`
WHERE `member_id` IN(0, '12414')
AND `read_status` =0
ORDER BY `read_status` ASC, `id` ASC
ERROR - 2019-03-19 17:55:45 --> 查找用户消息总的时间0.19522905349731
ERROR - 2019-03-19 17:55:45 --> 公告时间0.037792205810547<br/>sql->SELECT `title`, `id`
FROM `platform_notice_copy1`
WHERE `notice_type` IN(1, 2)
AND `expire_time` >= '2019-03-19 17:55:45'
ORDER BY `is_top` DESC, `sort` DESC, `id` DESC
 LIMIT 1
ERROR - 2019-03-19 17:55:45 --> 查用户session status时间5.0067901611328E-6
ERROR - 2019-03-19 17:55:45 --> 查找用户绑定信息0.12638211250305<br/>sql->SELECT *
FROM `user_bind_info_copy1`
WHERE `user_id` = '12414'
AND `status` = 1
 LIMIT 1
ERROR - 2019-03-19 17:57:36 --> 公告时间0.038224935531616<br/>sql->SELECT `title`, `id`
FROM `platform_notice_copy1`
WHERE `notice_type` IN(1, 2)
AND `expire_time` >= '2019-03-19 17:57:36'
ORDER BY `is_top` DESC, `sort` DESC, `id` DESC
 LIMIT 1
ERROR - 2019-03-19 17:57:38 --> 公告时间0.060657024383545<br/>sql->SELECT `title`, `id`
FROM `platform_notice_copy1`
WHERE `notice_type` IN(1, 2)
AND `expire_time` >= '2019-03-19 17:57:38'
ORDER BY `is_top` DESC, `sort` DESC, `id` DESC
 LIMIT 1
ERROR - 2019-03-19 17:57:38 --> 查用户session status时间5.0067901611328E-6
ERROR - 2019-03-19 17:57:38 --> 查找用户绑定信息0.09160590171814<br/>sql->SELECT *
FROM `user_bind_info_copy1`
WHERE `user_id` = '12414'
AND `status` = 1
 LIMIT 1
ERROR - 2019-03-19 17:58:24 --> 查找用户无session时间4.0531158447266E-6
ERROR - 2019-03-19 17:58:39 --> 查找用户信息时间0.037448883056641<br/>sql->SELECT *
FROM `user_members_copy1`
WHERE `user_name` = '18767193790'
AND `passwd` = 'aa28b675e5a446485cef83284e904376b3835bd6'
AND `user_type` = 1
 LIMIT 1
ERROR - 2019-03-19 17:58:39 --> 更新用户login_cnt时间0.042830944061279<br/>sql->UPDATE `user_members_copy1` SET `login_cnt` = 363
WHERE `id` = '12414'
ERROR - 2019-03-19 17:58:39 --> 用户信息写入redis时间0.0013461112976074
ERROR - 2019-03-19 17:58:39 --> 查找用户信息写入redis总时间0.088027954101562
ERROR - 2019-03-19 17:58:39 --> 用户信息写入session时间2.7894973754883E-5
ERROR - 2019-03-19 17:58:40 --> 查找用户session登陆验证时间3.814697265625E-6
ERROR - 2019-03-19 17:58:40 --> 查找用户消息时间0.15742301940918<br/>sql->SELECT *
FROM `user_messages_copy1`
WHERE `member_id` IN(0, '12414')
AND `read_status` =0
ORDER BY `read_status` ASC, `id` ASC
ERROR - 2019-03-19 17:58:40 --> 查找用户消息总的时间0.16485595703125
ERROR - 2019-03-19 17:58:40 --> 公告时间0.038969993591309<br/>sql->SELECT `title`, `id`
FROM `platform_notice_copy1`
WHERE `notice_type` IN(1, 2)
AND `expire_time` >= '2019-03-19 17:58:40'
ORDER BY `is_top` DESC, `sort` DESC, `id` DESC
 LIMIT 1
ERROR - 2019-03-19 17:58:40 --> 查用户session status时间6.9141387939453E-6
ERROR - 2019-03-19 17:58:41 --> 查找用户绑定信息0.087857007980347<br/>sql->SELECT *
FROM `user_bind_info_copy1`
WHERE `user_id` = '12414'
AND `status` = 1
 LIMIT 1
ERROR - 2019-03-19 18:04:21 --> 查找用户无session时间4.0531158447266E-6
ERROR - 2019-03-19 18:04:23 --> 查找用户信息时间0.039019823074341<br/>sql->SELECT *
FROM `user_members_copy1`
WHERE `user_name` = '18767193790'
AND `passwd` = 'aa28b675e5a446485cef83284e904376b3835bd6'
AND `user_type` = 1
 LIMIT 1
ERROR - 2019-03-19 18:04:23 --> 更新用户login_cnt时间0.040804862976074<br/>sql->UPDATE `user_members_copy1` SET `login_cnt` = 364
WHERE `id` = '12414'
ERROR - 2019-03-19 18:04:23 --> 用户信息写入redis时间0.0014169216156006
ERROR - 2019-03-19 18:04:23 --> 查找用户信息写入redis总时间0.088685989379883
ERROR - 2019-03-19 18:04:23 --> 用户信息写入session时间4.0054321289062E-5
ERROR - 2019-03-19 18:04:23 --> 查找用户session登陆验证时间5.0067901611328E-6
ERROR - 2019-03-19 18:04:23 --> 查找用户消息时间0.15959000587463<br/>sql->SELECT *
FROM `user_messages_copy1`
WHERE `member_id` IN(0, '12414')
AND `read_status` =0
ORDER BY `read_status` ASC, `id` ASC
ERROR - 2019-03-19 18:04:23 --> 查找用户消息总的时间0.16795420646667
ERROR - 2019-03-19 18:04:24 --> 公告时间0.039386987686157<br/>sql->SELECT `title`, `id`
FROM `platform_notice_copy1`
WHERE `notice_type` IN(1, 2)
AND `expire_time` >= '2019-03-19 18:04:24'
ORDER BY `is_top` DESC, `sort` DESC, `id` DESC
 LIMIT 1
ERROR - 2019-03-19 18:04:24 --> 查用户session status时间7.8678131103516E-6
ERROR - 2019-03-19 18:04:24 --> 查找用户绑定信息0.086719989776611<br/>sql->SELECT *
FROM `user_bind_info_copy1`
WHERE `user_id` = '12414'
AND `status` = 1
 LIMIT 1
