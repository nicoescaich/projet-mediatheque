<?php

namespace App\Controller;

use App\Entity\Product;
use App\Entity\Loan;
use App\Entity\Purchase;
use App\Form\ProductType;
use App\Repository\LoanRepository;
use App\Repository\ProductRepository;
use App\Repository\PurchaseRepository;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;


/**
 * @Route("/admin/product/crud")
 */
class ProductCrudController extends AbstractController
{
    /**
     * @Route("/", name="app_product_crud_index", methods={"GET"})
     */
    public function index(ProductRepository $productRepository): Response
    {
        // dd($productRepository->findAll());
        return $this->render('product_crud/index.html.twig', [
            'products' => $productRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="app_product_crud_new", methods={"GET", "POST"})
     */
    public function new(Request $request, ProductRepository $productRepository): Response
    {
        $product = new Product();
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $productRepository->add($product);
            $this->addFlash('success', 'Produit crée avec succès');

            return $this->redirectToRoute('app_product_crud_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('product_crud/new.html.twig', [
            'product' => $product,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_product_crud_show", methods={"GET"})
     */
    public function show(Product $product): Response
    {
        return $this->render('product_crud/show.html.twig', [
            'product' => $product,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_product_crud_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Product $product, ProductRepository $productRepository, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $productRepository->add($product);
            $loan =  $product->getLoan();
            $purchase =  $product->getPurchase();

            if ($loan != null) {
                $entityManager->remove($loan);
                $entityManager->flush();
            }
            if ($purchase != null) {
                $entityManager->remove($purchase);
                $entityManager->flush();
            }

           $this->addFlash('success', 'Produit modifié avec succès');

            return $this->redirectToRoute('app_product_crud_index', [], Response::HTTP_SEE_OTHER);
        }


        return $this->renderForm('product_crud/edit.html.twig', [
            'product' => $product,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_product_crud_delete", methods={"POST"})
     */
    public function delete(Request $request, Product $product, ProductRepository $productRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$product->getId(), $request->request->get('_token'))) {
            $productRepository->remove($product);
            $this->addFlash('success', 'Produit supprimé avec succès');

        }

        return $this->redirectToRoute('app_product_crud_index', [], Response::HTTP_SEE_OTHER);
    }
    /**
     * @Route("/back_in_stock/{id}", name="app_back_in_stock")
     */

     public function backInStock(Product $product, EntityManagerInterface $entityManager):Response
     {
        $product->setStatus('on-stock');
        $entityManager->persist($product);
        $date = new \Datetime();
        $loan = $entityManager->getRepository(Loan::class)->findOneBy(['product' => $product]);
        $loan->setRealEndDate($date);
        $entityManager->persist($loan);
        $entityManager->flush();

        return $this->redirectToRoute('app_loans', [], Response::HTTP_SEE_OTHER);

     }

}
