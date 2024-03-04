<?php

namespace App\Controller;

use Symfony\UX\Chartjs\Builder\ChartBuilderInterface;
use Symfony\UX\Chartjs\Model\Chart;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ChartController extends AbstractController
{
    #[Route('/chart', name: 'app_chart')]
    public function index(ChartBuilderInterface $chartBuilder): Response
    {
        $chart = $chartBuilder->createChart(Chart::TYPE_LINE);
        $chart->setData([
            'labels' => ['Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre'],
            'datasets' => [
                [
                    'label' => 'Graphique du projet',
                    'backgroundColor' => 'rgb(255, 99, 132)',
                    'borderColor' => 'rgb(255, 99, 132)',
                    'data' => [0, 10, 5, 2, 20, 30, 45, 48, 52, 60, 72, 75],
                ],
            ],
        ]);

        $chart->setOptions([
            'scales' => [
                'x' => [
                    'ticks' => [
                        'color' => '#FFFFFF', // Définit la couleur des labels de l'axe X en blanc
                    ],
                    'grid' => [
                        'color' => 'rgba(255, 255, 255, 0.1)', // Optionnel: couleur des lignes de grille (avec transparence)
                    ]
                ],
                'y' => [
                    'ticks' => [
                        'color' => '#FFFFFF', // Définit la couleur des labels de l'axe Y en blanc
                    ],
                    'grid' => [
                        'color' => 'rgba(255, 255, 255, 0.1)', // Optionnel: couleur des lignes de grille (avec transparence)
                    ]
                ],
            ],
            'plugins' => [
                'legend' => [
                    'labels' => [
                        'color' => '#FFFFFF', // Définit la couleur des labels de la légende en blanc
                    ],
                ],
            ],
        ]);

        return $this->render('chart/index.html.twig', [
            'chart' => $chart,
        ]);
    }
}
