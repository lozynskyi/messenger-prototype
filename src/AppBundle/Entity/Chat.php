<?php

namespace AppBundle\Entity;

/**
 * Chat
 */
class Chat
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $topic;

    /**
     * @var \DateTime
     */
    private $createdAt;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $message;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->message = new \Doctrine\Common\Collections\ArrayCollection();
    }

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
     * Set topic.
     *
     * @param string $topic
     *
     * @return Chat
     */
    public function setTopic($topic)
    {
        $this->topic = $topic;

        return $this;
    }

    /**
     * Get topic.
     *
     * @return string
     */
    public function getTopic()
    {
        return $this->topic;
    }

    /**
     * Set createdAt.
     *
     * @param \DateTime $createdAt
     *
     * @return Chat
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
     * Add message.
     *
     * @param \AppBundle\Entity\Message $message
     *
     * @return Chat
     */
    public function addMessage(\AppBundle\Entity\Message $message)
    {
        $this->message[] = $message;

        return $this;
    }

    /**
     * Remove message.
     *
     * @param \AppBundle\Entity\Message $message
     *
     * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
     */
    public function removeMessage(\AppBundle\Entity\Message $message)
    {
        return $this->message->removeElement($message);
    }

    /**
     * Get message.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getMessage()
    {
        return $this->message;
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
