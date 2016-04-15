<?php

/**
 * @file
 * Configuration file for multi-site support and directory aliasing feature.
 *
 * This file is required for multi-site support and also allows you to define a
 * set of aliases that map hostnames, ports, and pathnames to configuration
 * directories in the sites directory. These aliases are loaded prior to
 * scanning for directories, and they are exempt from the normal discovery
 * rules. See default.settings.php to view how Drupal discovers the
 * configuration directory when no alias is found.
 *
 * Aliases are useful on development servers, where the domain name may not be
 * the same as the domain of the live server. Since Drupal stores file paths in
 * the database (files, system table, etc.) this will ensure the paths are
 * correct when the site is deployed to a live server.
 *
 * To activate this feature, copy and rename it such that its path plus
 * filename is 'sites/sites.php'.
 *
 * Aliases are defined in an associative array named $sites. The array is
 * written in the format: '<port>.<domain>.<path>' => 'directory'. As an
 * example, to map https://www.drupal.org:8080/mysite/test to the configuration
 * directory sites/example.com, the array should be defined as:
 * @code
 * $sites = array(
 *   '8080.www.drupal.org.mysite.test' => 'example.com',
 * );
 * @endcode
 * The URL, https://www.drupal.org:8080/mysite/test/, could be a symbolic link
 * or an Apache Alias directive that points to the Drupal root containing
 * index.php. An alias could also be created for a subdomain. See the
 * @link https://www.drupal.org/documentation/install online Drupal installation
 * guide @endlink
 * for more information on setting up domains, subdomains, and subdirectories.
 *
 * The following examples look for a site configuration in sites/example.com:
 * @code
 * URL: http://dev.drupal.org
 * $sites['dev.drupal.org'] = 'example.com';
 *
 * URL: http://localhost/example
 * $sites['localhost.example'] = 'example.com';
 *
 * URL: http://localhost:8080/example
 * $sites['8080.localhost.example'] = 'example.com';
 *
 * URL: https://www.drupal.org:8080/mysite/test/
 * $sites['8080.www.drupal.org.mysite.test'] = 'example.com';
 * @endcode
 *
 * @see default.settings.php
 * @see \Drupal\Core\DrupalKernel::getSitePath()
 * @see https://www.drupal.org/documentation/install/multi-site
 */

$wildcard_domain = 'cloud.tateandlyle.com';
$envs = ['local', 'ra', 'dev', 'test', 'prod'];

$microsites = [
  'nabu',
  'avenacare',
  'proatein',
  'clariastarch',
  'tateandlyleventures',
  'industrialstarches',
  'purefruit',
  'tateandlyleopeninnovation',
  'dolciaprima',
  'yourbakerysnacksolutions',
  'foodnutritionknowledge',
  'tastevasweetener',
  'tateandlyleprocurement',
  'yourfoodsystems',
  'tateandlylefibres',
  'tateandlylejp',
  'sucralose',
  'feedthembetter',
  'tateandlylecn',
  'yourdrinksolutions',
];

$tld_list = [
  'org',
  'info',
  'cn',
  'jp',
  'com',
];

$sites = [];
foreach ($envs as $env) {
  foreach ($microsites as $site_name) {
    $full_domain = $site_name . '.' . $env . '.' . $wildcard_domain;
    $sites[$full_domain] = $site_name;

    // Make sure we detect the right site when we are not using the wildcard domain.
    foreach ($tld_list as $tld) {
      $sites[$site_name . '.' . $tld] = $site_name;
    }
  }
}

// The domain pattern for "soda-lo" is different from the database name.
// We use soda_lo internally, and here we map it to the soda-lo namespace.
// Note: soda-lo is *only* used in the domain.
foreach ($envs as $env) {
  $full_domain = 'soda-lo' . '.' . $env . '.' . $wildcard_domain;
  $sites[$full_domain] = 'soda_lo';
  $sites['soda-lo.com'] = 'soda_lo';
}
