<?php

namespace AppBundle\Managers;

use AppBundle\Entity\Message;
use AppBundle\Entity\User;
use AppBundle\Entity\Chat;
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



    public function create(User $user, Chat $chat, string $text):Message
    {
        $message = new Message();

        $message->setChat($chat);
        $message->setText($text);
        $message->setUser($user);
        $message->setCreatedAtNow();

        $this->entityManager->persist($message);
        $this->entityManager->flush();

        return $message;
    }

}