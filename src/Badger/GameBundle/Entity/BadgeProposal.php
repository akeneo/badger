<?php

namespace Badger\GameBundle\Entity;

use Badger\UserBundle\Entity\UserInterface;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Badge proposal entity
 *
 * @author    Pierre Allard <pierre.allard@akeneo.com>
 * @copyright 2016 Akeneo SAS (http://www.akeneo.com)
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 */
class BadgeProposal implements BadgeProposalInterface
{
    /** @var string */
    protected $id;

    /** @var string */
    protected $title;

    /** @var string */
    protected $description;

    /** @var UserInterface */
    protected $user;

    /** @var ArrayCollection */
    protected $badgeVotes;

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * {@inheritdoc}
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * {@inheritdoc}
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * {@inheritdoc}
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * {@inheritdoc}
     */
    public function setUser(UserInterface $user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getBadgeVotes()
    {
        return $this->badgeVotes;
    }

    /**
     * {@inheritdoc}
     */
    public function hasUserUpvoted(UserInterface $user)
    {
        foreach ($this->getBadgeVotes() as $badgeVote) {
            if ($user === $badgeVote->getUser()) {
                return true === $badgeVote->getOpinion();
            }
        }

        return false;
    }

    /**
     * {@inheritdoc}
     */
    public function hasUserDownvoted(UserInterface $user)
    {
        foreach ($this->getBadgeVotes() as $badgeVote) {
            if ($user === $badgeVote->getUser()) {
                return false === $badgeVote->getOpinion();
            }
        }

        return false;
    }

    /**
     * {@inheritdoc}
     */
    public function getUpvotesCount()
    {
        $count = 0;
        foreach ($this->getBadgeVotes() as $badgeVote) {
            if (true === $badgeVote->getOpinion()) {
                $count++;
            }
        }

        return $count;
    }

    /**
     * {@inheritdoc}
     */
    public function getDownvotesCount()
    {
        $count = 0;
        foreach ($this->getBadgeVotes() as $badgeVote) {
            if (false === $badgeVote->getOpinion()) {
                $count++;
            }
        }

        return $count;
    }
}
