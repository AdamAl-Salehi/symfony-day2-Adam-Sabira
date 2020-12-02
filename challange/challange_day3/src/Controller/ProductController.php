<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\Form\Extension\Core\Type\TextType ;
use Symfony\Component\Form\Extension\Core\Type\TextareaType ;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use  Symfony\Component\Form\Extension\Core\Type\SubmitType;
use App\Entity\Product;

class ProductController extends AbstractController
{
   /**
    * @Route("/", name="home_page")
    */
    public function showAction()
    {
         // Here we will use getDoctrine to use doctrine and we will select the entity that we want to work with and we used findAll() to bring all the information from it and we will save it inside a variable named todos and the type of the result will be an array
        $products = $this->getDoctrine()->getRepository( 'App:Product')->findAll();
      
        return $this ->render('product/index.html.twig', array('products'=>$products));
 // we send the result (the variable that have the result of bringing all info from our database) to the index.html.twig page
    }
    /**
    * @Route("/create", name="create_page")
    */
    public function  createAction(Request $request)
   {
        // Here we create an object from the class that we made
       $product = new Product;
/* Here we will build a form using createFormBuilder and inside this function we will put our object and then we write add then we select the input type then an array to add an attribute that we want in our input field */
       $form = $this->createFormBuilder($product)->add( 'name', TextType::class, array ('attr' => array ('class'=> 'form-control' , 'style'=> 'margin-bottom:15px')))
       ->add( 'price', TextType::class, array ('attr' => array('class' => 'form-control' , 'style'=> 'margin-bottom:15px')))
       ->add( 'description', TextareaType::class, array( 'attr' => array( 'class'=> 'form-control' , 'style' => 'margin-bottom:15px' )))
       ->add( 'type' , ChoiceType::class, array ( 'choices' => array ( 'Digital' => 'Digital' , 'Film' => 'Film' , 'Instant' => 'Instant' ), 'attr'  => array ( 'class' => 'form-control' , 'style' => 'margin-botton:15px' )))
   ->add( 'image' , TextType::class, array ( 'attr'  => array ( 'class'=> 'form-control' , 'style' => 'margin-bottom:15px' )))
   ->add( 'save' , SubmitType::class, array ( 'label' => 'Create Todo' , 'attr'  => array ( 'class' => 'btn-primary' , 'style' => 'margin-bottom:15px' )))
       ->getForm();
       $form->handleRequest($request);
       

        /* Here we have an if statement, if we click submit and if  the form is valid we will take the values from the form and we will save them in the new variables */
        if ($form->isSubmitted() && $form->isValid()){
            //fetching data

            // taking the data from the inputs by the name of the inputs then getData() function
           $name = $form[ 'name' ]->getData();
           $price = $form[ 'price' ]->getData();
           $description = $form[ 'description' ]->getData();
           $type = $form[ 'type' ]->getData();
           $image = $form[ 'image' ]->getData();
           
            // Here we will get the current date
         

/* these functions we bring from our entities, every column have a set function and we put the value that we get from the form */
           $product->setName($name);
           $product->setPrice($price);
           $product->setDescription($description);
           $product->setType($type);
           $product->setImage($image);
           
           $em = $this ->getDoctrine()->getManager();
           $em->persist($product);
           $em->flush();
            $this ->addFlash(
                    'notice' ,
                    'Product Added'
                   );
            return   $this ->redirectToRoute( 'home_page' );
       }
/* now to make the form we will add this line form->createView() and now you can see the form in create.html.twig file  */
        return   $this ->render( 'product/create.html.twig' , array ( 'form'  => $form->createView()));
   }

    /**
    * @Route("/edit/{id}", name="edit_page")
    */
    public  function editAction( $id, Request $request)
   {
    $product = $this->getDoctrine()->getRepository('App:Product')->find($id);
    $product->setName($product->getName());
    $product->setPrice($product->getPrice());
    $product->setDescription($product->getDescription());
    $product->setType($product->getType());
    $product->setImage($product->getImage());
   
    /* Here we will build a form using createFormBuilder and inside this function we will put our object and then we write add then we select the input type then an array to add an attribute that we want in our input field */
           $form = $this->createFormBuilder($product)->add( 'name', TextType::class, array ('attr' => array ('class'=> 'form-control' , 'style'=> 'margin-bottom:15px')))
           ->add( 'price', TextType::class, array ('attr' => array('class' => 'form-control' , 'style'=> 'margin-bottom:15px')))
           ->add( 'description', TextareaType::class, array( 'attr' => array( 'class'=> 'form-control' , 'style' => 'margin-bottom:15px' )))
           ->add( 'type' , ChoiceType::class, array ( 'choices' => array ( 'Digital' => 'Digital' , 'Film' => 'Film' , 'Instant' => 'Instant' ), 'attr'  => array ( 'class' => 'form-control' , 'style' => 'margin-botton:15px' )))
       ->add( 'image' , TextType::class, array ( 'attr'  => array ( 'class'=> 'form-control' , 'style' => 'margin-bottom:15px' )))
       ->add( 'save' , SubmitType::class, array ( 'label' => 'Edit Product' , 'attr'  => array ( 'class' => 'btn-primary' , 'style' => 'margin-bottom:15px' )))
           ->getForm();
           $form->handleRequest($request);
           
    
            /* Here we have an if statement, if we click submit and if  the form is valid we will take the values from the form and we will save them in the new variables */
            if ($form->isSubmitted() && $form->isValid()){
                //fetching data
    
                // taking the data from the inputs by the name of the inputs then getData() function
               $name = $form[ 'name' ]->getData();
               $price = $form[ 'price' ]->getData();
               $description = $form[ 'description' ]->getData();
               $type = $form[ 'type' ]->getData();
               $image = $form[ 'image' ]->getData();
               
                // Here we will get the current date
             
    
    /* these functions we bring from our entities, every column have a set function and we put the value that we get from the form */
               $product->setName($name);
               $product->setPrice($price);
               $product->setDescription($description);
               $product->setType($type);
               $product->setImage($image);
               
               $em = $this ->getDoctrine()->getManager();
               $em->persist($product);
              
               $em->flush();
               $this->addFlash(
                       'notice',
                       'Product Updated'
                      );
               return $this ->redirectToRoute('home_page' );
          }
          return  $this->render( 'product/edit.html.twig', array( 'product' => $product, 'form' => $form->createView()));
      }

  
/**
    * @Route("/details/{id}", name="details_page")
    */
    public function  detailsAction($id)
    {
        $product = $this->getDoctrine()->getRepository( 'App:Product')->find($id);
        return $this->render( 'product/details.html.twig', array('product' => $product));
    }

    
    /**
    * @Route("/delete/{id}", name="todo_delete")
    */
    public function deleteAction($id){
        $em = $this->getDoctrine()->getManager();
   $product = $em->getRepository('App:Product')->find($id);
   $em->remove($product);
    $em->flush();
    $this->addFlash(
           'notice',
            'Product Removed'
           );
    return  $this->redirectToRoute('home_page');
}
}
