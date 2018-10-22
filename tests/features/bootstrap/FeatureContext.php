<?php

/**
 * @file
 * Feature Context for behat test.
 */

use NuvoleWeb\Drupal\DrupalExtension\Context\RawDrupalContext;

/**
 * Class FeatureContext.
 *
 * @package Drupal\ui_patterns\Tests\Behat
 */
class FeatureContext extends RawDrupalContext {

  /**
   * Store original values of 'system.performance' configuration.
   *
   * @var array
   */
  private $systemPerformance = [];

  /**
   * Assert that modules are enabled.
   *
   * @BeforeScenario @disableCompression
   */
  public function disableCompression() {
    $this->systemPerformance = \Drupal::config('system.performance')->get();
    \Drupal::configFactory()->getEditable('system.performance')->setData([
      'css' => ['preprocess' => FALSE],
      'js' => ['preprocess' => FALSE],
    ])->save();
  }

  /**
   * Restore performance settings.
   *
   * @AfterScenario @disableCompression
   */
  public function restorePerformanceSettings() {
    if (!empty($this->systemPerformance)) {
      \Drupal::configFactory()->getEditable('system.performance')->setData($this->systemPerformance)->save();
      $this->systemPerformance = [];
    }
  }

}
