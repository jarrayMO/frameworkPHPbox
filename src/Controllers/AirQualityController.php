<?php

namespace App\Controllers;

use App\Models\AirQualityModel;
use Twig\Environment;

class AirQualityController
{
    private $twig;
    private $airQualityModel;

    public function __construct(Environment $twig, AirQualityModel $airQualityModel)
    {
        $this->twig = $twig;
        $this->airQualityModel = $airQualityModel;
    }

    public function index()
    {
        // Simuler la récupération des données de qualité de l'air pour une localité donnée

        $city = $_GET['city'] ?? 'paris';
        $date = $_GET['date'] ?? date('Y-m-d', strtotime('-1 day'));
        $airQualityData = $this->airQualityModel->getAirQualityData($city, $date);
        echo $this->twig->render('index.twig', 
        ['airQualityData' => $airQualityData,
        'city' => $city,
        'date' => $date 
    ]);
    }

}
