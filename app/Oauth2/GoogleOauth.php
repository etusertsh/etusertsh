<?php 

/*
 * Login with Google for Codeigniter
 *
 * Library for Codeigniter to authenticate users through Google OAuth 2.0 and get user profile info
 *
 * @authors     Harsha G, Nick Humphries
 * @license     MIT
 * @link        https://github.com/angel-of-death/Codeigniter-Google-OAuth-Login
 */
namespace App\Oauth2;

use Google\Client as Google_Client;
use Google_Service_Oauth2; 

class GoogleOauth
{
	protected $client;
	protected $session;
	private $loggedIn;
	public function __construct()
	{
		//include_once('vendor/autoload.php');

		$config = new \Config\Google();	 	
        $this->client = new \Google_Client();
		$this->session = \Config\Services::session();
        $this->client->setClientId($config->clientId); //Define your ClientID

        $this->client->setClientSecret($config->clientSecret); //Define your Client Secret Key
        $this->client->setRedirectUri($config->redirectUri); //Define your Redirect Uri
        $this->client->addScope([Google_Service_Oauth2::USERINFO_EMAIL, Google_Service_Oauth2::USERINFO_PROFILE,]);
		$this->client->setAccessType('offline');		
        $this->client->setApplicationName($config->applicationName);		
       
		if($this->session->get('refreshToken')!=null)
		{
			$this->loggedIn = true;

			if($this->client->isAccessTokenExpired())
			{
				$this->client->refreshToken($this->session->get('refreshToken'));
        		
        		$accessToken = $this->client->getAccessToken();

        		$this->client->setAccessToken($accessToken);
			}
		}
		else
		{
			$accessToken = $this->client->getAccessToken();

			if($accessToken!=null)
			{
				$this->client->revokeToken($accessToken);
			}

			$this->loggedIn = false;
		}
	}

	public function isLoggedIn()
	{
		return $this->loggedIn;
	}

	public function getLoginUrl()
	{
		return $this->client->createAuthUrl();
	}

	public function setAccessToken()
	{
		//$session = \Config\Services::session();
		//$this->client->authenticate($_GET['code']);

		//$accessToken = $this->client->getAccessToken();
		$accessToken = $this->client->fetchAccessTokenWithAuthCode($_GET['code']);

		$this->client->setAccessToken($accessToken);

		if(isset($accessToken['refresh_token']))
		{
			$this->session->set('refreshToken', $accessToken['refresh_token']);
		}
	}

	public function getUserInfo()
	{
		$service = new Google_Service_Oauth2($this->client);

		return $service->userinfo->get();
	}

	public function logout()
	{
		//$session = \Config\Services::session();
		$this->session->remove('refreshToken');

		$accessToken = $this->client->getAccessToken();

		if($accessToken!=null)
		{
			$this->client->revokeToken($accessToken);
		}
	}
}

?>