<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;

use App\Repository\LocalisationRepository;
use App\Form\LocalisationType;
use App\Form\SearchLocalisationType;
use App\Entity\Localisation;
use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\PaginatorInterface;
use App\Data\SearchData;

class LocalisationController extends AbstractController
{
    /**
     * @Route("/localisation", name="all_localisation")
     */
    public function index(
        LocalisationRepository $repository,
        string $deleteMessage = null,
        Request $request,
        PaginatorInterface $paginator
    ): Response {
        $searchClassificationData = new SearchData();
        $searchClassificationData->page = $request->get('page', 1);
        $form = $this->createForm(SearchLocalisationType::class, $searchClassificationData);
        $form->handleRequest($request);
        $data = $repository->findSearch($searchClassificationData);

        $localisationColumns = array(
            "Culture",
            "Period",
            "Dynasty",
            "Reign",
            "Region",
            "Subregion",
            "Country",
            "County",
            "City",
            "Locale",
            "Locus",
            "River",
            "Excavation"
        );

        $localisations = $paginator->paginate(
            $data,
            $searchClassificationData->page,
            50
        );

        if (isset($_GET['deleteMessage']) && !empty($_GET['deleteMessage'])) {
            $deleteMessage =  htmlspecialchars($_GET['deleteMessage']);
        }

        return $this->render('localisation/index.html.twig', [
            'localisations' => $localisations,
            'length' => $localisations->getTotalItemCount(),
            'deleteMessage' => $deleteMessage,
            'localisationColumns' => $localisationColumns,
            'searchLocalisationForm' => $form->createView(),
        ]);
    }

    /**
     * @Route("/localisation/{id}", name="one_localisation", requirements={"id"= "[1-9]\d*"})
     */
    public function showLocalisation(LocalisationRepository $repository, int $id, string $successMessage = null): Response
    {
        $localisation = $repository->find($id);

        if ($localisation == null) {
            //$message = "Localisation not found";
            return $this->redirectToRoute('all_localisation');
        }

        if ($localisation->getArtworks() != null) {
            $length = $localisation->getArtworks()->count();
        }

        if (isset($_GET['successMessage']) && !empty($_GET['successMessage'])) {
            $successMessage = htmlspecialchars($_GET['successMessage']);
        }

        return $this->render('localisation/localisation_show.html.twig', [
            'localisation' => $localisation,
            'successMessage' => $successMessage,
            'length' => $length,
        ]);
    }

    /**
     * @Route("/localisation/add", name="add_localisation")
     */
    public function createLocalisation(ManagerRegistry $doctrine, Request $request): Response
    {
        $localisation = new Localisation();

        $form = $this->createForm(LocalisationType::class, $localisation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $localisation = $form->getData();

            $entityManager = $doctrine->getManager();
            $entityManager->persist($localisation);
            $entityManager->flush();

            $successMessage = "Localisation created successfully !";

            return $this->redirectToRoute('one_localisation', [
                'id' => $localisation->getId(),
                'successMessage' => $successMessage
            ]);
        }

        return $this->render('localisation/localisation_form.html.twig', [
            'localisationForm' => $form->createView(),
        ]);
    }

    /**
     * @Route("/localisation/remove/{id}", name="remove_localisation", requirements={"id"= "[1-9]\d*"})
     */
    public function removeLocalisation(ManagerRegistry $doctrine, int $id): RedirectResponse
    {
        $localisation = $doctrine->getRepository(Localisation::class)->find($id);

        if ($localisation != null) {
            $entityManager = $doctrine->getManager();

            if ($localisation->getArtworks() != null) {
                foreach ($localisation->getArtworks() as $artwork) {
                    $entityManager->remove($artwork);
                }
            }

            $entityManager->remove($localisation);
            $entityManager->flush();
            $deleteMessage = "Localisation deleted successfully.";

            return $this->redirectToRoute('all_localisation', ['deleteMessage' => $deleteMessage]);
        }
        return $this->redirectToRoute('all_localisation');
    }

    /**
     * @Route("/localisation/edit/{id}", name="edit_localisation", requirements={"id"= "[1-9]\d*"})
     */
    public function editLocalisation(int $id, ManagerRegistry $doctrine, Request $request)
    {

        $localisation = $doctrine->getRepository(Localisation::class)->find($id);

        if ($localisation) {

            $form = $this->createForm(LocalisationType::class, $localisation);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $localisation = $form->getData();

                $entityManager = $doctrine->getManager();
                $entityManager->flush();
                $successMessage = "Localisation changed successfully!";

                return $this->redirectToRoute('one_localisation', [
                    'id' => $localisation->getId(),
                    'successMessage' => $successMessage
                ]);
            }
            return $this->render('localisation/edit_form.html.twig', [
                'localisationEditForm' => $form->createView(),
            ]);
        }

        return $this->redirectToRoute('all_localisation');
    }
}
