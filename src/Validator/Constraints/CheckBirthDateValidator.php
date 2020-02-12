<?php

namespace App\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class CheckBirthDateValidator extends ConstraintValidator
{
    const LIMIT = 4;

    public function validate($value, Constraint $constraint)
    {
        /* @var $constraint CheckBirthDate */
        $today = new \DateTime();
        $age = $today->diff($value)->format('%y');

        if ((int)$age < self::LIMIT ){
            $this->context->addViolation($constraint->message);
        }





    }
}
