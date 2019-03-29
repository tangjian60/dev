<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2019-03-22 01:20:36 --> 查找用户无session时间4.0531158447266E-6
ERROR - 2019-03-22 01:20:41 --> 查找用户信息时间0.046581029891968<br/>sql->SELECT *
FROM `user_members_copy1`
WHERE `user_name` = '18767193790'
AND `passwd` = 'aa28b675e5a446485cef83284e904376b3835bd6'
AND `user_type` = 1
 LIMIT 1
ERROR - 2019-03-22 01:20:41 --> 更新用户login_cnt时间0.035565853118896<br/>sql->UPDATE `user_members_copy1` SET `login_cnt` = 369
WHERE `id` = '12414'
ERROR - 2019-03-22 01:20:41 --> 用户信息写入redis时间0.0043141841888428
ERROR - 2019-03-22 01:20:41 --> 查找用户信息写入redis总时间0.089777946472168
ERROR - 2019-03-22 01:20:41 --> 用户信息写入session时间1.215934753418E-5
ERROR - 2019-03-22 01:20:41 --> 查找用户session登陆验证时间5.0067901611328E-6
ERROR - 2019-03-22 01:20:42 --> 查找用户消息时间0.16756200790405<br/>sql->SELECT *
FROM `user_messages_copy1`
WHERE `member_id` IN(0, '12414')
AND `read_status` =0
ORDER BY `read_status` ASC, `id` ASC
ERROR - 2019-03-22 01:20:42 --> 查找用户消息总的时间0.16809415817261
ERROR - 2019-03-22 01:20:42 --> 公告时间0.038664102554321<br/>sql->SELECT `title`, `id`
FROM `platform_notice_copy1`
WHERE `notice_type` IN(1, 2)
AND `expire_time` >= '2019-03-22 01:20:42'
ORDER BY `is_top` DESC, `sort` DESC, `id` DESC
 LIMIT 1
ERROR - 2019-03-22 01:20:42 --> 查用户session status时间5.0067901611328E-6
ERROR - 2019-03-22 01:20:42 --> 查找用户绑定信息0.088272094726562<br/>sql->SELECT *
FROM `user_bind_info_copy1`
WHERE `user_id` = '12414'
AND `status` = 1
 LIMIT 1
ERROR - 2019-03-22 01:21:08 --> 查找用户消息时间0.16485190391541<br/>sql->SELECT *
FROM `user_messages_copy1`
WHERE `member_id` IN(0, '12414')
AND `read_status` =0
ORDER BY `read_status` ASC, `id` ASC
ERROR - 2019-03-22 01:21:08 --> 查找用户消息总的时间0.16539716720581
ERROR - 2019-03-22 02:15:33 --> 查找用户session登陆验证时间1.0013580322266E-5
ERROR - 2019-03-22 02:15:34 --> 查找用户消息时间0.16570687294006<br/>sql->SELECT *
FROM `user_messages_copy1`
WHERE `member_id` IN(0, '12414')
AND `read_status` =0
ORDER BY `read_status` ASC, `id` ASC
ERROR - 2019-03-22 02:15:34 --> 查找用户消息总的时间0.16625022888184
ERROR - 2019-03-22 02:15:34 --> 公告时间0.035933971405029<br/>sql->SELECT `title`, `id`
FROM `platform_notice_copy1`
WHERE `notice_type` IN(1, 2)
AND `expire_time` >= '2019-03-22 02:15:34'
ORDER BY `is_top` DESC, `sort` DESC, `id` DESC
 LIMIT 1
ERROR - 2019-03-22 02:15:34 --> 查用户session status时间5.0067901611328E-6
ERROR - 2019-03-22 02:15:34 --> 查找用户绑定信息0.086589813232422<br/>sql->SELECT *
FROM `user_bind_info_copy1`
WHERE `user_id` = '12414'
AND `status` = 1
 LIMIT 1
ERROR - 2019-03-22 02:15:40 --> 查找用户无session时间4.0531158447266E-6
ERROR - 2019-03-22 02:15:45 --> 查找用户无session时间2.8610229492188E-6
ERROR - 2019-03-22 06:12:13 --> 查找用户无session时间4.0531158447266E-6
ERROR - 2019-03-22 06:12:15 --> 查找用户信息时间0.037864923477173<br/>sql->SELECT *
FROM `user_members_copy1`
WHERE `user_name` = '18767193790'
AND `passwd` = 'aa28b675e5a446485cef83284e904376b3835bd6'
AND `user_type` = 1
 LIMIT 1
ERROR - 2019-03-22 06:12:15 --> 更新用户login_cnt时间0.034232139587402<br/>sql->UPDATE `user_members_copy1` SET `login_cnt` = 370
WHERE `id` = '12414'
ERROR - 2019-03-22 06:12:15 --> 用户信息写入redis时间0.0017459392547607
ERROR - 2019-03-22 06:12:15 --> 查找用户信息写入redis总时间0.076005220413208
ERROR - 2019-03-22 06:12:15 --> 用户信息写入session时间1.0013580322266E-5
ERROR - 2019-03-22 06:12:15 --> 查找用户session登陆验证时间5.0067901611328E-6
ERROR - 2019-03-22 06:12:16 --> 查找用户消息时间0.16558504104614<br/>sql->SELECT *
FROM `user_messages_copy1`
WHERE `member_id` IN(0, '12414')
AND `read_status` =0
ORDER BY `read_status` ASC, `id` ASC
ERROR - 2019-03-22 06:12:16 --> 查找用户消息总的时间0.16610789299011
ERROR - 2019-03-22 06:12:16 --> 公告时间0.037430047988892<br/>sql->SELECT `title`, `id`
FROM `platform_notice_copy1`
WHERE `notice_type` IN(1, 2)
AND `expire_time` >= '2019-03-22 06:12:16'
ORDER BY `is_top` DESC, `sort` DESC, `id` DESC
 LIMIT 1
ERROR - 2019-03-22 06:12:16 --> 查用户session status时间5.0067901611328E-6
ERROR - 2019-03-22 06:12:16 --> 查找用户绑定信息0.087638139724731<br/>sql->SELECT *
FROM `user_bind_info_copy1`
WHERE `user_id` = '12414'
AND `status` = 1
 LIMIT 1
ERROR - 2019-03-22 06:48:59 --> 查找用户session登陆验证时间5.0067901611328E-6
ERROR - 2019-03-22 06:49:00 --> 查找用户消息时间0.17351698875427<br/>sql->SELECT *
FROM `user_messages_copy1`
WHERE `member_id` IN(0, '12414')
AND `read_status` =0
ORDER BY `read_status` ASC, `id` ASC
ERROR - 2019-03-22 06:49:00 --> 查找用户消息总的时间0.17408800125122
ERROR - 2019-03-22 06:49:00 --> 公告时间0.03732705116272<br/>sql->SELECT `title`, `id`
FROM `platform_notice_copy1`
WHERE `notice_type` IN(1, 2)
AND `expire_time` >= '2019-03-22 06:49:00'
ORDER BY `is_top` DESC, `sort` DESC, `id` DESC
 LIMIT 1
ERROR - 2019-03-22 06:49:00 --> 查用户session status时间5.0067901611328E-6
ERROR - 2019-03-22 06:49:00 --> 查找用户绑定信息0.086705923080444<br/>sql->SELECT *
FROM `user_bind_info_copy1`
WHERE `user_id` = '12414'
AND `status` = 1
 LIMIT 1
ERROR - 2019-03-22 06:49:05 --> 查找用户无session时间5.0067901611328E-6
ERROR - 2019-03-22 06:49:13 --> 查找用户信息时间0.037798881530762<br/>sql->SELECT *
FROM `user_members_copy1`
WHERE `user_name` = '18767193790'
AND `passwd` = 'aa28b675e5a446485cef83284e904376b3835bd6'
AND `user_type` = 1
 LIMIT 1
ERROR - 2019-03-22 06:49:13 --> 查找用户信息写入redis总时间0.039010047912598
ERROR - 2019-03-22 06:49:20 --> 查找用户信息时间0.037543058395386<br/>sql->SELECT *
FROM `user_members_copy1`
WHERE `user_name` = '18767193790'
AND `passwd` = '7c4a8d09ca3762af61e59520943dc26494f8941b'
AND `user_type` = 1
 LIMIT 1
ERROR - 2019-03-22 06:49:20 --> 更新用户login_cnt时间0.035162925720215<br/>sql->UPDATE `user_members_copy1` SET `login_cnt` = 371
WHERE `id` = '12414'
ERROR - 2019-03-22 06:49:20 --> 用户信息写入redis时间0.0017588138580322
ERROR - 2019-03-22 06:49:20 --> 查找用户信息写入redis总时间0.082927942276001
ERROR - 2019-03-22 06:49:20 --> 用户信息写入session时间2.288818359375E-5
ERROR - 2019-03-22 06:49:20 --> 查找用户session登陆验证时间5.0067901611328E-6
ERROR - 2019-03-22 06:49:20 --> 查找用户消息时间0.17008900642395<br/>sql->SELECT *
FROM `user_messages_copy1`
WHERE `member_id` IN(0, '12414')
AND `read_status` =0
ORDER BY `read_status` ASC, `id` ASC
ERROR - 2019-03-22 06:49:20 --> 查找用户消息总的时间0.17061877250671
ERROR - 2019-03-22 06:49:21 --> 公告时间0.036948919296265<br/>sql->SELECT `title`, `id`
FROM `platform_notice_copy1`
WHERE `notice_type` IN(1, 2)
AND `expire_time` >= '2019-03-22 06:49:21'
ORDER BY `is_top` DESC, `sort` DESC, `id` DESC
 LIMIT 1
ERROR - 2019-03-22 06:49:21 --> 查用户session status时间7.1525573730469E-6
ERROR - 2019-03-22 06:49:21 --> 查找用户绑定信息0.084861040115356<br/>sql->SELECT *
FROM `user_bind_info_copy1`
WHERE `user_id` = '12414'
AND `status` = 1
 LIMIT 1
ERROR - 2019-03-22 06:49:46 --> 查找用户无session时间3.0994415283203E-6
ERROR - 2019-03-22 06:49:55 --> 查找用户信息时间0.036087036132812<br/>sql->SELECT *
FROM `user_members_copy1`
WHERE `user_name` = '18767193790'
AND `passwd` = 'aa28b675e5a446485cef83284e904376b3835bd6'
AND `user_type` = 1
 LIMIT 1
ERROR - 2019-03-22 06:49:55 --> 查找用户信息写入redis总时间0.037330865859985
ERROR - 2019-03-22 06:50:01 --> 查找用户信息时间0.036079883575439<br/>sql->SELECT *
FROM `user_members_copy1`
WHERE `user_name` = '18767193790'
AND `passwd` = '7c4a8d09ca3762af61e59520943dc26494f8941b'
AND `user_type` = 1
 LIMIT 1
ERROR - 2019-03-22 06:50:01 --> 更新用户login_cnt时间0.033860921859741<br/>sql->UPDATE `user_members_copy1` SET `login_cnt` = 372
WHERE `id` = '12414'
ERROR - 2019-03-22 06:50:01 --> 用户信息写入redis时间0.0016641616821289
ERROR - 2019-03-22 06:50:01 --> 查找用户信息写入redis总时间0.07364296913147
ERROR - 2019-03-22 06:50:01 --> 用户信息写入session时间1.0013580322266E-5
ERROR - 2019-03-22 06:50:02 --> 查找用户session登陆验证时间5.0067901611328E-6
ERROR - 2019-03-22 06:50:02 --> 查找用户消息时间0.17306399345398<br/>sql->SELECT *
FROM `user_messages_copy1`
WHERE `member_id` IN(0, '12414')
AND `read_status` =0
ORDER BY `read_status` ASC, `id` ASC
ERROR - 2019-03-22 06:50:02 --> 查找用户消息总的时间0.17384910583496
ERROR - 2019-03-22 06:50:03 --> 公告时间0.036481142044067<br/>sql->SELECT `title`, `id`
FROM `platform_notice_copy1`
WHERE `notice_type` IN(1, 2)
AND `expire_time` >= '2019-03-22 06:50:02'
ORDER BY `is_top` DESC, `sort` DESC, `id` DESC
 LIMIT 1
ERROR - 2019-03-22 06:50:03 --> 查用户session status时间5.0067901611328E-6
ERROR - 2019-03-22 06:50:03 --> 查找用户绑定信息0.086321830749512<br/>sql->SELECT *
FROM `user_bind_info_copy1`
WHERE `user_id` = '12414'
AND `status` = 1
 LIMIT 1
ERROR - 2019-03-22 07:45:13 --> 查找用户无session时间4.0531158447266E-6
ERROR - 2019-03-22 07:45:15 --> 查找用户信息时间0.038084030151367<br/>sql->SELECT *
FROM `user_members_copy1`
WHERE `user_name` = '18767193790'
AND `passwd` = 'aa28b675e5a446485cef83284e904376b3835bd6'
AND `user_type` = 1
 LIMIT 1
ERROR - 2019-03-22 07:45:15 --> 查找用户信息写入redis总时间0.039383888244629
ERROR - 2019-03-22 07:45:21 --> 查找用户信息时间0.036380052566528<br/>sql->SELECT *
FROM `user_members_copy1`
WHERE `user_name` = '18767193790'
AND `passwd` = '7c4a8d09ca3762af61e59520943dc26494f8941b'
AND `user_type` = 1
 LIMIT 1
ERROR - 2019-03-22 07:45:21 --> 更新用户login_cnt时间0.03389310836792<br/>sql->UPDATE `user_members_copy1` SET `login_cnt` = 373
WHERE `id` = '12414'
ERROR - 2019-03-22 07:45:21 --> 用户信息写入redis时间0.0018141269683838
ERROR - 2019-03-22 07:45:21 --> 查找用户信息写入redis总时间0.074219942092896
ERROR - 2019-03-22 07:45:21 --> 用户信息写入session时间1.0013580322266E-5
ERROR - 2019-03-22 07:45:22 --> 查找用户session登陆验证时间4.7683715820312E-6
ERROR - 2019-03-22 07:45:22 --> 查找用户消息时间0.16622400283813<br/>sql->SELECT *
FROM `user_messages_copy1`
WHERE `member_id` IN(0, '12414')
AND `read_status` =0
ORDER BY `read_status` ASC, `id` ASC
ERROR - 2019-03-22 07:45:22 --> 查找用户消息总的时间0.16676592826843
ERROR - 2019-03-22 07:45:22 --> 公告时间0.036696910858154<br/>sql->SELECT `title`, `id`
FROM `platform_notice_copy1`
WHERE `notice_type` IN(1, 2)
AND `expire_time` >= '2019-03-22 07:45:22'
ORDER BY `is_top` DESC, `sort` DESC, `id` DESC
 LIMIT 1
ERROR - 2019-03-22 07:45:22 --> 查用户session status时间5.0067901611328E-6
ERROR - 2019-03-22 07:45:22 --> 查找用户绑定信息0.086522102355957<br/>sql->SELECT *
FROM `user_bind_info_copy1`
WHERE `user_id` = '12414'
AND `status` = 1
 LIMIT 1
ERROR - 2019-03-22 07:50:42 --> 查找用户session登陆验证时间5.0067901611328E-6
ERROR - 2019-03-22 07:50:42 --> 查找用户消息时间0.16777205467224<br/>sql->SELECT *
FROM `user_messages_copy1`
WHERE `member_id` IN(0, '12414')
AND `read_status` =0
ORDER BY `read_status` ASC, `id` ASC
ERROR - 2019-03-22 07:50:42 --> 查找用户消息总的时间0.16831493377686
ERROR - 2019-03-22 07:50:43 --> 公告时间0.037614822387695<br/>sql->SELECT `title`, `id`
FROM `platform_notice_copy1`
WHERE `notice_type` IN(1, 2)
AND `expire_time` >= '2019-03-22 07:50:43'
ORDER BY `is_top` DESC, `sort` DESC, `id` DESC
 LIMIT 1
ERROR - 2019-03-22 07:50:43 --> 查用户session status时间5.9604644775391E-6
ERROR - 2019-03-22 07:50:43 --> 查找用户绑定信息0.087033987045288<br/>sql->SELECT *
FROM `user_bind_info_copy1`
WHERE `user_id` = '12414'
AND `status` = 1
 LIMIT 1
ERROR - 2019-03-22 07:50:49 --> 查找用户无session时间3.814697265625E-6
ERROR - 2019-03-22 08:22:21 --> 查找用户无session时间4.0531158447266E-6
ERROR - 2019-03-22 08:22:23 --> 查找用户信息时间0.038772106170654<br/>sql->SELECT *
FROM `user_members_copy1`
WHERE `user_name` = '18767193790'
AND `passwd` = 'aa28b675e5a446485cef83284e904376b3835bd6'
AND `user_type` = 1
 LIMIT 1
ERROR - 2019-03-22 08:22:23 --> 查找用户信息写入redis总时间0.040215969085693
ERROR - 2019-03-22 08:22:28 --> 查找用户信息时间0.069048166275024<br/>sql->SELECT *
FROM `user_members_copy1`
WHERE `user_name` = '18767193790'
AND `passwd` = '7c4a8d09ca3762af61e59520943dc26494f8941b'
AND `user_type` = 1
 LIMIT 1
ERROR - 2019-03-22 08:22:28 --> 更新用户login_cnt时间0.079583168029785<br/>sql->UPDATE `user_members_copy1` SET `login_cnt` = 374
WHERE `id` = '12414'
ERROR - 2019-03-22 08:22:28 --> 用户信息写入redis时间0.0017931461334229
ERROR - 2019-03-22 08:22:28 --> 查找用户信息写入redis总时间0.15216898918152
ERROR - 2019-03-22 08:22:28 --> 用户信息写入session时间1.0967254638672E-5
ERROR - 2019-03-22 08:22:29 --> 查找用户session登陆验证时间3.814697265625E-6
ERROR - 2019-03-22 08:22:29 --> 查找用户消息时间0.21096301078796<br/>sql->SELECT *
FROM `user_messages_copy1`
WHERE `member_id` IN(0, '12414')
AND `read_status` =0
ORDER BY `read_status` ASC, `id` ASC
ERROR - 2019-03-22 08:22:29 --> 查找用户消息总的时间0.2114679813385
ERROR - 2019-03-22 08:22:30 --> 公告时间0.040588855743408<br/>sql->SELECT `title`, `id`
FROM `platform_notice_copy1`
WHERE `notice_type` IN(1, 2)
AND `expire_time` >= '2019-03-22 08:22:30'
ORDER BY `is_top` DESC, `sort` DESC, `id` DESC
 LIMIT 1
ERROR - 2019-03-22 08:22:30 --> 查用户session status时间7.8678131103516E-6
ERROR - 2019-03-22 08:22:30 --> 查找用户绑定信息0.088143110275269<br/>sql->SELECT *
FROM `user_bind_info_copy1`
WHERE `user_id` = '12414'
AND `status` = 1
 LIMIT 1
ERROR - 2019-03-22 08:30:08 --> 查找用户消息时间0.16524696350098<br/>sql->SELECT *
FROM `user_messages_copy1`
WHERE `member_id` IN(0, '12414')
AND `read_status` =0
ORDER BY `read_status` ASC, `id` ASC
ERROR - 2019-03-22 08:30:08 --> 查找用户消息总的时间0.16583514213562
ERROR - 2019-03-22 08:30:08 --> 公告时间0.036664962768555<br/>sql->SELECT `title`, `id`
FROM `platform_notice_copy1`
WHERE `notice_type` IN(1, 2)
AND `expire_time` >= '2019-03-22 08:30:08'
ORDER BY `is_top` DESC, `sort` DESC, `id` DESC
 LIMIT 1
ERROR - 2019-03-22 08:30:08 --> 查用户session status时间5.0067901611328E-6
ERROR - 2019-03-22 08:30:08 --> 查找用户绑定信息0.086699962615967<br/>sql->SELECT *
FROM `user_bind_info_copy1`
WHERE `user_id` = '12414'
AND `status` = 1
 LIMIT 1
ERROR - 2019-03-22 08:30:12 --> 查找用户无session时间4.0531158447266E-6
ERROR - 2019-03-22 08:30:18 --> 查找用户信息时间0.039024829864502<br/>sql->SELECT *
FROM `user_members_copy1`
WHERE `user_name` = '18767193790'
AND `passwd` = 'aa28b675e5a446485cef83284e904376b3835bd6'
AND `user_type` = 1
 LIMIT 1
ERROR - 2019-03-22 08:30:18 --> 查找用户信息写入redis总时间0.040191888809204
ERROR - 2019-03-22 08:30:24 --> 查找用户信息时间0.038221120834351<br/>sql->SELECT *
FROM `user_members_copy1`
WHERE `user_name` = '18767193790'
AND `passwd` = '7c4a8d09ca3762af61e59520943dc26494f8941b'
AND `user_type` = 1
 LIMIT 1
ERROR - 2019-03-22 08:30:24 --> 更新用户login_cnt时间0.035295009613037<br/>sql->UPDATE `user_members_copy1` SET `login_cnt` = 375
WHERE `id` = '12414'
ERROR - 2019-03-22 08:30:26 --> 查找用户无session时间2.8610229492188E-6
ERROR - 2019-03-22 08:32:17 --> 查找用户无session时间4.0531158447266E-6
ERROR - 2019-03-22 08:32:22 --> 查找用户无session时间1.9073486328125E-6
ERROR - 2019-03-22 08:32:24 --> 查找用户信息时间0.036846160888672<br/>sql->SELECT *
FROM `user_members_copy1`
WHERE `user_name` = '18767193790'
AND `passwd` = 'aa28b675e5a446485cef83284e904376b3835bd6'
AND `user_type` = 1
 LIMIT 1
ERROR - 2019-03-22 08:32:24 --> 查找用户信息写入redis总时间0.038004159927368
ERROR - 2019-03-22 08:32:31 --> 查找用户信息时间0.038774013519287<br/>sql->SELECT *
FROM `user_members_copy1`
WHERE `user_name` = '18767193790'
AND `passwd` = '7c4a8d09ca3762af61e59520943dc26494f8941b'
AND `user_type` = 1
 LIMIT 1
ERROR - 2019-03-22 08:32:31 --> 更新用户login_cnt时间0.035526037216187<br/>sql->UPDATE `user_members_copy1` SET `login_cnt` = 376
WHERE `id` = '12414'
ERROR - 2019-03-22 08:36:46 --> 查找用户无session时间3.0994415283203E-6
ERROR - 2019-03-22 08:36:50 --> 查找用户无session时间2.8610229492188E-6
ERROR - 2019-03-22 08:36:54 --> 查找用户信息时间0.039586067199707<br/>sql->SELECT *
FROM `user_members_copy1`
WHERE `user_name` = '18767193790'
AND `passwd` = 'aa28b675e5a446485cef83284e904376b3835bd6'
AND `user_type` = 1
 LIMIT 1
ERROR - 2019-03-22 08:36:54 --> 查找用户信息写入redis总时间0.042634010314941
ERROR - 2019-03-22 08:37:02 --> 查找用户信息时间0.036619901657104<br/>sql->SELECT *
FROM `user_members_copy1`
WHERE `user_name` = '18767193790'
AND `passwd` = '7c4a8d09ca3762af61e59520943dc26494f8941b'
AND `user_type` = 1
 LIMIT 1
ERROR - 2019-03-22 08:37:02 --> 更新用户login_cnt时间0.034002065658569<br/>sql->UPDATE `user_members_copy1` SET `login_cnt` = 377
WHERE `id` = '12414'
ERROR - 2019-03-22 08:37:52 --> 查找用户无session时间5.0067901611328E-6
ERROR - 2019-03-22 08:37:55 --> 查找用户信息时间0.040311098098755<br/>sql->SELECT *
FROM `user_members_copy1`
WHERE `user_name` = '18767193790'
AND `passwd` = 'aa28b675e5a446485cef83284e904376b3835bd6'
AND `user_type` = 1
 LIMIT 1
ERROR - 2019-03-22 08:37:55 --> 查找用户信息写入redis总时间0.041456937789917
ERROR - 2019-03-22 08:38:01 --> 查找用户信息时间0.037463188171387<br/>sql->SELECT *
FROM `user_members_copy1`
WHERE `user_name` = '18767193790'
AND `passwd` = '7c4a8d09ca3762af61e59520943dc26494f8941b'
AND `user_type` = 1
 LIMIT 1
ERROR - 2019-03-22 08:38:01 --> 更新用户login_cnt时间0.034812927246094<br/>sql->UPDATE `user_members_copy1` SET `login_cnt` = 378
WHERE `id` = '12414'
ERROR - 2019-03-22 08:38:03 --> Severity: Warning --> Redis::connect(): connect() failed: ???????????????????????????,???????
 E:\PHPTutorial\WWW\dev\buyer\application\libraries\Redismanager.php 20
ERROR - 2019-03-22 08:38:03 --> Severity: error --> Exception: Redis server went away E:\PHPTutorial\WWW\dev\buyer\application\libraries\Redismanager.php 59
ERROR - 2019-03-22 08:48:18 --> 查找用户无session时间3.814697265625E-6
ERROR - 2019-03-22 08:50:37 --> 查找用户无session时间4.0531158447266E-6
ERROR - 2019-03-22 08:50:40 --> 查找用户信息时间0.039624929428101<br/>sql->SELECT *
FROM `user_members_copy1`
WHERE `user_name` = '18767193790'
AND `passwd` = 'aa28b675e5a446485cef83284e904376b3835bd6'
AND `user_type` = 1
 LIMIT 1
ERROR - 2019-03-22 08:50:40 --> 查找用户信息写入redis总时间0.040880918502808
ERROR - 2019-03-22 08:50:46 --> 查找用户信息时间0.037373065948486<br/>sql->SELECT *
FROM `user_members_copy1`
WHERE `user_name` = '18767193790'
AND `passwd` = '7c4a8d09ca3762af61e59520943dc26494f8941b'
AND `user_type` = 1
 LIMIT 1
ERROR - 2019-03-22 08:50:46 --> 更新用户login_cnt时间0.034650087356567<br/>sql->UPDATE `user_members_copy1` SET `login_cnt` = 379
WHERE `id` = '12414'
ERROR - 2019-03-22 08:50:48 --> Severity: Warning --> Redis::connect(): connect() failed: ???????????????????????????,???????
 E:\PHPTutorial\WWW\dev\buyer\application\libraries\Redismanager.php 20
ERROR - 2019-03-22 08:50:48 --> Severity: error --> Exception: Redis server went away E:\PHPTutorial\WWW\dev\buyer\application\libraries\Redismanager.php 59
ERROR - 2019-03-22 09:21:15 --> 查找用户无session时间5.0067901611328E-6
ERROR - 2019-03-22 09:21:16 --> 查找用户信息时间0.038532018661499<br/>sql->SELECT *
FROM `user_members_copy1`
WHERE `user_name` = '18767193790'
AND `passwd` = 'aa28b675e5a446485cef83284e904376b3835bd6'
AND `user_type` = 1
 LIMIT 1
ERROR - 2019-03-22 09:21:16 --> 查找用户信息写入redis总时间0.03978705406189
ERROR - 2019-03-22 09:21:23 --> 查找用户信息时间0.038887977600098<br/>sql->SELECT *
FROM `user_members_copy1`
WHERE `user_name` = '18767193790'
AND `passwd` = '7c4a8d09ca3762af61e59520943dc26494f8941b'
AND `user_type` = 1
 LIMIT 1
ERROR - 2019-03-22 09:21:23 --> 更新用户login_cnt时间0.036329030990601<br/>sql->UPDATE `user_members_copy1` SET `login_cnt` = 380
WHERE `id` = '12414'
ERROR - 2019-03-22 09:21:23 --> 用户信息写入redis时间0.0018048286437988
ERROR - 2019-03-22 09:21:23 --> 查找用户信息写入redis总时间0.079143047332764
ERROR - 2019-03-22 09:21:23 --> 用户信息写入session时间1.0967254638672E-5
ERROR - 2019-03-22 09:21:23 --> 查找用户session登陆验证时间4.0531158447266E-6
ERROR - 2019-03-22 09:21:23 --> 查找用户消息时间0.16680693626404<br/>sql->SELECT *
FROM `user_messages_copy1`
WHERE `member_id` IN(0, '12414')
AND `read_status` =0
ORDER BY `read_status` ASC, `id` ASC
ERROR - 2019-03-22 09:21:23 --> 查找用户消息总的时间0.16735196113586
ERROR - 2019-03-22 09:21:24 --> 公告时间0.036590814590454<br/>sql->SELECT `title`, `id`
FROM `platform_notice_copy1`
WHERE `notice_type` IN(1, 2)
AND `expire_time` >= '2019-03-22 09:21:24'
ORDER BY `is_top` DESC, `sort` DESC, `id` DESC
 LIMIT 1
ERROR - 2019-03-22 09:21:24 --> 查用户session status时间5.0067901611328E-6
ERROR - 2019-03-22 09:21:24 --> 查找用户绑定信息0.085888862609863<br/>sql->SELECT *
FROM `user_bind_info_copy1`
WHERE `user_id` = '12414'
AND `status` = 1
 LIMIT 1
ERROR - 2019-03-22 09:22:01 --> 查找用户无session时间3.0994415283203E-6
ERROR - 2019-03-22 09:22:15 --> 查找用户信息时间0.036602020263672<br/>sql->SELECT *
FROM `user_members_copy1`
WHERE `user_name` = '18767193790'
AND `passwd` = 'aa28b675e5a446485cef83284e904376b3835bd6'
AND `user_type` = 1
 LIMIT 1
ERROR - 2019-03-22 09:22:15 --> 查找用户信息写入redis总时间0.03787899017334
ERROR - 2019-03-22 09:22:21 --> 查找用户信息时间0.03631591796875<br/>sql->SELECT *
FROM `user_members_copy1`
WHERE `user_name` = '18767193790'
AND `passwd` = '7c4a8d09ca3762af61e59520943dc26494f8941b'
AND `user_type` = 1
 LIMIT 1
ERROR - 2019-03-22 09:22:21 --> 更新用户login_cnt时间0.033679008483887<br/>sql->UPDATE `user_members_copy1` SET `login_cnt` = 381
WHERE `id` = '12414'
ERROR - 2019-03-22 09:22:21 --> 用户信息写入redis时间0.0010011196136475
ERROR - 2019-03-22 09:22:21 --> 查找用户信息写入redis总时间0.078825950622559
ERROR - 2019-03-22 09:22:21 --> 用户信息写入session时间7.1525573730469E-6
ERROR - 2019-03-22 09:22:21 --> 查找用户session登陆验证时间5.0067901611328E-6
ERROR - 2019-03-22 09:22:22 --> 查找用户消息时间0.1675488948822<br/>sql->SELECT *
FROM `user_messages_copy1`
WHERE `member_id` IN(0, '12414')
AND `read_status` =0
ORDER BY `read_status` ASC, `id` ASC
ERROR - 2019-03-22 09:22:22 --> 查找用户消息总的时间0.16806888580322
ERROR - 2019-03-22 09:22:22 --> 公告时间0.036600112915039<br/>sql->SELECT `title`, `id`
FROM `platform_notice_copy1`
WHERE `notice_type` IN(1, 2)
AND `expire_time` >= '2019-03-22 09:22:22'
ORDER BY `is_top` DESC, `sort` DESC, `id` DESC
 LIMIT 1
ERROR - 2019-03-22 09:22:22 --> 查用户session status时间5.0067901611328E-6
ERROR - 2019-03-22 09:22:22 --> 查找用户绑定信息0.086517095565796<br/>sql->SELECT *
FROM `user_bind_info_copy1`
WHERE `user_id` = '12414'
AND `status` = 1
 LIMIT 1
ERROR - 2019-03-22 10:00:18 --> Severity: Warning --> Redis::connect(): connect() failed: ???????????,?????
 E:\PHPTutorial\WWW\dev\buyer\system\libraries\Session\drivers\Session_redis_driver.php 138
ERROR - 2019-03-22 10:00:18 --> Session: Unable to connect to Redis with the configured settings.
ERROR - 2019-03-22 10:00:18 --> Severity: Error --> session_start(): Failed to initialize storage module: user (path: wawa.com:6379) E:\PHPTutorial\WWW\dev\buyer\system\libraries\Session\Session.php 143
