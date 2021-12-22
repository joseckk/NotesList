<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class NoteUnique extends Constraint
{
    /*
     * Any public properties become valid options for the annotation.
     * Then, use these in your validator class.
     */
    public $message = 'Note with title "{{ value }}" exist.';

    public function getTargets()
    {
        return self::CLASS_CONSTRAINT;
    }
}
