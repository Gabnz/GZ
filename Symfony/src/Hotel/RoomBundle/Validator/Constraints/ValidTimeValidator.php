<?php

namespace Hotel\RoomBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class ValidTimeValidator extends ConstraintValidator
{
	public function validate($phonecall, Constraint $constraint)
	{

		$minDate = $phonecall->getReserve()->getEntrydate();

		$maxDate = new \DateTime("today");

		if($phonecall->getStarttime() >= $phonecall->getEndtime()){
			$this->context->addViolationAt(
				'endtime',
				$constraint->message,
				array(),
				null
			);
		}

		if($phonecall->getCalldate() < $minDate || $phonecall->getCalldate() > $maxDate){
			$this->context->addViolationAt(
				'calldate',
				$constraint->message2,
				array(),
				null
			);
		}
	}
}