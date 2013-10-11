wget http://pecl.php.net/get/AOP-0.2.2b1.tgz
tar -xzf AOP-0.2.2b1.tgz
sh -c "cd AOP-0.2.2b1 && phpize && ./configure && make && sudo make install"
echo "extension=aop.so" >> `php --ini | grep "Loaded Configuration" | sed -e "s|.*:\s*||"`