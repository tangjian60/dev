#!/usr/bin/env bash
rm -rf /zcm/*.*
rm -rf /zcm/binary/*
rm -rf /zcm/fonts/*
svn export --username production --password qwer1234 --force --no-auth-cache svn://123.206.227.239/zcm/trunk/cdn /zcm/