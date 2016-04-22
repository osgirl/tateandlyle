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
uri="${domain_refix}.${target_env}.cloud.tateandlyle.com"

multisite="--uri=${uri} --root=/var/www/html/${site_name}/docroot"

echo "$site.$target_env: Received copy of database $db_name from $source_env."
echo "Running drush on $uri."

# Disable production only modules and configuration.
drush8 pm-uninstall --yes tl_authentication_prod $multisite
drush8 pm-uninstall --yes tl_prod_login $multisite

# Enable the staging configuration and modules.
#drush8 pm-enable --yes token_login $multisite
drush8 pm-enable --yes tl_authentication_stage $multisite

# Make sure that the staging configuration does apply.
drush8 fr --yes tl_authentication_stage $multisite

# Temporary change to help QA - ensure that the password for the service account is fixed.
drush8 user-password svcCMSDrupal@tateandlyle.com --password="D9KUwqiQhswN4" $multisite

drush8 updatedb --yes $multisite
