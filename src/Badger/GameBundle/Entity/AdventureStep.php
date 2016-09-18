<?php

namespace Badger\GameBundle\Entity;

/**
 * Adventure Step
 *
 * @author    Marie Bochu <marie.bochu@akeneo.com>
 * @copyright 2016 Akeneo SAS (http://www.akeneo.com)
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 */
class AdventureStep implements AdventureStepInterface
{
    /** @var int */
    protected $id;

    /** @var string */
    protected $title;

    /** @var string */
    protected $description;

    /** @var int */
    protected $position;

    /** @var int */
    protected $rewardPoint;

    /** @var bool */
    protected $needProof;

    /** @var Badge */
    protected $badge;

    /** @var Adventure */
    protected $adventure;

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
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
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
    public function setDescription($description)
    {
        $this->description = $description;

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
    public function setPosition($position)
    {
        $this->position = $position;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * {@inheritdoc}
     */
    public function setRewardPoint($rewardPoint)
    {
        $this->rewardPoint = $rewardPoint;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getRewardPoint()
    {
        return $this->rewardPoint;
    }

    /**
     * {@inheritdoc}
     */
    public function needProof()
    {
        return $this->needProof;
    }

    /**
     * {@inheritdoc}
     */
    public function setNeedProof($needProof)
    {
        $this->needProof = $needProof;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function setBadge(BadgeInterface $badge)
    {
        $this->badge = $badge;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getBadge()
    {
        return $this->badge;
    }

    /**
     * {@inheritdoc}
     */
    public function setAdventure(AdventureInterface $adventure)
    {
        $this->adventure = $adventure;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getAdventure()
    {
        return $this->adventure;
    }
}

