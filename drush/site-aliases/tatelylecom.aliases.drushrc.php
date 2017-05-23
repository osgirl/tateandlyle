<?php

if (!isset($drush_major_version)) {
  $drush_version_components = explode('.', DRUSH_VERSION);
  $drush_major_version = $drush_version_components[0];
}
// Site tatelylecom, environment dev
$aliases['dev'] = array(
  'root' => '/var/www/html/tatelylecom.dev/docroot',
  'ac-site' => 'tatelylecom',
  'ac-env' => 'dev',
  'ac-realm' => 'prod',
  'uri' => 'tatelylecomdev.prod.acquia-sites.com',
  'remote-host' => 'staging-15867.prod.hosting.acquia.com',
  'remote-user' => 'tatelylecom.dev',
  'path-aliases' => array(
    '%drush-script' => 'drush' . $drush_major_version,
  )
);
$aliases['dev.livedev'] = array(
  'parent' => '@tatelylecom.dev',
  'root' => '/mnt/gfs/tatelylecom.dev/livedev/docroot',
);

if (!isset($drush_major_version)) {
  $drush_version_components = explode('.', DRUSH_VERSION);
  $drush_major_version = $drush_version_components[0];
}
// Site tatelylecom, environment prod
$aliases['prod'] = array(
  'root' => '/var/www/html/tatelylecom.prod/docroot',
  'ac-site' => 'tatelylecom',
  'ac-env' => 'prod',
  'ac-realm' => 'prod',
  'uri' => 'tatelylecom.prod.acquia-sites.com',
  'remote-host' => 'web-15863.prod.hosting.acquia.com',
  'remote-user' => 'tatelylecom.prod',
  'path-aliases' => array(
    '%drush-script' => 'drush' . $drush_major_version,
  )
);
$aliases['prod.livedev'] = array(
  'parent' => '@tatelylecom.prod',
  'root' => '/mnt/gfs/tatelylecom.prod/livedev/docroot',
);

if (!isset($drush_major_version)) {
  $drush_version_components = explode('.', DRUSH_VERSION);
  $drush_major_version = $drush_version_components[0];
}
// Site tatelylecom, environment ra
$aliases['ra'] = array(
  'root' => '/var/www/html/tatelylecom.ra/docroot',
  'ac-site' => 'tatelylecom',
  'ac-env' => 'ra',
  'ac-realm' => 'prod',
  'uri' => 'tatelylecomra.prod.acquia-sites.com',
  'remote-host' => 'staging-16241.prod.hosting.acquia.com',
  'remote-user' => 'tatelylecom.ra',
  'path-aliases' => array(
    '%drush-script' => 'drush' . $drush_major_version,
  )
);
$aliases['ra.livedev'] = array(
  'parent' => '@tatelylecom.ra',
  'root' => '/mnt/gfs/tatelylecom.ra/livedev/docroot',
);

if (!isset($drush_major_version)) {
  $drush_version_components = explode('.', DRUSH_VERSION);
  $drush_major_version = $drush_version_components[0];
}
// Site tatelylecom, environment test
$aliases['test'] = array(
  'root' => '/var/www/html/tatelylecom.test/docroot',
  'ac-site' => 'tatelylecom',
  'ac-env' => 'test',
  'ac-realm' => 'prod',
  'uri' => 'tatelylecomstg.prod.acquia-sites.com',
  'remote-host' => 'staging-15867.prod.hosting.acquia.com',
  'remote-user' => 'tatelylecom.test',
  'path-aliases' => array(
    '%drush-script' => 'drush' . $drush_major_version,
  )
);
$aliases['test.livedev'] = array(
  'parent' => '@tatelylecom.test',
  'root' => '/mnt/gfs/tatelylecom.test/livedev/docroot',
);
