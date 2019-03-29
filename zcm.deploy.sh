# buyer
rm -rf /var/www/html/buyer/*
svn export --username production --password qwer1234 --force --no-auth-cache svn://123.206.227.239/zcm/trunk/buyer /var/www/html/buyer/

#seller
rm -rf /var/www/html/shang/*
svn export --username production --password qwer1234 --force --no-auth-cache svn://123.206.227.239/zcm/trunk/shang /var/www/html/shang/

#administration
rm -rf /var/www/html/guan/*
svn export --username production --password qwer1234 --force --no-auth-cache svn://123.206.227.239/zcm/trunk/guan /var/www/html/guan/