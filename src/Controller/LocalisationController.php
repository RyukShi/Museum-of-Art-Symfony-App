<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;

use App\Repository\LocalisationRepository;
use App\Form\LocalisationType;
use App\Entity\Localisation;
use Doctrine\Persistence\ManagerRegistry;

class LocalisationController extends AbstractController
{
    /**
     * @Route("/localisation", name="all_localisation")
     */
    public function index(LocalisationRepository $repository, string $deleteMessage = null): Response
    {
        $allLocalisation = $repository->findAll();

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

        if (isset($_GET['deleteMessage']) && !empty($_GET['deleteMessage'])) {
            $deleteMessage =  htmlspecialchars($_GET['deleteMessage']);
        }

        return $this->render('localisation/index.html.twig', [
            'localisations' => $allLocalisation,
            'length' => count($allLocalisation),
            'deleteMessage' => $deleteMessage,
            'localisationColumns' => $localisationColumns,
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

        if (isset($_GET['successMessage']) && !empty($_GET['successMessage'])) {
            $successMessage = htmlspecialchars($_GET['successMessage']);
        }

        return $this->render('localisation/localisation_show.html.twig', [
            'localisation' => $localisation,
            'successMessage' => $successMessage
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
    public function removeArtwork(ManagerRegistry $doctrine, int $id): RedirectResponse
    {
        $localisation = $doctrine->getRepository(Localisation::class)->find($id);

        if ($localisation != null) {
            $entityManager = $doctrine->getManager();
            $entityManager->remove($localisation);
            $entityManager->flush();
            $deleteMessage = "Localisation deleted successfully.";

            return $this->redirectToRoute('all_localisation', ['deleteMessage' => $deleteMessage]);
        }
        return $this->redirectToRoute('all_localisation');
    }
}
