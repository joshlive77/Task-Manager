#!/usr/include/bash/

cd /c/wamp64/bin/mysql/mysql5.7.24/bin;
echo usuario:
read usr;
./mysql.exe -h localhost -u ${usr} -p;