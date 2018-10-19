<?php

namespace AppBundle\Managers;

use AppBundle\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserManager
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;
    /**
     * @var UserPasswordEncoderInterface
     */
    private $passwordEncoder;

    /**
     * UserManager constructor.
     * @param EntityManagerInterface $entityManager
     * @param UserPasswordEncoderInterface $passwordEncoder
     */
    public function __construct(EntityManagerInterface $entityManager, UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->entityManager = $entityManager;
        $this->passwordEncoder = $passwordEncoder;
    }


    /**
     * @param string $email
     * @param string $password
     * @param string|null $name
     * @param string|null $gender
     * @return User
     */
    public function create(string $email, string $password, string $name = null, string $gender = null):User
    {
        $user = new User();
        $user->setEmail($email);
        $user->setGender($gender);
        $user->setUserName($name);
        $user->setUserToken($this->generateToken($email, $password));

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        return $user;
    }

    /**
     * @param string $email
     * @param string $password
     * @return bool|string
     */
    private function generateToken(string $email, string $password)
    {
        $options = [
            'cost' => 12,
        ];
        return password_hash($password.$email, PASSWORD_BCRYPT, $options);
    }

    /**
     * @param User $user
     * @param string $password
     * @return bool
     */
    private function validateToken(User $user, string $password)
    {
        return password_verify($password.$user->getEmail(), $user->getUserToken());
    }
}