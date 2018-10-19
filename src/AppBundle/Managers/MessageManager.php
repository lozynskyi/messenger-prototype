<?php

namespace AppBundle\Managers;

use AppBundle\Entity\Message;
use AppBundle\Entity\User;
use Doctrine\ORM\EntityManagerInterface;

class MessageManager
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * UserManager constructor.
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }



    public function create(User $user, int $chatId, string $text):Message
    {
        $message = new Message();

        $this->entityManager->persist($message);
        $this->entityManager->flush();

        return $message;
    }

}