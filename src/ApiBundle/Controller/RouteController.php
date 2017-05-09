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
class RouteController extends FOSRestController
{
    /**
     * @Rest\Get("/user/routes")
     */
    public function routesListAction(Request $request)
    {
        $routeModel = $this->get('druta.model.route_model');
        $routes = $routeModel->findAll();

        $view = View::create("Lista completa de rutas");
        $serializationContext = SerializationContext::create()->enableMaxDepthChecks();
        $serializationContext->setGroups('routes');
        $view->setData($routes)
            ->setStatusCode(Codes::HTTP_OK)
            ->setSerializationContext($serializationContext);

        return $view;
    }

    /**
     * @Rest\Get("/user/routes_by_user/{id}")
     */
    public function routeAction(Request $request)
    {
        $idUser = $request->get('id');

        $userModel = $this->get('druta.model.user_model');
        $user = $userModel->findById($idUser);

        if(count($user) == 0)
        {
            $view = View::create(array(
                'error' => Codes::HTTP_BAD_REQUEST,
                "message" => 'El usuario solicitado no existe'
            ),Codes::HTTP_BAD_REQUEST);
            return $this->handleView($view);
        }

        $routeModel = $this->get('druta.model.route_model');
        $routes = $routeModel->findByUser($user);

        if(count($routes) == 0)
        {
            $view = View::create(array(
                'error' => Codes::HTTP_BAD_REQUEST,
                "message" => 'No se encontraron rutas asociadas al usuario'
            ),Codes::HTTP_BAD_REQUEST);
            return $this->handleView($view);
        } else {
            $view = View::create("Ruta por Usuario");
            $serializationContext = SerializationContext::create()->enableMaxDepthChecks();
            $serializationContext->setGroups('route_by_user');
            $view->setData($routes)
                ->setStatusCode(Codes::HTTP_OK)
                ->setSerializationContext($serializationContext);

            return $view;
        }
    }
}