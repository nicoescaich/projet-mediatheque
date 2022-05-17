<?php

namespace App\Controller;

use App\Repository\LoanRepository;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;


/**
 * @Route("/admin/loans")
 */
class LoansController extends AbstractController
{
 

     /**
     * @Route("/", name="app_loans")
     */
      public function loanList(LoanRepository $lr, ProductRepository $productRepository, EntityManagerInterface $entityManager)
     {
        $loans = $lr->findAll();
        foreach($loans as $data){
           $data->start_date_string = $data->getStartDate()->format('d-m-Y');
          $data->end_date_string = $data->getEndDate()->format('d-m-Y');

          if($data->getRealEndDate()) {
            $data->real_end_date_string  = $data->getRealEndDate()->format('d-m-Y');
          } else {
            $data->real_end_date_string = 'No Date Defined';
          }   

       }
        return $this->render('loans_admin/index.html.twig', [
            'loans' => $loans,
            'day_date' => new \DateTimeImmutable()
        ]);
     }

}
