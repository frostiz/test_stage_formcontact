<?php

namespace App\DataFixtures;

use App\Entity\Department;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class DepartmentFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        foreach (['Marketing', 'Accounting', 'Technical'] as $index => $name) {
            $departement = new Department();
            $departement->setName($name);

            $users = UserFixtures::getUsersInDepartment($name);
            foreach ($users as $user) {
                $departement->addUser($this->getReference(UserFixtures::BASE_USER_REFERENCE.$user[0]));
            }
            $manager->persist($departement);
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return array(
            UserFixtures::class
        );
    }
}
