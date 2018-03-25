#!/usr/bin/env bash

DEV_DIR="/home/usracct/StatsInfo/devdata.sh"
PROD_DIR="/home/usracct/StatsInfo/proddata.sh"

source $DEV_DIR
source $PROD_DIR

echo "Compare the schemas to see what it is different"

SERVER1=$dev_databaseuser:$dev_databasepassword@$dev_databaseserver:$dev_databaseport
SERVER2=$prod_databaseuser:$prod_databasepassword@$prod_databaseserver:$prod_databaseport

#mysqldump $dev_databasename $dev_databaseserver:$dev_databaseport $dev_databaseuser $dev_databasepassword
mysqldbcompare --run-all-tests --skip-data-check  --server1=$SERVER1 --server2=$SERVER2 --ssl=1 $dev_databasename:$prod_databasename
