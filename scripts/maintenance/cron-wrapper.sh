#!/usr/bin/env bash
export PATH="$PATH:/usr/local/bin"
export PHPRC="/var/www/site-php/${1}/php.ini"
LOG=/var/log/sites/${AH_SITE_NAME}/logs/$(hostname -s)/drush-cron.log

if [ -n "${2}" ]; then
URI=${2}
else
URI=${1}.prod.acquia-sites.com
fi

echo -e "*\n**\n***\nCron Started: $(date)\n***\n**\n*" >> ${LOG}
drush @${1} -dv -l $URI cron &>> $LOG
echo -e "*\n**\n***\nCron Completed: $(date)\n***\n**\n*\n" >> ${LOG}
