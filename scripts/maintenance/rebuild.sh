#!/bin/bash



sites=( avenacare clariastarch dolciaprima feedthembetter foodnutritionknowledge industrialstarches proatein purefruit soda_lo sucralose tastevasweetener tateandlylefibres tateandlylejp tateandlyleopeninnovation tateandlyleprocurement tateandlyleventures tatelyle yourbakerysnacksolutions yourfoodsystems )

for site in "${sites[@]}"
do
  domain="$site.test.cloud.tateandlyle.com"
  aht @tatelyle.test drush8 @tatelyle.test cr -l $domain
done
