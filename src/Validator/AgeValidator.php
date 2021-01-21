<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class AgeValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint)
    {
        /* @var $constraint \App\Validator\Age */

        if (null === $value || '' === $value) {
            return;
        }

        // TODO: implement the validation here
        $today = new \DateTimeImmutable();
        $diff = $today->diff($value);
        if( $diff->y < 18){
            $this->context->buildViolation($constraint->message)
            ->setParameter('{{ value }}', $value->format('m-d-Y'))
                ->addViolation();
        }
    }
}
