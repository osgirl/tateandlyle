#!/bin/bash

env="dev"

dblist=`aht @tatelyle.dev dbs | awk 'NR >=3 {print l} {l=$1}'`;

for db in $dblist; do
    site=`echo $db | tr -d '\n' | xargs`;
    if [ $site == "" ]; then continue; fi;
    domain="$site.$env.cloud.tateandlyle.com";
    aht @tatelyle.$env drush8 @tatelyle.$env -l $domain $@;
done
