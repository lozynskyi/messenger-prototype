<?php

namespace AppBundle\Repository;

use AppBundle\Entity\Chat;

/**
 * MessageRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class MessageRepository extends \Doctrine\ORM\EntityRepository
{
    /**
     * @param Chat $chat
     * @param $limit
     * @param $offset
     * @return mixed
     */
    public function getAllMessages(Chat $chat, $limit, $offset)
    {
        $query = $this->createQueryBuilder('m')
            ->join(Chat::class, 'c', 'WITH', 'c.id = m.chat')
            ->andWhere('c.id = :id')
            ->setParameter('id', $chat->getId())
            ->setMaxResults($limit);
        if ($offset) {
            $query->setFirstResult($offset);
        }

        var_dump($query->getQuery()->getSQL());

        return $query->getQuery()->getResult();
    }
}
