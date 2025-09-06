if [ `getconf LONG_BIT` -ne "32" ]; 
then
      installpack="apache2 php5 mysql-server php5-mysql php5-gd libssh2-php openssh-server python3 screen wget unzip mc phpmyadmin libc6:i386 lib32stdc++6 proftpd"
else
     installpack="apache2 php5 mysql-server php5-mysql php5-gd libssh2-php openssh-server python3 screen wget unzip mc phpmyadmin proftpd"
fi
dpkg --add-architecture i386
apt-get update
export DEBIAN_FRONTEND=noninteractive;apt-get --allow-unauthenticated -y -q install $installpack
#wget http://q925735u.beget.tech/files/litepanel.zip
#wget http://q925735u.beget.tech/files/cp.zip


unzip web.zip -d /var/www/
unzip svr.zip -d /home/
rm web.zip
rm svr.zip
chmod 700 /home/cp
chmod 700 /home/cp/gameservers.py
groupadd gameservers
ln -s /usr/share/phpmyadmin /var/www/html/phpmyadmin


dlinapass=10
dbname='panel'
rootmysqlpass=`base64 -w $dlinapass /dev/urandom | head -n 1`
mysqladmin -uroot password $rootmysqlpass
echo "create database $dbname" | mysql -uroot -p$rootmysqlpass
mysql $dbname -uroot -p$rootmysqlpass < /var/www/dump.sql

a2enmod rewrite
#sed -i 's/AllowOverride None/AllowOverride All/g' /etc/apache2/sites-enabled/000-default
service apache2 restart

for i in `seq 1 100`;
do
   echo 
done
rm /var/www/html/index.html

#echo "INSERT INTO `game`.`users` (`user_id`, `user_email`, `user_password`, `user_firstname`, `user_lastname`, `user_status`, `user_balance`, `user_access_level`, `user_date_reg`) VALUES (NULL, 'adm@examle.com', 'e10adc3949ba59abbe56e057f20f883e', 'Администратор', 'Администратор', '1', '5000.00', '3', '2014-02-19 00:00:00');" | mysql -uroot -p$rootmysqlpass



#sed -i 's/username/root/g' /var/www/application/config.php
#sed -i 's/database/game/g' /var/www/application/config.php
#sed -i "s/password/${rootmysqlpass}/g" /var/www/application/config.php
IP=`ifconfig eth0 | grep "inet addr" | head -n 1 | cut -d : -f 2 | cut -d " " -f 1`
#sed -i "s/url//${IP}/g" /var/www/application/config.php
#chmod -R 777 /var/www/*

echo "Установка игрового хостинга пройдена успешно!
--------------------------------------------------
Данные для входа в панель:
URL: http://$IP/
--------------------------------------------------
--------------------------------------------------
Данные от Phpmyadmin:
Адрес: http://$IP/phpmyadmin/
Пользователь: root
Пароль: $rootmysqlpass
База: $dbname
--------------------------------------------------"