<?php

namespace AppBundle\Managers;

use AppBundle\Entity\Chat;
use Doctrine\ORM\EntityManagerInterface;

class ChatManager
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

    /**
     * @param string $topic
     * @return Chat
     */
    public function create(string $topic):Chat
    {
        $chat = new Chat();
        $chat->setTopic($topic);

        $this->entityManager->persist($chat);
        $this->entityManager->flush();

        return $chat;
    }

}