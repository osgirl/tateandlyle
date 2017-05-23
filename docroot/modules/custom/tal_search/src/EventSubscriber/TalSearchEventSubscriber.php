<?php

namespace Drupal\tal_search\EventSubscriber;

use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Drupal\search_api\Entity\Server;
use Drupal\Component\Utility\NestedArray;

/**
 * Class TalSearchEventSubscriber.
 *
 * @package Drupal\tal_search\EventSubscriber
 */
class TalSearchEventSubscriber implements EventSubscriberInterface {

  /**
   * {@inheritdoc}
   */
  public function checkSearchConfig(GetResponseEvent $event) {
    // Have we already done this check?
    $env = isset($_ENV['AH_SITE_ENVIRONMENT']) ? $_ENV['AH_SITE_ENVIRONMENT'] : 'local';
    $flag_var = 'search_configuration_check.' . $env;
    $last_check = \Drupal::config('tal_search.settings')->get($flag_var);

    // The interval time below allows to do temporary overrides on non prod
    // envs for dev/test purpose.
    if (
      isset($last_check)
      && ($env == 'prod' || REQUEST_TIME - $last_check < \Drupal::config('tal_search.settings')->get('search_configuration_check.interval'))
    ) {
      return;
    }

    \Drupal::configFactory()->getEditable('tal_search.settings')->set($flag_var, REQUEST_TIME)->save();

    // Check if Search API server configuration is inline with expectations.
    $servers = Server::loadMultiple();
    if (empty($servers)) {
      return;
    }

    $expected_conf = [];
    switch ($env) {
      case 'local':
        $expected_conf['connector'] = 'standard';
        $expected_conf['connector_config']['host'] = 'localhost';
        $expected_conf['connector_config']['port'] = '8983';
        $expected_conf['connector_config']['path'] = '/solr';
        $expected_conf['connector_config']['core'] = '';
        break;

      default:
        $subscription = \Drupal::config('acquia_connector.settings')->get('subscription_data');
        // TODO: any better option?
        $identifier = $subscription['heartbeat_data']['search_cores'][0]['core_id'];
        if ($env != 'prod') {
          $identifier .= '.' . $env . '.default';
        }

        $expected_conf['connector'] = 'solr_acquia_connector';
        $expected_conf['connector_config']['key'] = 'core';
        $expected_conf['connector_config']['host'] = acquia_search_get_search_host();
        // TODO: make this scheme dependent
        // cf. SearchApiSolrAcquiaConnector::connect().
        $expected_conf['connector_config']['port'] = '80';
        $expected_conf['connector_config']['path'] = '/solr';
        $expected_conf['connector_config']['core'] = $identifier;
        break;
    }

    foreach ($servers as $server) {
      if ($server->getBackendId() == 'search_api_solr') {
        if (
          !empty(@array_diff($expected_conf, $server->getBackendConfig()))
          || !empty(array_diff($expected_conf['connector_config'], $server->getBackendConfig()['connector_config']))
        ) {
          $new_conf = NestedArray::mergeDeep($server->getBackendConfig(), $expected_conf);
          $server->setBackendConfig($new_conf);
          $server->save();

          // We need to update Search API server configuration.
          drupal_set_message(t('Search API server had to be reconfigured. Please refresh the page.'), 'warning');
        }
      }
    }
  }

  /**
   * {@inheritdoc}
   */
  public static function getSubscribedEvents() {
    $events[KernelEvents::REQUEST][] = array('checkSearchConfig');
    return $events;
  }

}
