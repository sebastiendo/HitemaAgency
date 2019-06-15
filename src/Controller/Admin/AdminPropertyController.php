<?php
namespace App\Controller\Admin;

use App\Entity\Property;
use App\Repository\PropertyRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class AdminPropertyController extends AbstractController
{
    /**
     * @var PropertyRepository
     */
    private $repository;

    public function __construct(PropertyRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @Route("/admin", name="admin.property.index")
     */
    public function index() : Response
    {
        $properties = $this->repository->findAll();
        return $this->render('admin/admin.html.twig', compact('properties'));     
    }
    /**
     * @Route("/admin/{id}", name="admin.property.edit")
     */
    public function edit(Property $property)
    {
        return $this->render('admin/edit.html.twig', compact('property'));
    }
}