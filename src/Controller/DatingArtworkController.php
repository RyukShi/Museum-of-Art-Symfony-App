<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Component\HttpFoundation\RedirectResponse;
use App\Entity\DatingArtwork;
use App\Form\DatingArtworkType;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Persistence\ManagerRegistry;
use App\Repository\DatingArtworkRepository;
use Knp\Component\Pager\PaginatorInterface;
use App\Data\SearchData;
use App\Form\SearchDatingType;

class DatingArtworkController extends AbstractController
{
    /**
     * @Route("/dating", name="all_dating_artwork")
     */
    public function index(
        DatingArtworkRepository $repository,
        string $deleteMessage = null,
        Request $request,
        PaginatorInterface $paginator
    ): Response {
        $searchDatingData = new SearchData();
        $searchDatingData->page = $request->get('page', 1);
        $form = $this->createForm(SearchDatingType::class, $searchDatingData);
        $form->handleRequest($request);
        $data = $repository->findSearch($searchDatingData);

        $datingColumns = array(
            "Object Begin Date",
            "Object End Date",
        );

        $dainings = $paginator->paginate(
            $data,
            $searchDatingData->page,
            50
        );

        if (isset($_GET['deleteMessage']) && !empty($_GET['deleteMessage'])) {
            $deleteMessage =  htmlspecialchars($_GET['deleteMessage']);
        }

        return $this->render('dating_artwork/index.html.twig', [
            'datings' => $dainings,
            'length' => $dainings->getTotalItemCount(),
            'deleteMessage' => $deleteMessage,
            'datingColumns' => $datingColumns,
            'searchDatingForm' => $form->createView(),
        ]);
    }

    /**
     * @Route("/dating/{id}", name="one_dating_artwork", requirements={"id"= "[1-9]\d*"})
     */
    public function showDating(int $id, DatingArtworkRepository $repository, string $successMessage = null): Response
    {
        $dating = $repository->find($id);

        if ($dating == null) {
            //$message = "Dating Artwork not found.";
            return $this->redirectToRoute('all_dating_artwork');
        }

        if (isset($_GET['successMessage']) && !empty($_GET['successMessage'])) {
            $successMessage = htmlspecialchars($_GET['successMessage']);
        }

        return $this->render('dating_artwork/dating_show.html.twig', [
            'dating' => $dating,
            'successMessage' => $successMessage,
        ]);
    }

    /**
     * @Route("/dating/add", name="add_dating_artwork")
     */
    public function createDating(ManagerRegistry $doctrine, Request $request): Response
    {
        $dating = new DatingArtwork();

        $form = $this->createForm(DatingArtworkType::class, $dating);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $dating = $form->getData();

            $entityManager = $doctrine->getManager();
            $entityManager->persist($dating);
            $entityManager->flush();

            $successMessage = "Dating Artwork created successfully !";

            return $this->redirectToRoute('one_dating_artwork', [
                'id' => $dating->getId(),
                'successMessage' => $successMessage
            ]);
        }

        return $this->render('dating_artwork/dating_form.html.twig', [
            'datingForm' => $form->createView(),
        ]);
    }

    /**
     * @Route("/dating/remove/{id}", name="remove_dating_artwork", requirements={"id"= "[1-9]\d*"})
     */
    public function removeDating(ManagerRegistry $doctrine, int $id): RedirectResponse
    {
        $dating = $doctrine->getRepository(DatingArtwork::class)->find($id);

        if ($dating != null) {
            $entityManager = $doctrine->getManager();
            $entityManager->remove($dating);
            $entityManager->flush();
            $deleteMessage = "Dating Artwork deleted successfully.";

            return $this->redirectToRoute('all_dating_artwork', ['deleteMessage' => $deleteMessage]);
        }
        return $this->redirectToRoute('all_dating_artwork');
    }

    /**
     * @Route("/dating/edit/{id}", name="edit_dating_artwork", requirements={"id"= "[1-9]\d*"})
     */
    public function editDating(int $id, ManagerRegistry $doctrine, Request $request)
    {

        $dating = $doctrine->getRepository(DatingArtwork::class)->find($id);

        if ($dating) {

            $form = $this->createForm(DatingArtworkType::class, $dating);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $dating = $form->getData();

                $entityManager = $doctrine->getManager();
                $entityManager->flush();
                $successMessage = "Dating changed successfully!";

                return $this->redirectToRoute('one_dating_artwork', [
                    'id' => $dating->getId(),
                    'successMessage' => $successMessage
                ]);
            }
            return $this->render('dating_artwork/edit_form.html.twig', [
                'datingEditForm' => $form->createView(),
            ]);
        }

        return $this->redirectToRoute('all_dating_artwork');
    }
}
