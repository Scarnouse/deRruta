<?php

namespace DrutaBundle\Model;

use Doctrine\ORM\EntityManagerInterface;
use DrutaBundle\Entity\Role;
use DrutaBundle\Entity\User;
use Symfony\Component\Security\Core\Encoder\MessageDigestPasswordEncoder;

class UserModel
{
    /**
     * @var \DrutaBundle\Entity\UserRepository
     */
    private $repository;

    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    function __construct(EntityManagerInterface $entityManager)
    {
        $this->repository = $entityManager->getRepository('DrutaBundle:User');
        $this->entityManager = $entityManager;
    }

    public function add(User $user)
    {
        $this->entityManager->persist($user);
    }

    public function update(User $user)
    {
        $this->entityManager->persist($user);
    }

    public function findById($id)
    {
        return $this->repository->findById($id);
    }

    public function findByEmail($email)
    {
        return $this->repository->findByEmail($email);
    }

    public function applyChanges(){
        $this->entityManager->flush();
    }

    public function registerUser($user, $role){
        $encoder = new MessageDigestPasswordEncoder('sha512', true, 10);
        /** @var User $foundUser */
        $foundUser = $this->findByEmail($user->getEmail());
        if($foundUser)
            return 'user_exists';
        else {
            $user->setEmail($user->getUsername());
            $user->setSalt(md5(time()));
            $password = $encoder->encodePassword($user->getPassword(), $user->getSalt());
            $user->setPassword($password);
            $this->entityManager->beginTransaction();
            try {
                $this->update($user);
                $this->applyChanges();

                /** var RoleModel $roleModel */
                $roleModel = new RoleModel($this->entityManager);
                $roleUser = new Role();
                $roleUser->setName($role);
                $roleUser->setUser($user);
                $roleModel->add($roleUser);
                $roleModel->applyChanges();

                $this->entityManager->commit();
                return 'user_register_ok';
            } catch(\Exception $ex){
                $this->entityManager->rollback();
                return 'user_register_fail';
            }
        }
    }

    //api login
    public function loginByEmail($email, $password)
    {
        $user = $this->findByEmail($email);

        $dataBasePassword = $user->getPassword();
        $salt = $user->getSalt();
        $encoder = new MessageDigestPasswordEncoder('sha512', true, 10);
        $postedPassword = $encoder->encodePassword($password, $salt);

        if($dataBasePassword == $postedPassword)
        {
            return true;
        }

        return false;
    }

}