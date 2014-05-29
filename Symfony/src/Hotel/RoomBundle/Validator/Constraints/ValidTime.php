<?php

namespace Hotel\RoomBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */

class ValidTime extends Constraint{

	public $message = "La hora de terminacion debe ser mayor a la de inicio.";

	public $message2 = "La fecha de llamada debe estar entre la fecha de entrada y hoy.";

	public function validatedBy(){

		return get_class($this).'Validator';
	}

	public function getTargets(){

    	return self::CLASS_CONSTRAINT;
	}
}