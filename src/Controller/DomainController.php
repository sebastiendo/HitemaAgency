<?php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class DomainController extends AbstractController

{
    /**
     * @Route("/biens", name="biens.index")
     * @return Response
     */
    public function index(): Response 
    {
        return $this->render('biens/index.html.twig', [
            'menu' => 'domains'
        ]);
    }
}