<?php
namespace App\Controller;

use App\Entity\Contact;
use App\Entity\Property;
use App\Form\ContactType;
use App\Repository\PropertyRepository;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PropertyController extends AbstractController

{
   
    public function __construct(PropertyRepository $repository, ObjectManager $em)
    {
        $this->repository = $repository;
        $this->em = $em;
    }

    /**
     * @Route("/biens", name="property.index")
     * @return Response
     */ 
    public function index(): Response 
    {
        return $this->render('property/index.html.twig', [
            'menu' => 'properties'
        ]);
    }

    /**
     * @Route("/biens/{slug}-{id}", name="property.show", requirements={"slug":"[a-z0-9\-]*"})
     *
     * @return Response
     */
    public function show(string $slug, $id, Property $property, Request $request): Response
    {
        if ($property->getSlug() !==$slug) 

        {
            return $this->redirectToRoute('property.show', [
                'id' => $property->getId(),
                'slug' => $property->getSlug()
            ], 301);

        }

        $contact = new Contact();
        $contact->setProperty($property);
        $form = $this->createform(ContactType::class, $contact);
        $form->handleRequest($request);

       if ($form->isSubmitted() && $form->isValid())
       {
           $this->addFlash('success', 'Votre email à bien été envoyé, nous vous répondrons dans les meilleurs délais');
           return $this->redirectToRoute('property.show', [
            'id' => $property->getId(),
            'slug' => $property->getSlug()
        ]);

       }
        $property = $this->repository->find($id);

        return $this->render('property/show.html.twig', [
           'property' => $property,
            'menu' => 'properties',
            'form' => $form->createView()
        ]);
    }
  
}