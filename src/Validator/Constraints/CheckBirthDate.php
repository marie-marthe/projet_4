<?php

namespace App\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class CheckBirthDate extends Constraint
{

    public $message = 'Rappel! L\'entrée est gratuite pour les enfants de moin de 4ans.Veuillez entrer une date valide';
}
