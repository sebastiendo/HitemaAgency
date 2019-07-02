<?php
namespace App\Controller;

use Twig\Environment;
use App\Entity\Contact;
use App\Entity\Property;
use App\Form\ContactType;
use App\Form\PropertyType;
use App\Repository\PropertyRepository;
use App\Notification\ContactNotification;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PropertyController extends AbstractController

{   
   
    /**
     * @var \Swift_Mailer
     */
    private $mailer;

    /**
     * @var Environment
     */
    private $render;

    public function __construct(PropertyRepository $repository, ObjectManager $em, \Swift_Mailer $mailer, Environment $render)
    {
        $this->repository = $repository;
        $this->em = $em;
        $this->mailer = $mailer;
        $this->render = $render;

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
    public function show(string $slug, $id, Property $property, Request $request, ContactNotification $notification): Response
    {
        
        $contact = new Contact();
        $contact->setProperty($property);
        $form = $this->createform(ContactType::class, $contact);
        $form->handleRequest($request);

        $property = $this->repository->find($id);

        if ($form->isSubmitted() && $form->isValid())
        {
            $contact->setFirstname($form->get('firstname')->getData());
            $contact->setLastname($form->get('lastname')->getData());
            $contact->setPhone($form->get('phone')->getData());
            $contact->setEmail($form->get('email')->getData());
            $contact->setMessage($form->get('message')->getData());
            
            $message = (new \Swift_Message('Agence :' . $contact->getProperty()->getTitle()))
            ->setFrom($contact->getEmail())
            ->setTo('hitema.agency@gmail.com')
            ->setReplyTo($contact->getEmail())
            ->setBody($this->render->render('emails/contact.html.twig', [
                'contact' => $contact
            ]), 'text/html');
            $this->mailer->send($message);
        
            $this->addFlash('success', 'Votre email à bien été envoyé, nous vous répondrons dans les meilleurs délais');
            return $this->redirectToRoute('property.show', [
                'id' => $property->getId(),
                'slug' => $property->getSlug()
            ]);
       }

        return $this->render('property/show.html.twig', [
           'property' => $property,
            'menu' => 'properties',
            'form' => $form->createView()
        ]);

        /*
        if ($property->getSlug() !==$slug) 
        
        {
            return $this->redirectToRoute('property.show', [
                'id' => $property->getId(),
                'slug' => $property->getSlug()
            ], 301);

        }
        */
    }
  
}