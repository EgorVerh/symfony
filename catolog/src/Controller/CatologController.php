<?php

namespace App\Controller;

use App\Entity\Texts;
use App\Form\TextandUserType;
use Doctrine\ORM\Mapping\Id;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CatologController extends AbstractController
{
    /**
     * @Route("/catolog", name="app_catolog")
     */
    public function index(ManagerRegistry $doctrine,Request $request): Response
    {
        $texts=new Texts();
        $form=$this->createForm(TextandUserType::class);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $texts=$form->getData();
            $entityManager = $doctrine->getManager();
            $entityManager->persist($texts);
            $entityManager->flush();
            return $this->render('catolog/index.html.twig', [
                'form' =>$form->createView(),'id'=>$texts->getId()
            ]); 
        }
        return $this->render('catolog/index.html.twig', [
            'form' =>$form->createView(),'id'=>'Здесь будет ссылка на ваш текст'
        ]);
    }
    public function text(ManagerRegistry $doctrine,int $id): Response
    {
        $text = $doctrine->getRepository(Texts::class)->find($id);
        return $this->render('catolog/text.html.twig', [
            'text' => $text,
        ]);
    }
}
