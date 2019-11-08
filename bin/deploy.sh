#!/bin/bash

if [ ! -f .env.local ]; then
  exit 0;
fi 

DEPLOY_TO=`grep DEPLOY_HOST .env.local | cut -d'=' -f2`
DEPLOY_HOST=`echo $DEPLOY_TO | cut -d':' -f1`

cd ..
rm -rf workorder/var/cache/*

# FULL COPY
#rsync -a --delete workorder root@$DEPLOY_TO

# CODE UPGRADE
rsync -a --delete --exclude var/data.db --exclude public/local workorder root@$DEPLOY_TO
if [ x$1 = "xGET" ]; then
  rsync -a root@${DEPLOY_TO}/workorder/var/data.db workorder/var
  rsync -a root@${DEPLOY_TO}/workorder/public/local workorder/public
fi

ssh root@$DEPLOY_HOST "echo 'APP_ENV=prod' >> /var/www/html/workorder/.env.local"
ssh root@$DEPLOY_HOST "chown -R apache:apache /var/www/html/workorder"


cd workorder

