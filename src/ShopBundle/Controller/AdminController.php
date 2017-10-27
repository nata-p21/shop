<?php
namespace ShopBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;

use ShopBundle\Form\ProductsType;
use ShopBundle\Form\SectionsType;

use ShopBundle\Entity\Sections;
use ShopBundle\Entity\Products;
use ShopBundle\Service\FileUploader;

/**
 * Class DefaultController
 * @package ShopBundle\Controller
 * @Route("/admin")
 */
class AdminController extends Controller
{
    /**
     * @Route("/")
     */
    public function indexAction()
    {
        return $this->render('ShopBundle:Admin:index.html.twig');
    }

    /**
     * @Route("/sections", name="sectionsAdmin")
     * @Template()
     */
    public function sectionsAction(){
        $em = $this->getDoctrine()->getManager();
        $sections = $em->getRepository('ShopBundle:Sections')->findAll();

        return ['sections' => $sections];
    }

    /**
     * @Route("/sections/add", name="sectionAdd")
     * @Template()
     */
    public function sectionAddAction(Request $request){
        $em = $this->getDoctrine()->getManager();
        $section = new Sections();

        $addForm = $this->createForm(SectionsType::class, $section);
        $addForm->add('save',SubmitType::class, ['label' => 'Сохранить', 'attr' => ['class' => 'btn btn-primary']]);

        if ('POST' === $request->getMethod()) {
            $addForm->handleRequest($request);
            if ($addForm->isValid()) {

                $fileUploader = new FileUploader($this->getParameter('images_directory_full'), $this->getParameter('images_directory'));
                $picture = $section->getPicture();
                // Generate a unique name for the file before saving it
                $fileName = $fileUploader->upload($picture);
                $section->setPicture($fileName);

                $em->persist($section);
                $em->flush();
                return $this->redirect($this->generateUrl('sectionsAdmin'));
            } else {
                throw $this->createNotFoundException('Form is not valid.');
            }
        }
        return array("add_form" => $addForm->createView());
    }

    /**
     * @Route("sections/edit/{id}", name="sectionEdit")
     */
    public function sectionEditAction(Request $request, $id){

        $em = $this->getDoctrine()->getManager();
        $section = $em->getRepository('ShopBundle:Sections')->findOneBy(['id' => $id]);

        $addForm = $this->createForm(SectionsType::class, $section);
        $addForm->add('save',SubmitType::class, ['label' => 'Сохранить', 'attr' => ['class' => 'btn btn-primary']]);

        if ('POST' === $request->getMethod()) {
            $addForm->handleRequest($request);
            if ($addForm->isValid()) {

                $fileUploader = new FileUploader($this->getParameter('images_directory_full'), $this->getParameter('images_directory'));
                $picture = $section->getPicture();
                // Generate a unique name for the file before saving it
                $fileName = $fileUploader->upload($picture);
                $section->setPicture($fileName);

                $em->persist($section);
                $em->flush();
                return $this->redirect($this->generateUrl('sectionsAdmin'));
            } else {
                throw $this->createNotFoundException('Form is not valid.');
            }
        }

        return $this->render('@Shop/Admin/sectionAdd.html.twig', [
            'add_form' => $addForm->createView()
        ]);
    }

    /**
     * @Route("/products", name="productsAdmin")
     * @Template()
     */
    public function productsAction(){
        $em = $this->getDoctrine()->getManager();

        $products = $em->getRepository('ShopBundle:Products')->findAll();

        return ['products' => $products];

     }

    /**
     * @Route("/products/add", name="productAdd")
     * @Template()
     */
    public function productAddAction(Request $request){

        $em = $this->getDoctrine()->getManager();
        $product = new Products();

        $addForm = $this->createForm(ProductsType::class, $product);
        $addForm->add('save',SubmitType::class, ['label' => 'Сохранить', 'attr' => ['class' => 'btn btn-primary']]);

        if ('POST' === $request->getMethod()) {
            $addForm->handleRequest($request);
            if ($addForm->isValid()) {
                $fileUploader = new FileUploader($this->getParameter('images_directory_full'), $this->getParameter('images_directory'));
                $picture = $product->getPicture();
                // Generate a unique name for the file before saving it
                $fileName = $fileUploader->upload($picture);
                $product->setPicture($fileName);
                $em->persist($product);
                $em->flush();
                return $this->redirect($this->generateUrl('productsAdmin'));
            } else {
                throw $this->createNotFoundException('Form is not valid.');
            }
        }
        return array("add_form" => $addForm->createView());

     }

    /**
     * @Route("products/edit/{id}", name="productEdit")
     */
    public function productEditAction(Request $request, $id){

        $em = $this->getDoctrine()->getManager();
        $product = $em->getRepository('ShopBundle:Products')->findOneBy(['id' => $id]);

        $addForm = $this->createForm(ProductsType::class, $product);
        $addForm->add('save',SubmitType::class, ['label' => 'Сохранить', 'attr' => ['class' => 'btn btn-primary']]);

        if ('POST' === $request->getMethod()) {
            $addForm->handleRequest($request);
            if ($addForm->isValid()) {
                $fileUploader = new FileUploader($this->getParameter('images_directory_full'), $this->getParameter('images_directory'));
                $picture = $product->getPicture();
                // Generate a unique name for the file before saving it
                $fileName = $fileUploader->upload($picture);
                $product->setPicture($fileName);
                $em->persist($product);
                $em->flush();
                return $this->redirect($this->generateUrl('productsAdmin'));
            } else {
                throw $this->createNotFoundException('Form is not valid.');
            }
        }

        return $this->render('@Shop/Admin/productAdd.html.twig', [
            'add_form' => $addForm->createView()
        ]);
    }

    /**
     * @Route("/feedback", name="feedbackAdmin")
     * @Template()
     */
    public function feedbackAction(){

        $em = $this->getDoctrine()->getManager();
        $feedback = $em->getRepository('ShopBundle:Feedback')->findAll();

        return ['feedback' => $feedback];

    }


    /**
     * @return array
     * @Route("/orders", name="ordersAdmin")
     * @Template()
     */
    public function ordersAction() {

        $em = $this->getDoctrine()->getManager();
        $orders = $em->getRepository('ShopBundle:Orders')->findAll();

        return ['orders' => $orders];

    }

}