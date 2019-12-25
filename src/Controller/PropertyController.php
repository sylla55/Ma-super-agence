<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Property;
use App\Repository\PropertyRepository;
use Doctrine\Common\Persistence\ObjectManager;

class PropertyController extends AbstractController{
    /**
     * @var PropertyRepository
     */
    private $repository;

    /**
     * @var ObjectManager
     */
    private $em;

    public function __construct(PropertyRepository $repository, ObjectManager $em)
    {
        $this->repository = $repository;
        $this->em = $em;
    }

    /**
     * @param Property $property
     * @param String $slug
     * @Route ("/biens/{slug}-{id}", name="property.show", requirements={"slug": "[a-z0-9\-]*"})
     * @return Response
     */
    public function show(Property $property, string $slug):Response
    {
        if($property->getSlug() !== $slug){
            $this->redirectToRoute('property.show',[
                'id' => $property->getId(),
                'slug' => $property->getSlug()
            ], 301);
        }
        return $this->render('property/show.html.twig',[
            'current_menu' => 'properties',
            'property' =>$property
        ]);
    }

    /**
     * @Route("/biens",name="property.index")
     * @return Response
     */
    public function index():Response
    {
        $property = $this->repository->findAllVisible();
        $this->em->flush();
        dump($property);
        return $this->render('property/property.html.twig',[
            'current_menu' => 'properties'
        ]);
    }
}