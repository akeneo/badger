<?php

namespace Badger\GameBundle\Helper;

use Badger\GameBundle\Entity\BadgeProposalInterface;
use Badger\GameBundle\Entity\BadgeVoteInterface;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Summary of the badge votes to present data
 *
 * @author    Pierre Allard <pierre.allard@akeneo.com>
 * @copyright 2016 Akeneo SAS (http://www.akeneo.com)
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 */
class BadgeVoteSummary
{
    /** @var BadgeProposalInterface[] */
    protected $badgeProposals;

    /** @var BadgeVoteInterface[] */
    protected $userVotes;

    /** @var ArrayCollection */
    protected $voteCounts;

    /**
     * @param BadgeProposalInterface[] $badgeProposals
     *
     * @return BadgeVoteSummary
     */
    public function setBadgeProposals(array $badgeProposals)
    {
        $this->badgeProposals = $badgeProposals;

        return $this;
    }

    /**
     * @param BadgeVoteInterface[] $badgeVotes
     *
     * @return BadgeVoteSummary
     */
    public function setUserVotes($badgeVotes)
    {
        $this->userVotes = $badgeVotes;

        return $this;
    }

    /**
     * @param ArrayCollection $voteCounts
     *
     * @return BadgeVoteSummary
     */
    public function setVoteCounts($voteCounts)
    {
        $this->voteCounts = $voteCounts;

        return $this;
    }

    /**
     * @return BadgeProposalInterface[]
     */
    public function getBadgeProposals()
    {
        return $this->badgeProposals;
    }

    /**
     * @param BadgeProposalInterface $badgeProposal
     *
     * @return bool
     */
    public function hasUpvoted(BadgeProposalInterface $badgeProposal)
    {
        foreach ($this->userVotes as $userVote) {
            if ($userVote->getBadgeProposal() === $badgeProposal) {
                return true === $userVote->getOpinion();
            }
        }

        return false;
    }

    /**
     * @param BadgeProposalInterface $badgeProposal
     *
     * @return bool
     */
    public function hasDownvoted(BadgeProposalInterface $badgeProposal)
    {
        foreach ($this->userVotes as $userVote) {
            if ($userVote->getBadgeProposal() === $badgeProposal) {
                return false === $userVote->getOpinion();
            }
        }

        return false;
    }

    /**
     * @param BadgeProposalInterface $badgeProposal
     *
     * @return int
     */
    public function countUpvotes(BadgeProposalInterface $badgeProposal)
    {
        foreach ($this->voteCounts as $proposalCounts) {
            if ($proposalCounts['id'] === $badgeProposal->getId()) {
                return (int) $proposalCounts['upvotes'];
            }
        }

        return 0;
    }

    /**
     * @param BadgeProposalInterface $badgeProposal
     *
     * @return int
     */
    public function countDownvotes(BadgeProposalInterface $badgeProposal)
    {
        foreach ($this->voteCounts as $proposalCounts) {
            if ($proposalCounts['id'] === $badgeProposal->getId()) {
                return (int) $proposalCounts['downvotes'];
            }
        }

        return 0;
    }
}
