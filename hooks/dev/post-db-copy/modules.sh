#!/usr/bin/env bash
# Cloud Hook: modules
#
# Enable/disable modules according to the environment.
# Disable configuration enforcing SSO authentication and enables local authentication (required during QA).

site="$1"
target_env="$2"
db_name="$3"
source_env="$4"

domain_prefix=`echo $db_name | tr '_' '-'`

site_name=$site.$target_env
uri="${domain_prefix}.${target_env}.cloud.tateandlyle.com"

multisite="--uri=${uri} --root=/var/www/html/${site_name}/docroot"

echo "$site.$target_env: Received copy of database $db_name from $source_env."
echo "Running drush on $uri."

# Download drush 8
if [ ! -f ~/drush.phar ]; then
  wget http://files.drush.org/drush.phar
fi

alias drush="php ~/drush.phar"

# Disable production only modules and configuration.
drush pm-uninstall --yes tl_authentication_prod $multisite
drush pm-uninstall --yes tl_prod_login $multisite

# Enable the staging configuration and modules.
#drush8 pm-enable --yes token_login $multisite
drush pm-enable --yes tl_authentication_stage $multisite

# Make sure that the staging configuration does apply.
drush fr --yes tl_authentication_stage $multisite

# Make sure that all features are reverted
drush fr --yes tl_content $multisite
drush fr --yes tatelyle_search $multisite

# Temporary change to help QA - ensure that the password for the service account is fixed.
drush user-password svcCMSDrupal@tateandlyle.com --password="D9KUwqiQhswN4" $multisite

drush updatedb --yes $multisite
