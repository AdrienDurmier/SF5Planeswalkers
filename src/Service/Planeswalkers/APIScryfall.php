<?php

namespace App\Service\Planeswalkers;

use Symfony\Component\Security\Core\Security;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\Routing\RouterInterface;
use Doctrine\ORM\EntityManagerInterface;
use Unirest;

class APIScryfall
{
    private $user;
    private $params;
    private $em;
    private $router;

    /**
     * APIHeidi constructor.
     * @param Security $security
     * @param ParameterBagInterface $params
     * @param EntityManagerInterface $em
     * @param RouterInterface $router
     */
    public function __construct(Security $security, ParameterBagInterface $params, EntityManagerInterface $em, RouterInterface $router)
    {
        $this->user = $security->getUser();
        $this->params = $params;
        $this->em = $em;
        $this->router = $router;
    }

    /**
     * Service permettant de simplifier la communication avec l'API Scryfall
     *
     * @param string $methode : get, post, put ou delete
     * @param string $uri : fin de l'url absolue
     * @param array $parametres : contenu de la reqûete
     * @return mixed
     * @throws Unirest\Exception
     */
    public function interroger($methode = 'get', $uri = '', $parametres = array())
    {
        Unirest\Request::verifyPeer(false); // TODO Disables SSL cert validation temporary

        $base_url_api = $this->params->get('url_api_scryfall');
        $headers = array('Content-type' => 'application/json');
        $body = Unirest\Request\Body::json([]);
        $response = Unirest\Request::$methode($base_url_api . $uri, $headers, $body);

        return $response;
    }


}