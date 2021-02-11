<?php

namespace App\Service;

use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;
use Exception;
use Unirest;


class ApiAnonyme
{
    const API_HEIDI = "HEIDI";

    private $params;
    private $session;
    private $url_api_heidi;

    /**
     * Api constructor.
     * @param ParameterBagInterface $params
     * @param SessionInterface $session
     */
    public function __construct(ParameterBagInterface $params, SessionInterface $session)
    {
        $this->params = $params;
        $this->session = $session;
        $this->url_api_heidi = $this->params->get('url_api_heidi');
    }

    /**
     * @param string $api
     * @return string
     */
    private function choixApi(string $api) : string
    {
        switch ($api){
            case self::API_HEIDI :
                return $this->url_api_heidi;
        }
        return "";
    }

    /**
     * Service permettant de simplifier la communication avec l'API
     *
     * @param string $api
     * @param string $methode : get, post, put ou delete
     * @param string $uri : fin de l'url absolue
     * @param array $parametres : contenu de la reqûete
     * @param array $options
     * @return mixed
     * @throws Exception
     */
    public function interrogerAnonyme(string $api ,$methode = 'get', $uri = '', $parametres = array(), array $options = null)
    {
        $url = $this->choixApi($api);
        $url = str_replace('api/', 'anonyme/', $url);
        Unirest\Request::verifyPeer(false);
		Unirest\Request::timeout(10); // Déclenche une erreur 408 si l'utilisateur attends plus de 10sec
        $headers = array('Content-type' => 'application/json');
		try {
            $body = Unirest\Request\Body::form(json_encode($parametres));
			//$url = "http://exemple.com:81/"; // Simule un Timeout
            $response = Unirest\Request::$methode($url . $uri, $headers, $body);
        }catch (Unirest\Exception $exception){
            throw new HttpException(408, "L'API $api a mis trop de temps à répondre.");
        }
        switch ($response->code) {
            case Response::HTTP_OK: // 200
            case Response::HTTP_CREATED: // 201 : Création d'un contenu
            case Response::HTTP_NO_CONTENT: // 204 : Requête ok mais sans contenu.
                if(isset($response->body->message)){
                    $flashbag = $this->session->getFlashBag();
                    $flashbag->add('success', $response->body->message);
                }
                if(Response::HTTP_OK){
                    return $response->body;
                }
                break;
            case Response::HTTP_UNAUTHORIZED: // 401
                if (isset($options['gestion401auto']) && $options['gestion401auto'] == false){
                    return $response;
                }
                throw new CustomUserMessageAuthenticationException("Identifiants invalides");
            case Response::HTTP_FORBIDDEN: // 403
                throw new AccessDeniedException($response->body);
            case Response::HTTP_NOT_FOUND: // 404
                throw new NotFoundHttpException("Contenu non trouvé ou inexistant.");
            case Response::HTTP_NOT_ACCEPTABLE: // 406
                $flashbag = $this->session->getFlashBag();
                $flashbag->add('warning', $response->body->message);
                return $response->body;
            case Response::HTTP_INTERNAL_SERVER_ERROR: // 500
                if ($this->params->get('app_env') == "dev"){
                    die($response->body);
                }
                throw new Exception("Erreur de communication avec l'API $api.");
        }
        return $response;
    }
}