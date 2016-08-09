<?php

namespace Badger\GameBundle\Factory;

use Badger\GameBundle\Entity\BadgeInterface;
use Badger\GameBundle\Entity\ClaimedBadge;
use Badger\UserBundle\Entity\UserInterface;

/**
 * @author    Adrien Pétremann <adrien.petremann@akeneo.com>
 * @copyright 2016 Akeneo SAS (http://www.akeneo.com)
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 */
class ClaimedBadgeFactory implements ClaimedBadgeFactoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function create(UserInterface $user, BadgeInterface $badge)
    {
        $claimedBadge = new ClaimedBadge();

        $claimedBadge->setUser($user);
        $claimedBadge->setBadge($badge);
        $claimedBadge->setClaimedDate(new \DateTime());

        return $claimedBadge;
    }
}
