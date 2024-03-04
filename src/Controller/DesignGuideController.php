<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\CompanyRepository;

class DesignGuideController extends AbstractController
{
    #[Route('/design_guide', name: 'app_design_guide', methods: ['GET'])]
    public function index(CompanyRepository $companyRepository): Response
    {
        return $this->render('design_guide/index.html.twig', [
            'controller_name' => 'DesignGuideController',
            'companies' => $companyRepository->findAll(),
        ]);
    }
}
