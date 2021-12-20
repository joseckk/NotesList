<?php

namespace App\DataFixtures;

use App\Entity\Note;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // create 20 notes! Bam!
        for ($i = 0; $i < 20; $i++) {
            $note = new Note();
            $note->setTitle('Note '.$i);
            $note->setDescription('asdbnjasndasndja');
            $note->setFinish(false);
            $manager->persist($note);
        }

        $manager->flush();
    }
}
