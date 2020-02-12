<?php

namespace App\Validator\Constraints;

use Symfony\Component\Validator\Constraint;


/**
 * @Annotation
 */
class CheckOverTickets extends Constraint
{
    public $message = "Désolé, le musée est complet pour cette date.";
}


