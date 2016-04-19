#!/bin/bash

arguments=( "$@" )

env=${arguments[0]}
unset "arguments[0]"

dblist=`aht @tatelyle.$env dbs | awk 'NR >=3 {print l} {l=$1}'`;

for db in $dblist; do
    site=`echo $db | tr '_' '-' | tr -d '\n' | xargs`;
    # Convert underscores to dash (e.g. soda-lo).
    if [ $site == "" ]; then continue; fi;
    domain="$site.$env.cloud.tateandlyle.com";
    echo "Running drush $@ on $domain";
    aht @tatelyle.$env drush8 @tatelyle.$env -l $domain ${arguments[*]};
done
