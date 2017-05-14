<?php

namespace ApiBundle\Controller;


use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations\Route;
use FOS\RestBundle\Util\Codes;
use FOS\RestBundle\View\View;
use JMS\Serializer\SerializationContext;
use Symfony\Component\HttpFoundation\Request;


/**
 * @Route("/api/v1")
 */
class POIController extends FOSRestController
{
    /**
     * @Rest\Get("/user/pois_by_route/{id}")
     */
    public function routeAction(Request $request)
    {
        $idRoute = $request->get('id');

        $routeModel = $this->get('druta.model.route_model');
        $route = $routeModel->findById($idRoute);

        if(count($route) == 0)
        {
            $view = View::create(array(
                'error' => Codes::HTTP_BAD_REQUEST,
                "message" => 'La ruta solicitada no existe'
            ),Codes::HTTP_BAD_REQUEST);
            return $this->handleView($view);
        }

        $poiModel = $this->get('druta.model.poi_model');
        $pois = $poiModel->findByRoute($route);

        if(count($pois) == 0)
        {
            $view = View::create(array(
                'error' => Codes::HTTP_BAD_REQUEST,
                "message" => 'La ruta aún no contiene pois'
            ),Codes::HTTP_BAD_REQUEST);
            return $this->handleView($view);
        } else {
            $view = View::create("POIs por ruta");
            $serializationContext = SerializationContext::create()->enableMaxDepthChecks();
            $serializationContext->setGroups('pois');
            $view->setData($pois)
                ->setStatusCode(Codes::HTTP_OK)
                ->setSerializationContext($serializationContext);

            return $view;
        }
    }
}