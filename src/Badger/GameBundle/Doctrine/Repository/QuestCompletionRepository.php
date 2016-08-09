<?php

namespace Badger\GameBundle\Doctrine\Repository;

use Badger\GameBundle\Repository\QuestCompletionRepositoryInterface;
use Badger\GameBundle\Repository\TagSearchableRepositoryInterface;
use Badger\UserBundle\Entity\User;
use Badger\UserBundle\Entity\UserInterface;
use Doctrine\DBAL\Connection;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query;

/**
 * @author    Adrien Pétremann <adrien.petremann@akeneo.com>
 * @copyright 2016 Akeneo SAS (http://www.akeneo.com)
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 */
class QuestCompletionRepository extends EntityRepository implements
    QuestCompletionRepositoryInterface,
    TagSearchableRepositoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function findByTags(array $tags)
    {
        $tagIds = [];
        foreach ($tags as $tag) {
            $tagIds[] = $tag->getId();
        }

        $qb = $this->createQueryBuilder('qc');
        $qb->leftJoin('qc.quest', 'q')
            ->leftJoin('q.tags', 't')
            ->where('t.id IN (:ids)')->setParameter('ids', $tagIds, Connection::PARAM_STR_ARRAY)
            ->orderBy('qc.completionDate', 'desc')
            ->setMaxResults(15)
            ->groupBy('qc.id');

        return $qb->getQuery()->getResult();
    }

    /**
     * {@inheritdoc}
     */
    public function getQuestIdsClaimedByUser(UserInterface $user)
    {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select('quest.id')
            ->from('GameBundle:QuestCompletion', 'completion')
            ->leftJoin('completion.quest', 'quest')
            ->where('completion.user = :user')
            ->andWhere('completion.pending = 1')
            ->setParameter('user', $user);

        $queryResult = $qb->getQuery()->getScalarResult();

        return array_column($queryResult, 'id');
    }
}
