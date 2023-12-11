<?php

namespace App\Models;

use App\Config\ConfigReader;
use GuzzleHttp\Client;

class AirQualityModel
{
    private $apiKey;
    private $httpClient;
    private $apiURL;
    public function __construct(Client $httpClient)
    {
        $this->apiKey = ConfigReader::getConfig('API_KEY');
        $this->apiURL = ConfigReader::getConfig('URL_AIR_QUALITY');
        $this->httpClient = $httpClient;
    }

    public function getAirQualityData($city='paris', $date)
    {
        
              $coordinates=$this->getCoordinatesByCity($city);
              $url = $this->apiURL.'key='.$this->apiKey; 
              $data = [
                  "period" => [
                      "startTime" => $date."T00:00:00Z",
                      "endTime" => $date."T23:00:00Z"
                  ],
                  "pageToken" => "",
                  "location" => [
                      "latitude" => $coordinates['latitude'],
                      "longitude" => $coordinates['longitude']
                  ]
              ];
              try {
                $response = $this->httpClient->request('POST', $url, ['json' => $data]);
                $responseData = json_decode($response->getBody(), true);
                return $responseData['hoursInfo'];
            } catch (\Exception $e) {
                // Gérer les erreurs ou l'exception ici
                return ['error' => $e->getMessage()];
            }
    }
    
    

    /**
     * Get the value of apiKey
     */ 
    public function getApiKey()
    {
        return $this->apiKey;
    }

    /**
     * Set the value of apiKey
     *
     * @return  self
     */ 
    public function setApiKey($apiKey)
    {
        $this->apiKey = $apiKey;

        return $this;
    }


    public function getCoordinatesByCity($city)
{
    $coordinates = ['latitude' => '', 'longitude' => ''];

    switch ($city) {
        case 'paris':
            $coordinates['latitude'] = 48.8566; // Latitude de Paris
            $coordinates['longitude'] = 2.3522; // Longitude de Paris
            break;
        case 'nice':
            $coordinates['latitude'] = 43.7102; // Latitude de Nice
            $coordinates['longitude'] = 7.2620; // Longitude de Nice
            break;
        // Ajouter d'autres cas pour d'autres villes si nécessaire
        default:
            // Définir des valeurs par défaut si la ville n'est pas trouvée
            $coordinates['latitude'] = '';
            $coordinates['longitude'] = '';
            break;
    }

    return $coordinates;
}

}
