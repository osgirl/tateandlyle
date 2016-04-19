#!/bin/bash



sites=( avenacare clariastarch dolciaprima feedthembetter foodnutritionknowledge industrialstarches proatein purefruit soda-lo sucralose tastevasweetener tateandlylecn tateandlylefibres tateandlylejp tateandlyleopeninnovation tateandlyleprocurement tateandlyleventures yourbakerysnacksolutions yourdrinksolutions yourfoodsystems )

env="dev"

for site in "${sites[@]}"
do
  domain="$site.$env.cloud.tateandlyle.com"
  aht @tatelyle.$env drush8 @tatelyle.$env cr -l $domain
done
