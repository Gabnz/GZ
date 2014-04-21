<?php

namespace Hotel\RoomBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class ValidDateValidator extends ConstraintValidator
{
	public function validate($reserve, Constraint $constraint)
	{
		/*validacion de la fecha de entrada*/
		$minDate = new \DateTime("today");
		$maxDate = new \DateTime("today");

		date_add($maxDate, date_interval_create_from_date_string('2 months'));
		if($reserve->getEntrydate() < $minDate || $reserve->getEntrydate() > $maxDate){
			$this->context->addViolationAt(
				'entrydate',
				$constraint->message,
				array(),
				null
			);
		}

		/*validacion de la fecha de salida*/
		$minDate = new \DateTime("tomorrow");
		$maxDate = new \DateTime("tomorrow");
		date_add($maxDate, date_interval_create_from_date_string('2 months'));
		if($reserve->getExitdate() < $minDate || $reserve->getExitdate() > $maxDate){
			$this->context->addViolationAt(
				'exitdate',
				$constraint->message2,
				array(),
				null
			);
		}

		/*validacion de las fechas de entrada y salida*/
		if($reserve->getEntrydate() >= $reserve->getExitdate()){
			$this->context->addViolationAt(
				'exitdate',
				$constraint->message3,
				array(),
				null
			);
		}
	}
}