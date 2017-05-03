<?php

namespace DrutaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use DrutaBundle\Util\DoctrineHelp;

/**
 * @Route("/user")
 */
class RouteController extends Controller
{
    /**
     * @Route("/my_routes/", name="my_routes")
     */
    public function myRoutesAction(Request $request)
    {
        $user = $this->getUser();

        $routeModel = $this->get('druta.model.route_model');
        $routes = $routeModel->findByUser($user);

        return $this->render('@Druta/Route/my_routes.html.twig',
            array(
                'user' => $user,
                'routes' => $routes,
                'site' => "Mis Rutas"
            )
        );
    }

    /**
     * @Route("/routes", name="routes")
     */
    public function routesAction(Request $request){
        $user = $this->getUser();

        $routeModel = $this->get('druta.model.route_model');
        $routes = $routeModel->findAll();
        $userRoutes = $routeModel->findByUser($user);

        $routes = array_diff($routes, $userRoutes);

        return $this->render('@Druta/Route/my_routes.html.twig',
            array(
                'user' => $user,
                'routes' => $routes,
                'site' => "Rutas"
            )
        );
    }

    /**
     * @Route("/route_detail/{id}", name="route_detail")
     */
    public function routeDetailAction(Request $request, $id){
        $user = $this->getUser();

        $routeModel = $this->get('druta.model.route_model');
        $route = $routeModel->findById($id);

        $route = $route[0];

        $poiModel = $this->get('druta.model.poi_model');
        $pois = $poiModel->findByRoute($route);

        return $this->render('@Druta/Route/route_detail.html.twig',
            array(
                'user' => $user,
                'pois' => $pois,
                'site' => $route->getName()
            )
        );
    }
}