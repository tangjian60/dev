#!/usr/bin/env bash
date +%F" "%H:%M:%S >> /var/log/quartz/quartz.log
curl "http://127.0.0.1/guan/quartz" >> /var/log/quartz/quartz.log
echo " " >> /var/log/quartz/quartz.log