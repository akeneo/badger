<?php

namespace Badger\GameBundle\EventListener;

use Badger\GameBundle\Event\BadgeUnlockEvent;
use Badger\GameBundle\Notifier\NotifierInterface;
use Symfony\Bridge\Monolog\Logger;
use Symfony\Bundle\FrameworkBundle\Routing\Router;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

/**
 * Event Listener to handle BadgeUnlockEvent, dispatched when a User unlocked a Badge.
 *
 * @author    Adrien Pétremann <adrien.petremann@akeneo.com>
 * @copyright 2016 Akeneo SAS (http://www.akeneo.com)
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 */
class UnlockBadgeListener
{
    /** @var Router */
    private $router;

    /** @var Logger */
    private $logger;

    /** @var NotifierInterface */
    private $notifier;

    /**
     * @param Router            $router
     * @param Logger            $logger
     * @param NotifierInterface $notifier
     */
    public function __construct(Router $router, Logger $logger, NotifierInterface $notifier)
    {
        $this->router   = $router;
        $this->logger   = $logger;
        $this->notifier = $notifier;
    }

    /**
     * @param BadgeUnlockEvent $event
     */
    public function onUnlockBadge(BadgeUnlockEvent $event)
    {
        $unlockedBadge = $event->getUnlockedBadge();
        $user = $unlockedBadge->getUser();
        $badge = $unlockedBadge->getBadge();

        $data = [
            'text' => sprintf(
                '<%s|%s> just unlocked the badge <%s|%s>!',
                $this->router->generate(
                    'userprofile',
                    ['username' => $user->getUsername()],
                    UrlGeneratorInterface::ABSOLUTE_URL
                ),
                $user->getUsername(),
                $this->router->generate(
                    'viewbadge',
                    ['id' => $badge->getId()],
                    UrlGeneratorInterface::ABSOLUTE_URL
                ),
                $badge->getTitle()
            ),
            'attachments' => [
                [
                    'color' => 'good',
                    'title' => $badge->getTitle(),
                    'text' => $badge->getDescription(),
                    'thumb_url' => $this->router->generate(
                        'homepage',
                        [],
                        UrlGeneratorInterface::ABSOLUTE_URL
                    ) . $badge->getImageWebPath()
                ]
            ]
        ];

        $this->notifier->notify($data);
    }
}
