<?php
/**
 * @file
 * Environment related configuration.
 */

/**
 * Host detection.
 */
if (!empty($_SERVER['HTTP_X_FORWARDED_HOST'])) {
  $forwarded_host = $_SERVER['HTTP_X_FORWARDED_HOST'];
}
elseif (!empty($_SERVER['HTTP_HOST'])) {
  $forwarded_host = $_SERVER['HTTP_HOST'];
}
else {
  $forwarded_host = NULL;
}

$server_protocol = empty($_SERVER['HTTPS']) ? 'http' : 'https';
$forwarded_protocol = !empty($_ENV['HTTP_X_FORWARDED_PROTO']) ? $_ENV['HTTP_X_FORWARDED_PROTO'] : $server_protocol;

/**
 * Environment detection.
 *
 * Note that the values of enviromental variables are set differently on Acquia
 * Cloud Free tier vs Acquia Cloud Professional and Enterprise.
 */
$ah_env = isset($_ENV['AH_SITE_ENVIRONMENT']) ? $_ENV['AH_SITE_ENVIRONMENT'] : NULL;
$is_ah_env = (bool) $ah_env;
$is_ah_prod_env = ($ah_env == 'prod');
$is_ah_stage_env = ($ah_env == 'test');
$is_ah_free_tier = (!empty($_ENV['ACQUIA_HOSTING_DRUPAL_LOG']) && strstr($_ENV['ACQUIA_HOSTING_DRUPAL_LOG'], 'free'));
$is_ah_dev_env = (preg_match('/^dev[0-9]*$/', $ah_env) == TRUE);
$is_local_env = !$is_ah_env;

global $config;
// Ensure that on AC caching is enabled when running on the production environment.
if ($is_ah_env) {

  if ($is_ah_prod_env) {

    $config['system.performance']['cache']['page']['max_age'] = 1800;

    $config['system.performance']['css']['preprocess'] = TRUE;
    $config['system.performance']['css']['gzip'] = TRUE;

    $config['system.performance']['js']['preprocess'] = TRUE;
    $config['system.performance']['js']['gzip'] = TRUE;
  }
}
// Disable caching on local setup to assist development.
else {
  $config['system.performance']['css']['preprocess'] = FALSE;
  $config['system.performance']['css']['gzip'] = FALSE;

  $config['system.performance']['js']['preprocess'] = FALSE;
  $config['system.performance']['js']['gzip'] = FALSE;
}

$settings['simplesamlphp_dir'] = DRUPAL_ROOT . '/../simplesamlphp';
$settings['cache']['default'] = 'cache.backend.database';

// TL-182/Pentest M2/ARID-667 - Setting the cookie lifetime to 20 minutes.
// Ensure that the services.yml in the sites/default directory will be included.
// The __DIR__ . '/../' path should point to sites/default, while this
// file is located in sites/default/settings, thus the ../
$settings['container_yamls'][] = __DIR__ . '/../services.yml';
