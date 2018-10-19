<?php

namespace AppBundle\Services;

use AppBundle\Entity\Message;
use AppBundle\Entity\User;
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

    public function createMessage(User $user, Chat $chat, string $text): Message
    {
        return $this->messageManager->create($user, $chat, $text);
    }
}