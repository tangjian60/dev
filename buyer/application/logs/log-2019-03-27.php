<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2019-03-27 06:50:25 --> Severity: Warning --> Redis::connect(): connect() failed: ???????????,?????
 E:\PHPTutorial\WWW\dev\buyer\system\libraries\Session\drivers\Session_redis_driver.php 138
ERROR - 2019-03-27 06:50:25 --> Session: Unable to connect to Redis with the configured settings.
ERROR - 2019-03-27 06:50:25 --> Severity: Error --> session_start(): Failed to initialize storage module: user (path: wawa.com:6379) E:\PHPTutorial\WWW\dev\buyer\system\libraries\Session\Session.php 143
ERROR - 2019-03-27 06:56:41 --> Severity: Warning --> Redis::connect(): connect() failed: ???????????,?????
 E:\PHPTutorial\WWW\dev\buyer\system\libraries\Session\drivers\Session_redis_driver.php 138
ERROR - 2019-03-27 06:56:41 --> Session: Unable to connect to Redis with the configured settings.
ERROR - 2019-03-27 06:56:41 --> Severity: Error --> session_start(): Failed to initialize storage module: user (path: wawa.com:6379) E:\PHPTutorial\WWW\dev\buyer\system\libraries\Session\Session.php 143
ERROR - 2019-03-27 06:56:44 --> Severity: Warning --> Redis::connect(): connect() failed: ???????????,?????
 E:\PHPTutorial\WWW\dev\buyer\system\libraries\Session\drivers\Session_redis_driver.php 138
ERROR - 2019-03-27 06:56:44 --> Session: Unable to connect to Redis with the configured settings.
ERROR - 2019-03-27 06:56:44 --> Severity: Error --> session_start(): Failed to initialize storage module: user (path: wawa.com:6379) E:\PHPTutorial\WWW\dev\buyer\system\libraries\Session\Session.php 143
ERROR - 2019-03-27 06:57:15 --> Severity: Warning --> Redis::connect(): connect() failed: ???????????,?????
 E:\PHPTutorial\WWW\dev\buyer\system\libraries\Session\drivers\Session_redis_driver.php 138
ERROR - 2019-03-27 06:57:15 --> Session: Unable to connect to Redis with the configured settings.
ERROR - 2019-03-27 06:57:15 --> Severity: Error --> session_start(): Failed to initialize storage module: user (path: wawa.com:6379) E:\PHPTutorial\WWW\dev\buyer\system\libraries\Session\Session.php 143
ERROR - 2019-03-27 07:03:25 --> Severity: Warning --> Redis::connect(): connect() failed: ???????????,?????
 E:\PHPTutorial\WWW\dev\buyer\system\libraries\Session\drivers\Session_redis_driver.php 138
ERROR - 2019-03-27 07:03:25 --> Session: Unable to connect to Redis with the configured settings.
ERROR - 2019-03-27 07:03:25 --> Severity: Error --> session_start(): Failed to initialize storage module: user (path: wawa.com:6379) E:\PHPTutorial\WWW\dev\buyer\system\libraries\Session\Session.php 143
ERROR - 2019-03-27 07:03:53 --> 查找用户无session时间5.0067901611328E-6
ERROR - 2019-03-27 07:03:55 --> 查找用户信息时间0.036688089370728<br/>sql->SELECT *
FROM `user_members_copy1`
WHERE `user_name` = '18767193790'
AND `passwd` = 'aa28b675e5a446485cef83284e904376b3835bd6'
AND `user_type` = 1
 LIMIT 1
ERROR - 2019-03-27 07:03:55 --> 查找用户信息写入redis总时间0.038633823394775
ERROR - 2019-03-27 07:04:02 --> 查找用户信息时间0.035650014877319<br/>sql->SELECT *
FROM `user_members_copy1`
WHERE `user_name` = '18767193790'
AND `passwd` = '7c4a8d09ca3762af61e59520943dc26494f8941b'
AND `user_type` = 1
 LIMIT 1
ERROR - 2019-03-27 07:04:02 --> 更新用户login_cnt时间0.033965110778809<br/>sql->UPDATE `user_members_copy1` SET `login_cnt` = 382
WHERE `id` = '12414'
ERROR - 2019-03-27 07:04:02 --> 用户信息写入redis时间0.0018539428710938
ERROR - 2019-03-27 07:04:02 --> 查找用户信息写入redis总时间0.073702096939087
ERROR - 2019-03-27 07:04:02 --> 用户信息写入session时间3.6001205444336E-5
ERROR - 2019-03-27 07:04:03 --> 查找用户session登陆验证时间4.0531158447266E-6
ERROR - 2019-03-27 07:04:03 --> 查找用户消息时间0.16819906234741<br/>sql->SELECT *
FROM `user_messages_copy1`
WHERE `member_id` IN(0, '12414')
AND `read_status` =0
ORDER BY `read_status` ASC, `id` ASC
ERROR - 2019-03-27 07:04:03 --> 查找用户消息总的时间0.16875600814819
ERROR - 2019-03-27 07:04:03 --> 公告时间0.033598899841309<br/>sql->SELECT `title`, `id`
FROM `platform_notice_copy1`
WHERE `notice_type` IN(1, 2)
AND `expire_time` >= '2019-03-27 07:04:03'
ORDER BY `is_top` DESC, `sort` DESC, `id` DESC
 LIMIT 1
ERROR - 2019-03-27 07:04:03 --> 查用户session status时间5.9604644775391E-6
ERROR - 2019-03-27 07:04:03 --> 查找用户绑定信息0.083747863769531<br/>sql->SELECT *
FROM `user_bind_info_copy1`
WHERE `user_id` = '12414'
AND `status` = 1
 LIMIT 1
ERROR - 2019-03-27 07:15:44 --> 查找用户无session时间3.0994415283203E-6
ERROR - 2019-03-27 07:15:45 --> 查找用户信息时间0.037563800811768<br/>sql->SELECT *
FROM `user_members_copy1`
WHERE `user_name` = '18767193790'
AND `passwd` = 'aa28b675e5a446485cef83284e904376b3835bd6'
AND `user_type` = 1
 LIMIT 1
ERROR - 2019-03-27 07:15:45 --> 查找用户信息写入redis总时间0.038750886917114
ERROR - 2019-03-27 07:15:48 --> 查找用户无session时间4.0531158447266E-6
ERROR - 2019-03-27 07:15:54 --> 查找用户信息时间0.037187814712524<br/>sql->SELECT *
FROM `user_members_copy1`
WHERE `user_name` = '18767193790'
AND `passwd` = '7c4a8d09ca3762af61e59520943dc26494f8941b'
AND `user_type` = 1
 LIMIT 1
ERROR - 2019-03-27 07:15:54 --> 更新用户login_cnt时间0.034151077270508<br/>sql->UPDATE `user_members_copy1` SET `login_cnt` = 383
WHERE `id` = '12414'
ERROR - 2019-03-27 07:15:54 --> 用户信息写入redis时间0.0017600059509277
ERROR - 2019-03-27 07:15:54 --> 查找用户信息写入redis总时间0.075304985046387
ERROR - 2019-03-27 07:15:54 --> 用户信息写入session时间1.0967254638672E-5
ERROR - 2019-03-27 07:15:54 --> 查找用户session登陆验证时间6.1988830566406E-6
ERROR - 2019-03-27 07:15:54 --> 查找用户消息时间0.16222286224365<br/>sql->SELECT *
FROM `user_messages_copy1`
WHERE `member_id` IN(0, '12414')
AND `read_status` =0
ORDER BY `read_status` ASC, `id` ASC
ERROR - 2019-03-27 07:15:54 --> 查找用户消息总的时间0.16277694702148
ERROR - 2019-03-27 07:15:55 --> 公告时间0.035420894622803<br/>sql->SELECT `title`, `id`
FROM `platform_notice_copy1`
WHERE `notice_type` IN(1, 2)
AND `expire_time` >= '2019-03-27 07:15:55'
ORDER BY `is_top` DESC, `sort` DESC, `id` DESC
 LIMIT 1
ERROR - 2019-03-27 07:15:55 --> 查用户session status时间7.1525573730469E-6
ERROR - 2019-03-27 07:15:55 --> 查找用户绑定信息0.085620880126953<br/>sql->SELECT *
FROM `user_bind_info_copy1`
WHERE `user_id` = '12414'
AND `status` = 1
 LIMIT 1
ERROR - 2019-03-27 08:27:32 --> 查找用户无session时间3.0994415283203E-6
ERROR - 2019-03-27 08:27:34 --> 查找用户信息时间0.034337997436523<br/>sql->SELECT *
FROM `user_members_copy1`
WHERE `user_name` = '18767193790'
AND `passwd` = 'aa28b675e5a446485cef83284e904376b3835bd6'
AND `user_type` = 1
 LIMIT 1
ERROR - 2019-03-27 08:27:34 --> 查找用户信息写入redis总时间0.035588979721069
ERROR - 2019-03-27 08:27:40 --> 查找用户信息时间0.035623073577881<br/>sql->SELECT *
FROM `user_members_copy1`
WHERE `user_name` = '18767193790'
AND `passwd` = '7c4a8d09ca3762af61e59520943dc26494f8941b'
AND `user_type` = 1
 LIMIT 1
ERROR - 2019-03-27 08:27:40 --> 更新用户login_cnt时间0.032487154006958<br/>sql->UPDATE `user_members_copy1` SET `login_cnt` = 384
WHERE `id` = '12414'
ERROR - 2019-03-27 08:27:40 --> 用户信息写入redis时间0.0018060207366943
ERROR - 2019-03-27 08:27:40 --> 查找用户信息写入redis总时间0.072956085205078
ERROR - 2019-03-27 08:27:40 --> 用户信息写入session时间1.0967254638672E-5
ERROR - 2019-03-27 08:27:40 --> 查找用户session登陆验证时间5.0067901611328E-6
ERROR - 2019-03-27 08:27:41 --> 查找用户消息时间0.16774201393127<br/>sql->SELECT *
FROM `user_messages_copy1`
WHERE `member_id` IN(0, '12414')
AND `read_status` =0
ORDER BY `read_status` ASC, `id` ASC
ERROR - 2019-03-27 08:27:41 --> 查找用户消息总的时间0.16830205917358
ERROR - 2019-03-27 08:27:41 --> 公告时间0.036674022674561<br/>sql->SELECT `title`, `id`
FROM `platform_notice_copy1`
WHERE `notice_type` IN(1, 2)
AND `expire_time` >= '2019-03-27 08:27:41'
ORDER BY `is_top` DESC, `sort` DESC, `id` DESC
 LIMIT 1
ERROR - 2019-03-27 08:27:41 --> 查用户session status时间5.9604644775391E-6
ERROR - 2019-03-27 08:27:41 --> 查找用户绑定信息0.086388826370239<br/>sql->SELECT *
FROM `user_bind_info_copy1`
WHERE `user_id` = '12414'
AND `status` = 1
 LIMIT 1
