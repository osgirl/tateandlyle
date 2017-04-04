<?php

// Use the following alias as a guide for creating a local alias.

$aliases['tatelylecom.local'] = array(
  'uri' => 'tatelylecom.local',
  'root' => '/var/www/vm/tateandlyle/docroot',
  'path-aliases' => array(
    '%dump-dir' => '/tmp',
  ),
);

if ('vagrant' != $_SERVER['USER']) {
  $aliases['tatelylecom.local'] += array(
    // vagrant_hostname
    'remote-host' => 'tatelylecom.local',
    'remote-user' => 'vagrant',
    'ssh-options' => '-o PasswordAuthentication=no -i ' . drush_server_home() . '/.vagrant.d/insecure_private_key'
  );
}
