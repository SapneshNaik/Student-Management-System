sudo su
yum update -y

yum install httpd24 -y
yum install php73 php73-mysqlnd php73-imap php73-pecl-memcache php73-pecl-apcu php73-gd php73-mbstring -y
yum install mod24_ssl -y

service httpd start