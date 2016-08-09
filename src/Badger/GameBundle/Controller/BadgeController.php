<?php

namespace Badger\GameBundle\Controller;

use Badger\GameBundle\Entity\BadgeInterface;
use Badger\GameBundle\Form\BadgeType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Badge controller for admin CRUD.
 *
 * @copyright 2016 Akeneo SAS (http://www.akeneo.com)
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 */
class BadgeController extends Controller
{
    /**
     * Lists all Badge entities.
     *
     * @return Response
     */
    public function indexAction()
    {
        $badges = $this->get('badger.game.repository.badge')
            ->findAll();

        return $this->render('@Game/badges/index.html.twig', [
            'badges' => $badges,
        ]);
    }

    /**
     * Creates a new Badge entity.
     *
     * @param Request $request
     *
     * @return RedirectResponse|Response
     */
    public function newAction(Request $request)
    {
        $badgeFactory = $this->get('badger.game.badge.factory');
        $badge = $badgeFactory->create();

        $form = $this->createForm(new BadgeType(), $badge);
        $form->add('file', 'file', ['label' => 'Badge image']);
        $form->remove('imagePath');
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $badge->upload();

            $badgeSaver = $this->get('badger.game.saver.badge');
            $badgeSaver->save($badge);

            return $this->redirectToRoute('admin_badge_show', ['id' => $badge->getId()]);
        }

        return $this->render('@Game/badges/new.html.twig', [
            'badge' => $badge,
            'form' => $form->createView()
        ]);
    }

    /**
     * Finds and displays a Badge entity.
     *
     * @param string $id
     *
     * @return Response
     */
    public function showAction($id)
    {
        $badge = $this->get('badger.game.repository.badge')->find($id);
        $deleteForm = $this->createDeleteForm($badge);

        return $this->render('@Game/badges/show.html.twig', [
            'badge' => $badge,
            'delete_form' => $deleteForm->createView(),
        ]);
    }

    /**
     * Displays a form to edit an existing Badge entity.
     *
     * @param Request $request
     * @param string  $id
     *
     * @return RedirectResponse|Response
     */
    public function editAction(Request $request, $id)
    {
        $badge = $this->get('badger.game.repository.badge')->find($id);
        $editForm = $this->createForm(new BadgeType(), $badge);
        $editForm->add('file');
        $editForm->remove('imagePath');
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $badge->upload();

            $badgeSaver = $this->get('badger.game.saver.badge');
            $badgeSaver->save($badge);

            return $this->redirectToRoute('admin_badge_edit', ['id' => $badge->getId()]);
        }

        return $this->render('@Game/badges/edit.html.twig', [
            'badge' => $badge,
            'edit_form' => $editForm->createView(),
        ]);
    }

    /**
     * Deletes a Badge entity.
     *
     * @param Request $request
     * @param string  $id
     *
     * @return RedirectResponse
     */
    public function deleteAction(Request $request, $id)
    {
        $badge = $this->get('badger.game.repository.badge')->find($id);
        $form = $this->createDeleteForm($badge);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $badgeRemover = $this->get('badger.game.remover.badge');
            $badgeRemover->remove($badge);
        }

        return $this->redirectToRoute('admin_badge_index');
    }

    /**
     * Creates a form to delete a Badge entity.
     *
     * @param BadgeInterface $badge The Badge entity
     *
     * @return Form The form
     */
    private function createDeleteForm(BadgeInterface $badge)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_badge_delete', ['id' => $badge->getId()]))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
