<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use App\Repository\ArtistRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use App\Entity\Artist;
use App\Form\ArtistType;

class ArtistController extends AbstractController
{
    /**
     * @Route("/artist", name="all_artist")
     */
    public function index(ArtistRepository $repository, string $deleteMessage = null): Response
    {
        $allArtist = $repository->findAll();

        if (isset($_GET['deleteMessage']) && !empty($_GET['deleteMessage'])) {
            $deleteMessage = htmlspecialchars($_GET['deleteMessage']);
        }

        $artistColumns = array(
            "Display Name",
            "Begin Date",
            "End Date",
            "Gender",
            "Nationality",
        );

        return $this->render('artist/index.html.twig', [
            'artists' => $allArtist,
            'length' => count($allArtist),
            'artistColumns' => $artistColumns,
            'deleteMessage' => $deleteMessage,
        ]);
    }

    /**
     * @Route("/artist/{id}", name="one_artist", requirements={"id"= "[1-9]\d*"})
     */
    public function showArtist(ArtistRepository $repository, int $id, string $successMessage = null): Response
    {
        $artist = $repository->find($id);

        if ($artist == null) {
            //$message = "Artist not found";
            return $this->redirectToRoute('all_artist');
        }

        if (isset($_GET['successMessage']) && !empty($_GET['successMessage'])) {
            $successMessage = htmlspecialchars($_GET['successMessage']);
        }

        return $this->render('artist/artist_show.html.twig', [
            'artist' => $artist,
            'successMessage' => $successMessage
        ]);
    }

    /**
     * @Route("/artist/add", name="add_artist")
     */
    public function createArtist(ManagerRegistry $doctrine, Request $request): Response
    {
        $artist = new Artist();

        $form = $this->createForm(ArtistType::class, $artist);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $artist = $form->getData();

            $entityManager = $doctrine->getManager();
            $entityManager->persist($artist);
            $entityManager->flush();

            $successMessage = "Artist created successfully !";

            return $this->redirectToRoute('one_artist', [
                'id' => $artist->getId(),
                'successMessage' => $successMessage
            ]);
        }

        return $this->render('artist/artist_form.html.twig', [
            'artistForm' => $form->createView(),
        ]);
    }

    /**
     * @Route("/artist/remove/{id}", name="remove_artist", requirements={"id"= "[1-9]\d*"})
     */
    public function removeArtist(ManagerRegistry $doctrine, int $id): RedirectResponse
    {
        $artist = $doctrine->getRepository(Artist::class)->find($id);

        if ($artist) {
            $entityManager = $doctrine->getManager();
            $entityManager->remove($artist);
            $entityManager->flush();
            $deleteMessage = "Artist deleted successfully.";

            return $this->redirectToRoute('all_artist', ['deleteMessage' => $deleteMessage]);
        }

        return $this->redirectToRoute('all_artist');
    }
}
