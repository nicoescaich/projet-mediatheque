<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Product;
use App\Entity\Loan;
use App\Entity\Reader;
use App\Entity\Purchase;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\Request;

class HomeController extends AbstractController
{
    private $em;

    public function __construct(EntityManagerInterface $em) {
        $this->em = $em;
    }

    /**
     * @Route("/home", name="app_home")
     */
    public function index(ProductRepository $productRepository): Response
    {
        $loans = $productRepository->findBy(['status' => 'loan']);
         foreach($loans as $data){
           $loan = $this->em->getRepository(Loan::class)->findOneBy(['product' => $data]);
            $data->end_date = $loan->getEndDate()->format('d-m-Y');
        }

        $onStock = $productRepository->findBy(['status' => 'on-stock']);
        $products = array_merge($loans,$onStock);

        return $this->render('home/index.html.twig', [
            'products' => $products,
        ]);
    }

    /**
     * @Route("/description/{id}", name="description")
     */
    public function productDescription(Product $product, Request $request): Response
     {
        return $this->render('description/index.html.twig', [
            'product' => $product,
        ]);
     }

    /**
     * @Route("/show_category/{category}", name="show")
     */
    public function showCategory(Category $category, ProductRepository $productRepository): Response
     {
        return $this->render('show_category/index.html.twig', [
            'products' => $productRepository->findByCategory($category),
            'category' => $category
        ]);
     }

    /**
     * @Route("/loan/{id}", name="loan")
     */
    public function loan(Product $product, EntityManagerInterface $entityManager): Response
     {
        $reader = $this->em->getRepository(Reader::class)->findOneBy(['user'=>$this->getUser()]);
        $product->setStatus('loan');
        $entityManager->persist($product);

        $loan = new Loan;
        $loan->setProduct($product);
        $loan->setStartDate(new \DateTimeImmutable());
        $loan->setEndDate(new \DateTimeImmutable('+3 weeks'));
        $loan->setReader($reader);

        $entityManager->persist($loan);
        $entityManager->flush();

        return $this->redirectToRoute('app_home');

    }

     /**
     * @Route("/buy/{id}", name="buy")
     */
    public function buy(Product $product, EntityManagerInterface $entityManager): Response
    {
        $reader = $this->em->getRepository(Reader::class)->findOneBy(['user'=>$this->getUser()]);
        $buy = new Purchase;
        $buy->setProduct($product);
        $buy->setPurchaseDate(new \DateTimeImmutable());
        $buy->setTotal($product->getPrice());
        $buy->setReader($reader);
        $entityManager->persist($buy);

        $product->setStatus('buy');
        $entityManager->persist($product);
    
        $entityManager->flush();

            return $this->redirectToRoute('app_home');
    }
}