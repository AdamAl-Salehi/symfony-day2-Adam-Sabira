<?php

namespace App\Controller;
use App\Entity\Destination;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TestController extends AbstractController
{
    /**
     * @Route("/", name="test")
     */
    public function index(): Response
    {
        return $this->render('test/index.html.twig', [
            'controller_name' => 'TestController',
        ]);
    }
    /**
     * @Route("/about", name="about")
     */
    public function about(): Response
    {
        return $this->render('test/about.html.twig', [
            'controller_name' => 'TestController',
        ]);
    }
    /**
     * @Route("/news", name="news")
     */
    public function news(): Response
    {
        return $this->render('test/news.html.twig', [
            'controller_name' => 'TestController',
        ]);
    }
    /**
     * @Route("/contact", name="contact")
     */
    public function contact(): Response
    {
        return $this->render('test/contact.html.twig', [
            'controller_name' => 'TestController',
        ]);
    }
     /**
    * @Route("/create", name="createAction")
    */
   public function createAction()
   {  
       
        // you can fetch the EntityManager via $this->getDoctrine()
       // or you can add an argument to your action: createAction(EntityManagerInterface $em)
       $em = $this->getDoctrine()->getManager();
       $destination = new  Destination(); // here we will create an object from our class destination.
       $destination->setName( 'Paris'); // in our destination class we have a set function for each column in our db
       $destination->setPrice( 500);
       $destination->setDate( '01-12-2020');

       // tells Doctrine you want to (eventually) save the destination (no queries yet)
       $em->persist($destination);
        // actually executes the queries (i.e. the INSERT query)
       $em->flush();
       return  new Response('Saved new destination with id '.$destination->getId());
   }

       /**
    * @Route("/details/{destinationId}", name="detailsAction")
    */ 
    public function showdetailsAction($destinationId)
    {
        $destination = $this->getDoctrine()
            ->getRepository(Destination::class)
            ->find($destinationId);
            return $this->render('test/index.html.twig', array("destination"=>$destination));
         if (!$destination) {
            throw  $this->createNotFoundException(
                 'No product found for id '.$destinationId
            );
        } else {
                 return new Response('Details from the destination with id ' .$destinationId.",Destination name is ".$destination->getName()." and it cost " .$destination->getPrice()."€" );
        }
      
    }
          /**
    * @Route("/home", name="indexAction")
    */ 
    public  function indexAction()
    {
        $destination = $this->getDoctrine()
            ->getRepository(Destination::class)
            ->findAll(); // this variable $products will store the result of running a query to find all the products
         return $this->render('test/about.html.twig', array("destination"=>$destination)); // i send the variable that have all the products as an array of objects to the index.html.twig page
    }

}
