<?php

namespace Drupal\radicati_social\Plugin\Block;

use Drupal\Core\Block\BlockBase;

/**
 * Provides a Radicati Social block.
 *
 * @Block(
 *   id = "radicati_social",
 *   admin_label = @Translation("Radicati Social Block"),
 *   category = @Translation("Radicati")
 * )
 */
class RadicatiSocialBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build() {
    return _prepare_share_buttons();
  }
}