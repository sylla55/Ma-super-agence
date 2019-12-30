<?php
namespace App\Controller\Admin;

use App\Entity\Option;
use App\Repository\PropertyRepository;
use App\Form\PropertyType;
use App\Entity\Property;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class AdminPropertyController extends AbstractController
{
    /**
     * @var PropertyRepository $repository
     * @var ObjectManager $em
     */
    private $repository;
    public function __construct(PropertyRepository $repository,ObjectManager $em)
    {
        $this->repository = $repository;
        $this->em = $em;
    }
    /**
     * @Route("/admin", name="admin.property.index")
     * @return Response
     */
    public function index()
    {
      $properties = $this->repository->findAll();
      return $this->render('admin/property/index.html.twig',[
          'properties' => $properties
      ]);
    }

    /**
     * @Route("/admin/property/create", name="admin.property.create")
     */
    public function new(Request $request)
    {
        $property = new Property();
        $form = $this->createForm(PropertyType::class,$property);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $this->em->persist($property);
            $this->em->flush();
            $this->addFlash('success','Votre bien a été ajouté');
            return $this->redirectToRoute('admin.property.index');
        }

        return $this->render("admin/property/new.html.twig",[
            'property'=>$property,
            'form'=>$form->createView()
        ]);
    }

    
    /**
     * @Route("admin/property/{id}", name="admin.property.edit",methods="GET|POST")
     */
    public function edit(Property $property,Request $request)
    {

        $form =  $this->createForm(PropertyType::class,$property);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $this->em->flush();
            $this->addFlash('success','Le bien a été édité');
            return $this->redirectToRoute('admin.property.index');
        }
        return $this->render("admin/property/edit.html.twig",[
            'property'=>$property,
            'form'=>$form->createView()
        ]);
    }

    /**
     * @Route("admin/property/{id}", name="admin.property.delete",methods="DELETE")
     */
    public function delete(Property $property,Request $request)
    {
        if($this->isCsrfTokenValid('delete'.$property->getId(),$request->get('_token'))){
            $this->em->remove($property);
            $this->em->flush();
            $this->addFlash('success','Le bien a été sumpprimé');
        }
        return $this->redirectToRoute('admin.property.index');
    }
   
}