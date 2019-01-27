<?php

namespace App\DataFixtures;

use App\Entity\Department;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class UserFixtures extends Fixture
{
    private const USERS = [
        [0, 'John doe', 'johndoe.mail@yopmail.com', 'Marketing'],
        [1, 'Thib', 'thibaut.trouve@epitech.eu', 'Accounting'],
        [2, 'thibtest', 'thibtest@yopmail.com', 'Technical'],
        [3, 'Jean', 'jeantest@yopmail.com', 'Marketing'],
        [4, 'Bobby', 'bobbytest@yopmail.com', 'Accounting'],
        [5, 'Dylan', 'dylantest@yopmail.com', 'Marketing'],
    ];

    public const BASE_USER_REFERENCE = 'user-';

    private const ID = 0;
    private const NAME = 1;
    private const EMAIL = 2;
    private const DEPARTMENT = 3;

    public static function getUsersInDepartment($department)
    {
        return array_filter(self::USERS, function ($element) use ($department) {
            return $element[self::DEPARTMENT] == $department;
        });
    }

    public function load(ObjectManager $manager)
    {
        foreach (self::USERS as $index => $USER) {
            $user = new User();
            $user->setName($USER[self::NAME]);
            $user->setEmail($USER[self::EMAIL]);
            $manager->persist($user);
            $this->addReference(self::BASE_USER_REFERENCE . $index, $user);
        }
        $manager->flush();
    }
}
