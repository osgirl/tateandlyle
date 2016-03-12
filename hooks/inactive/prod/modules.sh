#!/usr/bin/env bash
# Cloud Hook: modules
#
# Enable/disable modules according to the environment.
# Enables the simplesamlphp_auth module and the custom module which overrides the login page.

site="$1"
target_env="$2"
db_name="$3"
source_env="$4"

domain_prefix=`echo $db_name | tr '_' '-'`

# Disable dev/stage configuration and modules.
drush8 @$site.$target_env pm-uninstall token_login --yes -l $domain_prefix.$target_env.tateandlyle.cloud.com
drush8 @$site.$target_env pm-uninstall tl_authentication_stage --yes -l $domain_prefix.$target_env.tateandlyle.cloud.com

# Enable production configuration and modules.
drush8 @$site.$target_env pm-enable tl_prod_login --yes -l $domain_prefix.$target_env.tateandlyle.cloud.com
drush8 @$site.$target_env pm-enable tl_authentication_prod --yes -l $domain_prefix.$target_env.tateandlyle.cloud.com

# Ensure that the production login configuration is active.
drush8 @$site.$target_env fr tl_authentication_prod --yes -l $domain_prefix.$target_env.tateandlyle.cloud.com
