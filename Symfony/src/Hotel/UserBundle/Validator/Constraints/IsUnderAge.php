<?php

namespace Hotel\UserBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */

class IsUnderAge extends Constraint
{
	public $message = "Debe tener 18 anios de edad o mas.";

	public function validatedBy()
	{
		return get_class($this).'Validator';
	}
}