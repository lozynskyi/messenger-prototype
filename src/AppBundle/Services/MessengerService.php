<?php

namespace AppBundle\Services;

use AppBundle\Managers\ChatManager;
use AppBundle\Managers\MessageManager;
use AppBundle\Entity\Chat;
use Doctrine\ORM\EntityManagerInterface;

class MessengerService
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;
    /**
     * @var MessageManager
     */
    private $messageManager;
    /**
     * @var ChatManager
     */
    private $chatManager;

    public function __construct(
        EntityManagerInterface $entityManager,
        ChatManager $chatManager,
        MessageManager $messageManager
    ) {
        $this->entityManager = $entityManager;
        $this->chatManager = $chatManager;
        $this->messageManager = $messageManager;
    }


    public function createChat(string $topic): Chat
    {
        return $this->chatManager->create($topic);
    }
}