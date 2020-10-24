<?php

namespace App\Controller;

use App\Entity\Order;
use App\Form\OrderType;
use App\Repository\OrderProductRepository;
use App\Repository\OrderProductRepositoryOLD;
use App\Repository\OrderRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Exception\NotEncodableValueException;

class HomeController extends AbstractController
{
    
    /**
     * @var EntityManagerInterface
     */
    private $em;
    /**
     * @var OrderProductRepository
     */
    private $repository;

    public function __construct(OrderProductRepository $orderProductRepository, EntityManagerInterface $manager)
    {
        $this->repository = $orderProductRepository;
        $this->em = $manager;
    }
    /**
     * @Route("/", name="home")
     */
    public function index() : Response
    {
        $orders = $this->repository->findAllorder();
        if (!$orders) {
            throw $this->createNotFoundException('No data found');
        }
        return $this->render('home/index.html.twig', [
            'orders' => $orders,
        ]);
    }

    /**
     * @Route("/order/{id}/show", name="show")
     * @param Order $order
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function show(Order $order) : Response
    {
        $orderOne = $this->repository->findOneOrder($order);
        if (!$orderOne) {
            throw $this->createNotFoundException('No data found');
        }
        return $this->render("/home/show.html.twig", [
            'order' => $orderOne
        ]);
    }

    /**
     * @Route("/order/{id}/edit1", name="edit")
     * @param Order $order
     */
    public function edit(Request $request, Order $order)
    {
        $form = $this->createForm(OrderType::class, $order);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $this->em->persist($data);
            $this->em->flush();
            return $this->redirectToRoute('home');
        }
        return $this->render("/home/edit.html.twig", [
                'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/order/add", name="add")
     * @param Request $request
     * @param Order $order
     * @return Response
     */
    public function add(Request $request)
    {
        $order = new Order();
        $form = $this->createForm(OrderType::class);

        $product = $request->request->get('order');
        //dd($product['products']);
     ///   $order->setProducts((object)$product['products']);
        $form->handleRequest($request);
        //dd($request);
        if ($form->isSubmitted() && $form->isValid()) {
//            $data = $form->getData();
//            dd($data);
            $this->em->persist($order);
            $this->em->flush();
            return $this->redirectToRoute('home');
        }
        return $this->render("/home/add.html.twig", [
            'form' => $form->createView()
        ]);
    }
}
