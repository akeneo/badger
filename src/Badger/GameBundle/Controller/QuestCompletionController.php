<?php

namespace Badger\GameBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * @author    Adrien Pétremann <adrien.petremann@akeneo.com>
 * @copyright 2016 Akeneo SAS (http://www.akeneo.com)
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 */
class QuestCompletionController extends Controller
{
    /**
     * Lists all pending quest completions.
     *
     * @return Response
     */
    public function indexAction()
    {
        $pendingCompletions = $this->get('badger.game.repository.quest_completion')
            ->findBy(['pending' => 1]);

        return $this->render('@Game/claimed-quests/index.html.twig', [
            'pendingCompletions' => $pendingCompletions
        ]);
    }

    /**
     * Reject a quest completion by removing it from the database.
     *
     * @param string $id
     *
     * @return RedirectResponse
     */
    public function rejectAction($id)
    {
        $pendingCompletion = $this->get('badger.game.repository.quest_completion')
            ->findOneBy(['id' => $id, 'pending' => 1]);

        if (null === $pendingCompletion) {
            throw new NotFoundHttpException(sprintf('No pending QuestCompletion entity with id %s', $id));
        }

        $questTitle = $pendingCompletion->getQuest()->getTitle();
        $username = $pendingCompletion->getUser()->getUsername();

        $questCompletionRemover = $this->get('badger.game.remover.quest_completion');
        $questCompletionRemover->remove($pendingCompletion);

        $this->addFlash('notice', sprintf(
            'Successfully rejected the claimed quest "%s" for %s!',
            $questTitle,
            $username
        ));

        return $this->redirectToRoute('admin_claimed_quest_index');
    }

    /**
     * Accept a quest completion.
     *
     * @param string $id
     *
     * @return RedirectResponse
     */
    public function acceptAction($id)
    {
        $pendingCompletion = $this->get('badger.game.repository.quest_completion')
            ->findOneBy(['id' => $id, 'pending' => 1]);

        if (null === $pendingCompletion) {
            throw new NotFoundHttpException(sprintf('No pending QuestCompletion entity with id %s', $id));
        }

        $user = $pendingCompletion->getUser();
        $quest = $pendingCompletion->getQuest();

        $pendingCompletion->setPending(false);
        $pendingCompletion->setCompletionDate(new \DateTime());

        $errors = $this->get('validator')->validate($pendingCompletion);

        if (0 === count($errors)) {
            $user->addNuts($quest->getReward());
            $this->get('badger.game.saver.quest_completion')->save($pendingCompletion);

            $this->addFlash('notice', sprintf(
                '%s successfully completed the quest "%s"!',
                $user->getUsername(),
                $quest->getTitle()
            ));
        } else {
            $this->addFlash('error', (string) $errors);
        }

        return $this->redirectToRoute('admin_claimed_quest_index');
    }
}
