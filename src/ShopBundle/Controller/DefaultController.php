<?php

namespace ShopBundle\Controller;

use ShopBundle\Entity\Feedback;
use ShopBundle\Entity\Orders;
use ShopBundle\Form\FeedBackType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $sections = $em->getRepository('ShopBundle:Sections')->findAll();
        return ['sections' => $sections];

    }

    /**
     * @Route("/contacts", name="contacts")
     * @Template()
     */
    public function contactsAction(Request $request){

        $em = $this->getDoctrine()->getManager();
        $feedback = new Feedback();

        $addForm = $this->createForm(FeedBackType::class,$feedback);
        $addForm->add('save',SubmitType::class, ['label' => 'Отправить', 'attr' => ['class' => 'btn btn-primary']]);

        if ('POST' === $request->getMethod()) {
            $addForm->handleRequest($request);
            if ($addForm->isValid()) {
                $feedback->setDate();
                $em->persist($feedback);
                $em->flush();
                return $this->redirect($this->generateUrl('contacts'));
            } else {
                throw $this->createNotFoundException('Form is not valid.');
            }
        }

        return  [
            'add_form' => $addForm->createView()
        ];
    }

    /**
     * @Route("/{code}.html", name="product")
     * @Template()
     */
    public function productAction($code){
        $em = $this->getDoctrine()->getManager();
        $product = $em->getRepository('ShopBundle:Products')->findOneBy(['code'=> $code]);

        return ['product' => $product];
    }

    /**
     * @param Request $request
     * @return array
     * @Route("/add-order", name="orderAdd")
     */
    public function addOrder(Request $request) {

        $em = $this->getDoctrine()->getManager();
        $order = new Orders();

        $content = $request->getContent();

        if (!empty($content))
        {
            $params = json_decode($content, true); // 2nd param to get as array

            $order->setName($params["name"]["\$viewValue"]);
            $order->setPhone($params["phone"]["\$viewValue"]);
            $order->setProduct($params["product"]["\$viewValue"]);

            $em->persist($order);
            $em->flush();
        }

        //dump($params["name"]["\$viewValue"]);

        $response = new JsonResponse();
        $response->setData(['add'=>'add']);

        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }

    /**
     * @Route("/sect-{code}", name="section")
     * @Template()
     */
    public function sectionAction($code){

        $em = $this->getDoctrine()->getManager();
        $section = $em->getRepository('ShopBundle:Sections')->findOneBy(['code'=> $code]);
        $products = $em->getRepository('ShopBundle:Products')->getSectionProducts($code);

        return ['section' => $section, 'products' => $products];
    }


    /**
     * @Template()
     */
    public function menuSectionsAction(){
        $em = $this->getDoctrine()->getManager();
        $sections = $em->getRepository('ShopBundle:Sections')->findAll();
        return ['sections' => $sections];
    }




}
