<?php

namespace App\Controller;

use App\Entity\Note;
use App\Form\NoteType;
use App\Repository\NoteRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class NoteController extends AbstractController
{
    const ELEMENTS_FOR_PAGES = 10;

    /**
     * @Route(
     *  "/{page}", 
     *  name="app_note_list",
     *  defaults={
     *      "page": 1
     *  },
     *  requirements={
     *      "page"="\d+"
     *  },
     *  methods={
     *      "GET"
     *  }
     * )
     */
    public function list(int $page, NoteRepository $notesRepository): Response
    {
        return $this->render('note/list.html.twig', [
            'notes' => $notesRepository->lookingForAll($page, self::ELEMENTS_FOR_PAGES),
            'page' => $page,
        ]);
    }

    /**
     * @Route("/new-note", name="app_note_new")
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $date = new DateTime();
        $date = $date->format('d-m-Y H:m:i');
        $note = new Note();
        $note->setDateCreated($date);
        $note->setFinish(false);
        $form = $this->createForm(NoteType::class, $note);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($note);
            $entityManager->flush();

            return $this->redirectToRoute('app_note_list', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('note/new.html.twig', [
            'note' => $note,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/show/{id}", name="app_note_show", methods={"GET"})
     */
    public function show(Note $note): Response
    {
        return $this->render('note/show.html.twig', [
            'note' => $note,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_note_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Note $note, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(NoteType::class, $note);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_note_list', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('note/edit.html.twig', [
            'note' => $note,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_note_delete", methods={"POST"})
     */
    public function delete(Request $request, Note $note, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$note->getId(), $request->request->get('_token'))) {
            $entityManager->remove($note);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_note_list', [], Response::HTTP_SEE_OTHER);
    }
}
