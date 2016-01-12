<?php

/**
 * @file
 * Test configuration in settings.php.
 */

namespace Drupal;

use PHPUnit_Framework_TestCase;

class MultisiteTest extends PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->projectRoot = dirname(dirname(__DIR__));
        $this->drupalRoot = $this->projectRoot . '/docroot';
        $_ENV['AH_SITE_NAME'] = $_ENV['AH_SITE_GROUP'] = 'tatelyle';
        $_SERVER['REMOTE_ADDR'] = '127.0.0.1';
        if (!defined('DRUPAL_ROOT')) {
            define('DRUPAL_ROOT', $this->drupalRoot);
        }
        $this->sites = [
          'avenacare',
          'clariastarch',
          'proatein',
          'tateandlyleventures',
        ];
    }
    /**
     * Sets up require parameters for tests to run.
     *
     * @param string $env
     *   The acquia environment being simulated. E.g., prod, test, dev, etc.
     */
    public function setupParams($env)
    {

        $_ENV['AH_SITE_ENVIRONMENT'] = $env;
        $this->url_pattern = '.' . $env . '.cloud.tateandlyle.com';
    }

    /**
     * Test configuration for production environment on ACE.
     */
    public function testProd()
    {
        $this->setupParams('prod');
        require $this->drupalRoot . '/sites/sites.php';

        foreach ($this->sites as $site_name) {
            $internal_domain = $site_name . $this->url_pattern;
            $this->assertArrayHasKey($internal_domain, $sites);
        }
    }

  /**
   * Test configuration for test/stg environment on ACE.
   */
    public function testTest()
    {
        $this->setupParams('test');
        require $this->drupalRoot . '/sites/sites.php';

        foreach ($this->sites as $site_name) {
            $internal_domain = $site_name . $this->url_pattern;
            $this->assertArrayHasKey($internal_domain, $sites);
        }
    }

  /**
   * Test configuration for dev environment on ACE.
   */
    public function testDev()
    {
        $this->setupParams('dev');
        require $this->drupalRoot . '/sites/sites.php';

        foreach ($this->sites as $site_name) {
            $internal_domain = $site_name . $this->url_pattern;
            $this->assertArrayHasKey($internal_domain, $sites);
            $this->assertFileExists($this->drupalRoot . '/sites/' . $site_name);
        }
    }

    /**
     * Test if each sites folder has an entry in the sites.php.
     */
    public function testSites()
    {
        require $this->drupalRoot . '/sites/sites.php';
        // Test if each folder has an entry in the sites.php.
        $sites_folder = new \DirectoryIterator($this->drupalRoot . '/sites');

        $sites_name_list = array_flip(array_values($sites));
        foreach ($sites_folder as $folder) {
            if ($folder->isDir() && !$folder->isDot() && $folder->getFilename() != 'default') {
                $this->assertArrayHasKey(
                    $folder->getFileName(),
                    $sites_name_list,
                    'Settings folder does not have associated sites.php entry.'
                );
            }
        }

        // Test if each site entry has a folder.
        foreach ($sites as $domain => $site_name) {
            $this->assertFileExists(
                $this->drupalRoot . '/sites/' . $site_name,
                'Site defined in sites.php does not have a settings folder.'
            );
        }
    }
}
