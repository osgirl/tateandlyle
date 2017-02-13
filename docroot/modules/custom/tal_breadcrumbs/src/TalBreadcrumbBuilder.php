<?php

namespace Drupal\tal_breadcrumbs;

use Drupal\Core\Breadcrumb\Breadcrumb;
use Drupal\Core\Breadcrumb\BreadcrumbBuilderInterface;
use Drupal\Core\Link;
use Drupal\Core\Routing\RequestContext;
use Drupal\Core\Routing\RouteMatchInterface;
use Drupal\Core\Url;
use Drupal\taxonomy\Entity\Term;
use Drupal\Core\Menu\MenuActiveTrailInterface;

/**
 * Adds the current page title to the breadcrumb.
 *
 * Extend PathBased Breadcrumbs to include the current page title as an unlinked
 * crumb. The module uses the path if the title is unavailable and it excludes
 * all admin paths.
 *
 * {@inheritdoc}
 */
/**
 * Class to define the menu_link breadcrumb builder.
 */
class TalBreadcrumbBuilder implements BreadcrumbBuilderInterface {

  /**
   * Paths for breadcrumb customisations.
   *
   * @var array
   */
  protected $paths;

  /**
   * Node of current page if on node page.
   *
   * @var \Drupal\node\Entity\Node
   */
  protected $node;

  /**
   * The router request context.
   *
   * @var \Drupal\Core\Routing\RequestContext
   */
  protected $context;

  /**
   * The menu active trail interface.
   *
   * @var \Drupal\Core\Menu\MenuActiveTrailInterface
   */
  protected $menuActiveTrail;

  /**
   * Constructs the PathBasedBreadcrumbBuilder.
   *
   * @param \Drupal\Core\Routing\RequestContext $context
   *   The router request context.
   * @param \Drupal\Core\Menu\MenuActiveTrailInterface $menu_active_trail
   *   The menu active trail object.
   */
  public function __construct(RequestContext $context, MenuActiveTrailInterface $menu_active_trail) {
    $this->context = $context;
    // Just adding path of ingredient finder here fixes it's breadcrumb.
    $this->paths = [
      'search/ingredients',
      'search',
    ];
    $this->menuActiveTrail = $menu_active_trail;
  }

  /**
   * {@inheritdoc}
   */
  public function build(RouteMatchInterface $route_match) {
    $title = \Drupal::service('title_resolver')->getTitle(\Drupal::request(), $route_match->getRouteObject());
    $breadcrumb = new Breadcrumb();

    // Set default cacheble dependency.
    $node_object = $route_match->getParameters()->get('node');
    $breadcrumb->addCacheableDependency($node_object);

    $links = array();

    if (!empty($this->node)) {
      switch ($this->node->getType()) {
        case 'ingredient':
          // Add search query to ingredient finder link.
          $links[] = Link::createFromRoute(t("Ingredient Finder"), 'tal_ingredient_search', ['s' => $title]);
          break;

        case 'company_story':
          // Company story uses same fields as press_release so the code will be
          // same for both.
        case 'press_release':
          // Get article category details.
          $value = $this->node->get('field_category')->getValue();
          $tid = array_shift($value)['target_id'];
          // Load term, tid won't be empty since category is mandatory.
          $term = Term::load($tid);
          $url = Url::fromUserInput('/articles/' . $tid);
          $links[] = Link::fromTextAndUrl($term->getName(), $url);
          $breadcrumb->addCacheableDependency($term);
          break;

        case 'landing_page':
          $breadcrumb = $this->generateLandingPageBreadcrumb($breadcrumb);
          break;
      }
    }
    else {
      $path = trim($this->context->getPathInfo(), '/');
      switch ($path) {
        case 'search/ingredients':
          $links[] = Link::createFromRoute(t("Ingredient"), 'tal_ingredient_search');
          break;

        case 'search':
          $url = Url::fromUserInput('/search');
          $links[] = Link::fromTextAndUrl(t("Search"), $url);
          break;

      }

    }
    if (!empty($links)) {
      $breadcrumb->setLinks($links);
    }

    return $breadcrumb;
  }

  /**
   * {@inheritdoc}
   */
  public function applies(RouteMatchInterface $route_match) {
    $applies = FALSE;
    $path = trim($this->context->getPathInfo(), '/');
    $node_object = $route_match->getParameters()->get('node');

    if (in_array($path, $this->paths)) {
      $applies = TRUE;
    }
    elseif ($node_object) {
      // @todo:: return applies for all node types in this loop.
      $types = [
        'ingredient',
        'company_story',
        'press_release',
        'landing_page',
      ];
      if (in_array($node_object->getType(), $types)) {
        $this->node = $node_object;
        $applies = TRUE;
      }
    }
    return $applies;
  }

  /**
   * Generate breadcrumb of landing page contents based on the conditions.
   */
  private function generateLandingPageBreadcrumb(Breadcrumb $breadcrumb) {
    // Get the menu link trail of the current node.
    $menu_link_manager = \Drupal::service('plugin.manager.menu.link');
    $links = [];
    $result = $menu_link_manager->loadLinksByRoute('entity.node.canonical', array('node' => $this->node->id()));

    foreach ($result as $menu_link) {
      // Get active trail of the node menu.
      $trail_ids = $this->menuActiveTrail->getActiveTrailIds($menu_link->getMenuName());
      $trail_ids = array_filter($trail_ids);
      // We don't need last menu item, instead we show node title.
      array_shift($trail_ids);
      // Generate basic breadcrumb trail from active trail.
      // Keep same link ordering as Menu Breadcrumb.
      foreach (array_reverse($trail_ids) as $id) {
        $plugin = $menu_link_manager->createInstance($id);
        $breadcrumb->addCacheableDependency($plugin);
        $links[] = Link::fromTextAndUrl($plugin->getTitle(), $plugin->getUrlObject());
      }
      $breadcrumb->addCacheableDependency($menu_link);
    }
    $breadcrumb->addCacheTags(['config:system.menu.main-menu']);
    $breadcrumb->setLinks($links);

    return $breadcrumb;
  }

}
