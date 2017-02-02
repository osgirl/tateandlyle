<?php

namespace Drupal\tal_breadcrumbs;

use Drupal\Core\Breadcrumb\Breadcrumb;
use Drupal\Core\Breadcrumb\BreadcrumbBuilderInterface;
use Drupal\Core\Link;
use Drupal\Core\Routing\RequestContext;
use Drupal\Core\Routing\RouteMatchInterface;
use Drupal\Core\Url;
use Drupal\taxonomy\Entity\Term;

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
   * Constructs the PathBasedBreadcrumbBuilder.
   *
   * @param \Drupal\Core\Routing\RequestContext $context
   *   The router request context.
   */
  public function __construct(RequestContext $context) {
    $this->context = $context;
    // Just adding path of ingredient finder here fixes it's breadcrumb.
    $this->paths = [
      'search/ingredients',
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function build(RouteMatchInterface $route_match) {
    $title = \Drupal::service('title_resolver')->getTitle(\Drupal::request(), $route_match->getRouteObject());

    $breadcrumb = new Breadcrumb();
    $links = array();
    $path = trim($this->context->getPathInfo(), '/');

    // Always add home link.
    $links[] = Link::createFromRoute(t("Home"), '<front>');

    if (!empty($this->node)) {
      switch ($this->node->getType()) {
        case 'ingredient':
          // Add search query to ingredient finder link.
          $options = [
            'query' => [
              's' => $title,
            ],
          ];
          $links[] = Link::createFromRoute(t("Ingredient Finder"), 'tal_ingredient_search', $options);
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
          break;
      }
    }

    return $breadcrumb->setLinks($links);
  }

  /**
   * {@inheritdoc}
   */
  public function applies(RouteMatchInterface $route_match) {
    $applies = FALSE;
    $path = trim($this->context->getPathInfo(), '/');
    $parameters = $route_match->getParameters()->all();
    if (in_array($path, $this->paths)) {
      $applies = TRUE;
    }
    elseif (isset($parameters['node'])) {
      // @todo:: return applies for all node types in this loop.
      $types = [
        'ingredient',
        'company_story',
        'press_release',
      ];
      if (in_array($parameters['node']->getType(), $types)) {
        $this->node = $parameters['node'];
        $applies = TRUE;
      }
    }
    return $applies;
  }

}
