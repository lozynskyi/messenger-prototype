<?php

namespace AppBundle\Entity;

/**
 * Message
 */
class Message
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $text;

    /**
     * @var \DateTime
     */
    private $createdAt;

    /**
     * @var \AppBundle\Entity\User
     */
    private $user;

    /**
     * @var \AppBundle\Entity\Chat
     */
    private $chat;


    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set text.
     *
     * @param string $text
     *
     * @return Message
     */
    public function setText($text)
    {
        $this->text = $text;

        return $this;
    }

    /**
     * Get text.
     *
     * @return string
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * Set createdAt.
     *
     * @param \DateTime $createdAt
     *
     * @return Message
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt.
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set user.
     *
     * @param \AppBundle\Entity\User $user
     *
     * @return Message
     */
    public function setUser(\AppBundle\Entity\User $user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user.
     *
     * @return \AppBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set chat.
     *
     * @param \AppBundle\Entity\Chat $chat
     *
     * @return Message
     */
    public function setChat(\AppBundle\Entity\Chat $chat)
    {
        $this->chat = $chat;

        return $this;
    }

    /**
     * Get chat.
     *
     * @return \AppBundle\Entity\Chat
     */
    public function getChat()
    {
        return $this->chat;
    }
    /**
     * @ORM\PrePersist
     */
    public function setCreatedAtNow()
    {
        if (!$this->getCreatedAt()) {
            $this->setCreatedAt(new \DateTime());
        }

        return $this;
    }
    /**
     * @ORM\PreUpdate
     */
    public function setUpdatedAtNow()
    {
        return $this;
    }
}
