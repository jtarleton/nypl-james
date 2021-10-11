<?php

namespace Drupal\nypl_cards\Plugin\Validation\Constraint;

use Drupal\Core\Entity\EntityPublishedInterface;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

/**
 * Validates the Weekday constraint.
 */
class WeekdayValidator extends ConstraintValidator {

  /**
   * {@inheritdoc}
   */
  public function validate($value, Constraint $constraint) {
    // Since the constraint was added to an entity type, $value will
    // represent the User entity.
    /** @var \Drupal\Core\Entity\EntityInterface $entity */
    $entity =& $value;

    // Since we have the entire entity, our validation can check multiple
    // fields. This helps perform validations on the entity as a whole as
    // opposed to only a field.
    if (
      $entity->field_start_date->isEmpty() &&
      $entity->field_end_date->isEmpty()
    ) {
      $this->context->addViolation($constraint->needsValue, [
        '%field_start' => $entity->field_start_date->getFieldDefinition()->getLabel(),
        '%field_end' => $entity->field_end_date->getFieldDefinition()->getLabel(),
      ]);
    }

    if (
      $this->isWeekend($entity->field_start_date->value) &&
      $this->isWeekend($entity->field_end_date->value)
    ) {
      $this->context->addViolation($constraint->needsValue, [
        '%field_start' => $entity->field_start_date->getFieldDefinition()->getLabel(),
        '%field_end' => $entity->field_end_date->getFieldDefinition()->getLabel(),
      ]);
    }

    if (
      $this->isWeekend($entity->field_start_date->value)
    ) {
      $this->context->addViolation($constraint->needsValue, [
        '%field_start' => $entity->field_start_date->getFieldDefinition()->getLabel(),
        '%field_end' => '',
      ]);
    }

    if (
      $this->isWeekend($entity->field_end_date->value)
    ) {
      $this->context->addViolation($constraint->needsValue, [
        '%field_start' => '',
        '%field_end' => $entity->field_end_date->getFieldDefinition()->getLabel(),
      ]);
    }




  }

  public function isWeekend($date) {
    $default_tz = date_default_timezone_get();
    $tz = (!empty($default_tz))  ? $default_tz : 'America/New_York';
    $inputDate = DateTime::createFromFormat("d-m-Y", $date, new DateTimeZone($tz));
    return $inputDate->format('N') >= 6;
  }


  // For the current date
  public function isTodayWeekend() {
    $default_tz = date_default_timezone_get();
    $tz = (!empty($default_tz))  ? $default_tz : 'America/New_York';
    $currentDate = new DateTime("now", new DateTimeZone("Europe/Amsterdam"));
    return $currentDate->format('N') >= 6;
  }


}
