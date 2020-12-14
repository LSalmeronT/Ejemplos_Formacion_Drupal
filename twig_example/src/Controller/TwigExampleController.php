<?php

/**
 * Created by Everis.
 * @author: Everis
 */

namespace Drupal\twig_example\Controller;

use Drupal\Core\Controller\ControllerBase;

class TwigExampleController extends ControllerBase
{

    public function twigExample()
    {
        return [
            '#theme' => 'example_template',
            '#example_text' => $this->t('Test Value'),
          ];
    }
}
