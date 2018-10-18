<?php

namespace AppBundle\Repository;

class UserRepository extends \Doctrine\ORM\EntityRepository
{
    /**
     * @param string $email
     * @return bool
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function isExist(string $email): bool
    {
        $count = $this->createQueryBuilder('c')
            ->select('COUNT(c.id)')
            ->where('c.email = :email')
            ->setParameters([
                'email' => $email,
            ])
            ->getQuery()
            ->getSingleScalarResult();

        return intval($count) > 0;
    }
}
