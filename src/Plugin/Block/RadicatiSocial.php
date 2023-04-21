<?php

namespace Drupal\radicati_social\Plugin\Block;

use Drupal\Core\Block\BlockBase;

/**
 * Class RadicatiSocial
 *
 * Creates a simple social sharing block. Most of the business logic is in the
 * Radicati theme and javascript files.
 *
 * @Block(
 *   id = "radicati_social",
 *   admin_label = @Translation("Social Sharing"),
 *   category = @Translation("radicati")
 * )
 *
 * @package Drupal\radicati_social\Plugin\Block
 */
class RadicatiSocial extends BlockBase {

  public function build() {
    return [
      '#theme' => 'radicati_social'
    ];
  }

}
