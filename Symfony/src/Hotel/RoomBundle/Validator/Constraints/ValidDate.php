<?php

namespace Hotel\RoomBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */

class ValidDate extends Constraint{

	public $message = "La fecha de entrada es invalida.";

	public $message2 = "La fecha de salida es invalida.";

	public $message3 = "La fecha de salida debe ser mayor a la de entrada.";

	public function validatedBy(){

		return get_class($this).'Validator';
	}

	public function getTargets(){

    	return self::CLASS_CONSTRAINT;
	}
}