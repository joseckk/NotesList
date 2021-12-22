<?php

namespace App\Validator;

use App\Repository\NoteRepository;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class NoteUniqueValidator extends ConstraintValidator
{
    private $noteRepository;

    public function __construct(NoteRepository $noteRepository)
    {
        $this->noteRepository = $noteRepository;
    }

    public function validate($note, Constraint $constraint)
    {
        $title = $note->getTitle();
        if ($title === null || $title === '') {
            return;
        }

        $noteWithTitleExist = $this->noteRepository->findOneByTitle($title);
        if ($noteWithTitleExist !== null 
        && $noteWithTitleExist->getId() !== $note->getId()) {
            $this->context->buildViolation($constraint->message)
                ->setParameter('{{ value }}', $title)
                ->addViolation();
        }
    }
}
