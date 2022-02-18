<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use App\Repository\ClassificationRepository;
use Symfony\Component\HttpFoundation\RedirectResponse;
use App\Entity\Classification;
use App\Form\ClassificationType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;

class ClassificationController extends AbstractController
{
    /**
     * @Route("/classification", name="all_classification")
     */
    public function index(ClassificationRepository $repository, string $deleteMessage = null): Response
    {
        $allClassifications = $repository->findAll();

        if (isset($_GET['deleteMessage']) && !empty($_GET['deleteMessage'])) {
            $deleteMessage = htmlspecialchars($_GET['deleteMessage']);
        }

        $classificationColumns = array(
            "Classification"
        );

        return $this->render('classification/index.html.twig', [
            'classificationColumns' => $classificationColumns,
            'classifications' => $allClassifications,
            'length' => count($allClassifications),
            'deleteMessage' => $deleteMessage
        ]);
    }

    /**
     * @Route("/classification/{id}", name="one_classification", requirements={"id"= "[1-9]\d*"})
     */
    public function showClassification(int $id, ClassificationRepository $repository, string $successMessage = null): Response
    {
        $classification = $repository->find($id);

        if ($classification == null) {
            //$message = "Classification not found";
            return $this->redirectToRoute('all_classification');
        }

        if (isset($_GET['successMessage']) && !empty($_GET['successMessage'])) {
            $successMessage = htmlspecialchars($_GET['successMessage']);
        }

        return $this->render('classification/classification_show.html.twig', [
            'classification' => $classification,
            'successMessage' => $successMessage
        ]);
    }

    /**
     * @Route("/classification/add", name="add_classification")
     */
    public function addClassification(ManagerRegistry $doctrine, Request $request): Response
    {
        $classification = new Classification();

        $form = $this->createForm(ClassificationType::class, $classification);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $classification = $form->getData();

            $entityManager = $doctrine->getManager();
            $entityManager->persist($classification);
            $entityManager->flush();

            $successMessage = "Classification created successfully !";

            return $this->redirectToRoute('one_classification', [
                'id' => $classification->getId(),
                'successMessage' => $successMessage
            ]);
        }

        return $this->render('classification/classification_form.html.twig', [
            'classificationForm' => $form->createView(),
        ]);
    }

    /**
     * @Route("/classification/remove/{id}", name="remove_classification", requirements={"id"= "[1-9]\d*"})
     */
    public function removeClassification(ManagerRegistry $doctrine, int $id): RedirectResponse
    {
        $classification = $doctrine->getRepository(Classification::class)->find($id);

        if ($classification) {
            $entityManager = $doctrine->getManager();
            $entityManager->remove($classification);
            $entityManager->flush();
            $deleteMessage = "Classification deleted successfully.";

            return $this->redirectToRoute('all_classification', ['deleteMessage' => $deleteMessage]);
        }
        return $this->redirectToRoute('all_classification');
    }
}
