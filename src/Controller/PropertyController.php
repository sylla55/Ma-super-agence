<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Property;
use App\Entity\PropertySeach;
use App\Form\PropertySeachType;
use App\Repository\PropertyRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;

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
                'id'    => $property->getId(),
                'slug'  => $property->getSlug()
            ], 301);
        }
        return $this->render('property/show.html.twig',[
            'current_menu'  => 'properties',
            'property'      =>$property
        ]);

    }

    /**
     * @Route("/biens",name="property.index")
     * @return Response
     */
    public function index(PaginatorInterface $paginator, Request $request):Response
    {
        $seach = new PropertySeach();
        $fom = $this->createForm(PropertySeachType::class,$seach);
        $fom->handleRequest($request);

        $properties = $paginator->paginate($this->repository->findAllVisibleQuery($seach), 
        $request->query->getInt('page', 1),12);
        $this->em->flush();
        return $this->render('property/property.html.twig',[
            'current_menu' => 'properties',
            'properties'   => $properties,
            'form'         => $fom->createView()
        ]);
    }
}