<?php

namespace AppBundle\Managers;

//use AppBundle\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserManager
{
//    /**
//     * @var EntityManagerInterface
//     */
//    private $entityManager;
//    /**
//     * @var UserPasswordEncoderInterface
//     */
//    private $passwordEncoder;
//
//    public function __construct(EntityManagerInterface $entityManager, UserPasswordEncoderInterface $passwordEncoder)
//    {
//        $this->entityManager = $entityManager;
//        $this->passwordEncoder = $passwordEncoder;
//    }
//
//
//    public function create(string $email, string $auth, string $name = null, string $gender = null):User
//    {
//
//        $user = new User();
//        $user->setEmail($email);
//        $user->setCustomerId($authCustomerId);
//
//        $this->entityManager->persist($user);
//        $this->entityManager->flush();
//
//        return $user;
//    }
}