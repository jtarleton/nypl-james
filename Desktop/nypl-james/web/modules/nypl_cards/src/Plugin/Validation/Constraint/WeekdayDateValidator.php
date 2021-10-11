<?php

namespace Drupal\nypl_cards\Plugin\Validation\Constraint;

use Drupal\Core\Entity\EntityPublishedInterface;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

/**
 * Validates the WeekdayDate constraint.
 */
class WeekdayDateValidator extends ConstraintValidator {

  /**
   * {@inheritdoc}
   */
  public function validate($value, Constraint $constraint) {
    // Since the constraint was added to an entity type, $value will
    // represent the Nyc Card entity.
    /** @var \Drupal\Core\Entity\EntityInterface $entity */
    $field =&$value;

    /* Since we have the entire entity, our validation can check multiple
    // fields. This helps perform validations on the entity as a whole as
    // opposed to only a field.
    if (
      empty($entity->field_start_date->getValue()) &&
      empty($entity->field_end_date->getValue())
    ) {

      $this->context->addViolation($constraint->needsValue, [
        '%field_start' => 'Start Date',
        '%field_end' =>'End Date',
      ]);
    }

    if (
      $this->isWeekend($entity->field_start_date->getValue()) &&
      $this->isWeekend($entity->field_end_date->getValue())
    ) {
      $this->context->addViolation($constraint->needsValue, [
        '%field_start' => 'Start Date',
        '%field_end' =>'End Date',
      ]);
    } */

    if (
      $this->isWeekend($field->getValue())
    ) {
      $this->context->addViolation($constraint->needsValue, [
        '%field_start' => 'Start Date',
        '%field_end' =>'',
      ]);
    }

    if (
      $this->isWeekend($field->getValue())
    ) {
      $this->context->addViolation($constraint->needsValue, [
        '%field_start' => '',
        '%field_end' =>'End Date',
      ]);
    }




  }

  public function isWeekend($date) {
    $default_tz = date_default_timezone_get();
    $tz = (!empty($default_tz))  ? $default_tz : 'America/New_York';
    $inputDate = \DateTime::createFromFormat("d-m-Y", $date, new \DateTimeZone($tz));
    return $inputDate->format('N') >= 6;
  }


  // For the current date
  public function isTodayWeekend() {
    $default_tz = date_default_timezone_get();
    $tz = (!empty($default_tz))  ? $default_tz : 'America/New_York';
    $currentDate = new \DateTime("now", $tz);
    return $currentDate->format('N') >= 6;
  }


}
