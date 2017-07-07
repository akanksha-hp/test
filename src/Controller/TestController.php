<?php

namespace Drupal\test\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Drupal\node\Entity\Node;

/**
 * Controller for test module.
 */
class TestController extends ControllerBase {
  /**
   * Function to return JSON response.
   */
  public function get_page(Request $request, $apikey, $nid) {
    $siteapikey = \Drupal::config('test.settings')->get('siteapikey');
    $node = Node::load($nid);
    //Check if node exists.
    if ($node != '') {
      $node_type = $node->type->entity->label();
    }
    //Check whether provided api key is correct and the content typeof the accessed node is basic page.
    if ($apikey == $siteapikey && $node_type == 'Basic page') {
      $node = $node->toArray();
      return new JsonResponse($node); //return node as json response
    }
    else {
      return new JsonResponse("Access Denied");
    }
  }

}
