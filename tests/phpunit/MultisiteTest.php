<?php

/**
 * @file
 * Test configuration in settings.php.
 */

namespace Drupal;

use PHPUnit_Framework_TestCase;

class MultisiteTest extends PHPUnit_Framework_TestCase
{
    /**
     * Sets up require parameters for tests to run.
     *
     * @param string $env
     *   The acquia environment being simulated. E.g., prod, test, dev, etc.
     */
    public function setupParams($env)
    {
        $this->projectRoot = dirname(dirname(__DIR__));
        $this->drupalRoot = $this->projectRoot . '/docroot';
        $_ENV['AH_SITE_ENVIRONMENT'] = $env;
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
        }
    }
}
