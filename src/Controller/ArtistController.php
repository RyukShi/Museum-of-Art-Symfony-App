<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use App\Repository\ArtistRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Knp\Component\Pager\PaginatorInterface;
use App\Entity\Artist;
use App\Form\ArtistType;
use App\Data\SearchData;
use App\Form\SearchArtistType;

class ArtistController extends AbstractController
{
    /**
     * @Route("/artist", name="all_artist")
     */
    public function index(
        ArtistRepository $repository,
        string $deleteMessage = null,
        Request $request,
        PaginatorInterface $paginator
    ): Response {
        $searchArtistData = new SearchData();
        $searchArtistData->page = $request->get('page', 1);
        $form = $this->createForm(SearchArtistType::class, $searchArtistData);
        $form->handleRequest($request);
        $data = $repository->findSearch($searchArtistData);

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

        $artists = $paginator->paginate(
            $data,
            $searchArtistData->page,
            50
        );

        return $this->render('artist/index.html.twig', [
            'artists' => $artists,
            'searchArtistForm' => $form->createView(),
            'length' => $artists->getTotalItemCount(),
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

        if ($artist->getArtworks() != null) {
            $length = $artist->getArtworks()->count();
        }

        if (isset($_GET['successMessage']) && !empty($_GET['successMessage'])) {
            $successMessage = htmlspecialchars($_GET['successMessage']);
        }

        return $this->render('artist/artist_show.html.twig', [
            'artist' => $artist,
            'length' => $length,
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

            if ($artist->getArtworks() != null) {
                foreach ($artist->getArtworks() as $artwork) {
                    $entityManager->remove($artwork);
                }
            }

            $entityManager->remove($artist);
            $entityManager->flush();
            $deleteMessage = "Artist deleted successfully.";

            return $this->redirectToRoute('all_artist', ['deleteMessage' => $deleteMessage]);
        }

        return $this->redirectToRoute('all_artist');
    }

    /**
     * @Route("/artist/edit/{id}", name="edit_artist", requirements={"id"= "[1-9]\d*"})
     */
    public function editArtist(int $id, ManagerRegistry $doctrine, Request $request)
    {

        $artist = $doctrine->getRepository(Artist::class)->find($id);

        if ($artist) {

            $form = $this->createForm(ArtistType::class, $artist);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $artist = $form->getData();

                $entityManager = $doctrine->getManager();
                $entityManager->flush();
                $successMessage = "Artist changed successfully!";

                return $this->redirectToRoute('one_artist', [
                    'id' => $artist->getId(),
                    'successMessage' => $successMessage
                ]);
            }
            return $this->render('artist/edit_form.html.twig', [
                'artistEditForm' => $form->createView(),
            ]);
        }

        return $this->redirectToRoute('all_artist');
    }
}
