<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;

use App\Repository\ArtworkRepository;
use App\Entity\Artwork;
use Knp\Component\Pager\PaginatorInterface;
use App\Form\ArtworkType;
use App\Form\SearchArtworkType;
use Doctrine\Persistence\ManagerRegistry;
use App\Data\SearchData;

class ArtworkController extends AbstractController
{
    /**
     * @Route("/artwork", name="all_artwork")
     */
    public function index(
        ArtworkRepository $artworkRepository,
        string $deleteMessage = null,
        Request $request,
        PaginatorInterface $paginator
    ): Response {
        $searchArtworkData = new SearchData();
        $searchArtworkData->page = $request->get('page', 1);
        $form = $this->createForm(SearchArtworkType::class, $searchArtworkData);
        $form->handleRequest($request);
        $data = $artworkRepository->findSearch($searchArtworkData);

        if (isset($_GET['deleteMessage']) && !empty($_GET['deleteMessage'])) {
            $deleteMessage = htmlspecialchars($_GET['deleteMessage']);
        }

        $artworkColumns = array(
            "Number",
            "Name",
            "Title",
            "Dimensions",
            "Medium"
        );

        $artworks = $paginator->paginate(
            $data,
            $searchArtworkData->page,
            50
        );

        return $this->render('artwork/index.html.twig', [
            'artworks' => $artworks,
            'length' => $artworks->getTotalItemCount(),
            'deleteMessage' => $deleteMessage,
            'artworkColumns' => $artworkColumns,
            'searchArtworkForm' => $form->createView(),
        ]);
    }

    /**
     * @Route("/artwork/{id}", name="one_artwork", requirements={"id"= "[1-9]\d*"}, methods={"GET"})
     */
    public function showArtwork(int $id, ArtworkRepository $artworkRepository, string $successMessage = null): Response
    {
        $artwork = $artworkRepository->find($id);

        if ($artwork == null) {
            // $message = "Artwork not found.";
            return $this->redirectToRoute('all_artwork');
        }

        if (isset($_GET['successMessage']) && !empty($_GET['successMessage'])) {
            $successMessage = htmlspecialchars($_GET['successMessage']);
        }

        return $this->render('artwork/artwork_show.html.twig', [
            'artwork' => $artwork,
            'successMessage' => $successMessage,
        ]);
    }

    /**
     * @Route("/artwork/add", name="add_artwork", methods={"POST", "GET"})
     */
    public function createArtwork(ManagerRegistry $doctrine, Request $request): Response
    {
        $artwork = new Artwork();

        $form = $this->createForm(ArtworkType::class, $artwork);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $artwork = $form->getData();

            $entityManager = $doctrine->getManager();
            $entityManager->persist($artwork);
            $entityManager->flush();

            $successMessage = "Artwork created successfully !";

            return $this->redirectToRoute('one_artwork', [
                'id' => $artwork->getId(),
                'successMessage' => $successMessage
            ]);
        }

        return $this->render('artwork/artwork_form.html.twig', [
            'artworkForm' => $form->createView(),
        ]);
    }

    /**
     * @Route("/artwork/remove/{id}", name="remove_artwork", requirements={"id"= "[1-9]\d*"})
     */
    public function removeArtwork(ManagerRegistry $doctrine, int $id): RedirectResponse
    {
        $artwork = $doctrine->getRepository(Artwork::class)->find($id);

        if ($artwork != null) {
            $entityManager = $doctrine->getManager();
            $entityManager->remove($artwork);
            $entityManager->flush();
            $deleteMessage = "Artwork deleted successfully.";

            return $this->redirectToRoute('all_artwork', ['deleteMessage' => $deleteMessage]);
        }
        return $this->redirectToRoute('all_artwork');
    }

    /**
     * @Route("/artwork/edit/{id}", name="edit_artwork", requirements={"id"= "[1-9]\d*"})
     */
    public function editArtwork(int $id, ManagerRegistry $doctrine, Request $request)
    {

        $artwork = $doctrine->getRepository(Artwork::class)->find($id);

        if ($artwork) {

            $form = $this->createForm(ArtworkType::class, $artwork);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $artwork = $form->getData();

                $entityManager = $doctrine->getManager();
                $entityManager->flush();
                $successMessage = "Artwork changed successfully!";

                return $this->redirectToRoute('one_artwork', [
                    'id' => $artwork->getId(),
                    'successMessage' => $successMessage
                ]);
            }
            return $this->render('artwork/edit_form.html.twig', [
                'artworkEditForm' => $form->createView(),
            ]);
        }

        return $this->redirectToRoute('all_artwork');
    }
}
