<?php

namespace Hotel\UserBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class IsUnderAgeValidator extends ConstraintValidator
{
	public function validate($value, Constraint $constraint)
	{
		//echo var_dump($value); exit();
		$date = new \DateTime("today");
		date_sub($date, date_interval_create_from_date_string('18 years'));
		if($value > $date)
			$this->context->addViolation($constraint->message);
	}
}