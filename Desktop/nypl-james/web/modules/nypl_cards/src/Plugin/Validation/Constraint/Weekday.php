<?php

namespace Drupal\nypl_cards\Plugin\Validation\Constraint;

use Symfony\Component\Validator\Constraint;

/**
 * Requires a date field to have a weekday value.
 *
 * @Constraint(
 *   id = "WeekdayDate",
 *   label = @Translation("Weekday Date", context = "Validation"),
 *   type = "string"
 * )
 */
class WeekdayDate extends Constraint {

  public $needsValue = 'Please enter a weekday for %field: Monday to Friday.';

}
