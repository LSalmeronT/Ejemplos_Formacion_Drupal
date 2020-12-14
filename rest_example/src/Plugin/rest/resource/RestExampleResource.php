<?php

namespace Drupal\rest_example\Plugin\rest\resource;

use Drupal\Core\Database\Database;
use Drupal\rest\Plugin\ResourceBase;
use Drupal\rest\ResourceResponse;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Provides a resource for database watchdog log entries.
 *
 * @RestResource(
 *   id = "rest_example",
 *   label = @Translation("REST Email example"),
 *   uri_paths = {
 *     "canonical" = "/restemail/{email}"
 *   }
 * )
 */
class RestExampleResource extends ResourceBase {

 /**
   * Responds to GET requests.
   *
   * @param int $id
   *   The email to search
   *
   * @return \Drupal\rest\ResourceResponse
   *   The response containing the log entry.
   *
   * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
   *   Thrown when the log entry was not found.
   * @throws \Symfony\Component\HttpKernel\Exception\BadRequestHttpException
   *   Thrown when no log entry was provided.
   */
  public function get($email=null) {

    if (!\Drupal::service('email.validator')->isValid($email)) {
        $message = ['ERROR' => 'INVALID_EMAIL'];
    } else {
        $user = user_load_by_mail($email);

        if ($user) {
            $message = ['SUCCESS' => 'User found!'];
        } else {
            $message = ['SUCCESS' => 'User not found!'];
        }
    }
    $response = new ResourceResponse($message);

    // In order to generate fresh result every time (without clearing
    // the cache), you need to invalidate the cache.
    $response->addCacheableDependency($message);
    return $response;
  }

}