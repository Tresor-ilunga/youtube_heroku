<?php

namespace App\Controller;

use App\Entity\Youtube;
use App\Form\YoutubeType;
use App\Repository\YoutubeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class YoutubeController extends AbstractController
{
    #[Route('/', name: 'app_home', methods: ['GET', 'POST'])]
    public function index(Request $request, EntityManagerInterface $em, YoutubeRepository $youtubeRepository): Response
    {
        $youtube = new Youtube();

        $form = $this->createForm(YoutubeType::class, $youtube);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $youtube = $form->getData();
            $em->persist($youtube);
            $em->flush();

            return $this->redirectToRoute('app_home');
        }

        return $this->render('youtube/index.html.twig', [
            'form' => $form->createView(),
            'youtubes' => $youtubeRepository->findAll()
        ]);
    }

    #[Route('/{id}', name: 'app_video', methods: ['GET'])]
    public function video(Youtube $youtube): Response
    {
        return $this->render('youtube/video.html.twig', [
            'name' => $youtube->getName(),
            'url' => $youtube->getUrl()
        ]);
    }
}
