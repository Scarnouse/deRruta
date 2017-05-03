<?php

namespace DrutaBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use DrutaBundle\Entity\Role;
use DrutaBundle\RoleBundle\Model\RoleModel;
use DrutaBundle\Entity\User;
use Symfony\Component\Security\Core\Encoder\MessageDigestPasswordEncoder;

class Users implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $encoder = new MessageDigestPasswordEncoder('sha512', true, 10);

        $users = array(
            array(
                'first_name' => 'Manuel',
                'last_name' => 'Quesada Segura',
                'password' => 'druta',
                'email' => 'manquesada@gmail.com',
                'role' => RoleModel::ROLE_ADMIN
            )
        );

        foreach ($users as $user){
            $entityUser = new User();

            $entityUser->setFirstName($user['first_name']);
            $entityUser->setLastName($user['last_name']);
            $entityUser->setSalt(md5(time()));
            $password = $encoder->encodePassword($user['password'], $entityUser->getSalt());
            $entityUser->setPassword($password);
            $entityUser->setEmail($user['email']);

            $manager->persist($entityUser);

            $entityRole = new Role();

            $entityRole->setName($user['role']);
            $entityRole->setUser($entityUser);

            $manager->persist($entityRole);
        }

        $manager->flush();

    }
}