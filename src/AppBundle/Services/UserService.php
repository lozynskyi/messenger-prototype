<?php

namespace AppBundle\Services;

use AppBundle\Managers\UserManager;
use AppBundle\Entity\User;
use Doctrine\ORM\EntityManagerInterface;

class UserService
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;
    /**
     * @var UserManager
     */
    private $userManager;

    public function __construct(EntityManagerInterface $entityManager, UserManager $userManager)
    {
        $this->entityManager = $entityManager;
        $this->userManager = $userManager;
    }


    public function create($email, $password, $gender, $username): User
    {
        $user = $this->userManager->create($email, $password, $username, $gender);
        return $user;
    }
}