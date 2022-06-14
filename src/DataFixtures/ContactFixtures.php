<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Contact;
use App\Utils\ContactUtility;
use Doctrine\Persistence\ObjectManager;

class ContactFixtures extends BaseFixture
{
    public function loadData(ObjectManager $manager): void
    {
        $this->createMany(Contact::class, 200, function (Contact $contact) {
            $firstName = $this->faker->unique()->firstName;
            $lastName = $this->faker->unique()->lastName;

            $contact->setFirstName($firstName)
                ->setLastName($lastName)
                ->setEmail(ContactUtility::generateMaskedEmail($firstName, $lastName, $this->faker->unique()->domainName))
                ->setSlug(urlencode(ContactUtility::transliterateString($firstName) . '-' . ContactUtility::transliterateString($lastName)));
            if ($this->faker->boolean(50)) {
                $contact->setNote($this->faker->realText($this->faker->numberBetween(200, 1000)));
            }
        });

        $manager->flush();
    }
}
