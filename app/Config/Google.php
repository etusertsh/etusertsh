<?php
namespace Config;

use CodeIgniter\Config\BaseConfig;

class Google extends BaseConfig
{
    public $clientId = '900229141234-17hhs55j55dhu0oidqnbvbu8ok8ngb4h.apps.googleusercontent.com'; //add your client id
    public $clientSecret = 'g0Dcrl4k4zCpGiIB6XJuIZEW'; //add your client secret
    public $redirectUri = 'https://etuser.hopto.org/mst_tour/auth/oauth2callback'; //add your redirect uri
    public $apiKey = ''; //add your api key here
    public $applicationName ='MST Tour'; //application name for the api
}
