<?php

namespace App\Controller\Admin;

use App\Entity\Property;
use App\Form\PropertyType;
use App\Repository\PropertyRepository;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class AdminPropertyController extends AbstractController
{
    /**
     * @var PropertyRepository
     */
    private $repository;


    public function __construct(PropertyRepository $repository, ObjectManager $manager)
    {
        $this->repository = $repository;
        $this->manager = $manager;
    }

    /**
     * @Route("/admin", name="admin.property.index")
     */
    public function index() : Response
    {
        $properties = $this->repository->findAll();
        return $this->render('admin/admin.html.twig', [
            'properties' => $properties
        ]);     
    }

    /**
     * @Route("/admin/property/create", name="admin.property.new")
     */
    public function new(Request $request, ObjectManager $manager)
    {
        $property = new Property();
        $form = $this->createForm(PropertyType::class, $property);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager = $this->getDoctrine()->getManager();
            
            $manager->persist($property);
            $manager->flush();   
            $this->addFlash('success','La propriété à été crée avec succès');

           
            return $this->redirectToRoute('admin.property.index');
        }

        return $this->render('admin/new.html.twig', [
            'property' => '$property',
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/property/{id}", name="admin.property.edit", methods="GET|POST")
     */
    public function edit(Property $property, Request $request)
    {
        $form = $this->createForm(PropertyType::class, $property);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->manager->flush();  
            $this->addFlash('success','La propriété à été modifié avec succès');
            return $this->redirectToRoute('admin.property.index');
        }

        return $this->render('admin/edit.html.twig', [
            'property' => '$property',
            'form' => $form->createView()
        ]);
    }


    /**
     * @Route("/admin/property/{id}", name="admin.property.delete", methods="DELETE")
     */
    public function delete(Property $property, Request $request)
    {
        dump('suppression');

        if ($this->isCsrfTokenValid('delete'. $property->getId(), ($request->get('_token')))) {
        
        
        $manager = $this->getDoctrine()->getManager();
        $this->manager->remove($property);
        $this->manager->flush();  
        
        $this->addFlash(
            'success',
        'La propriété à été supprimé.');
        }

        return $this->redirectToRoute('admin.property.index');
    
    }


}