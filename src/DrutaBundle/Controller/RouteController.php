<?php

namespace DrutaBundle\Controller;

use DrutaBundle\Form\FormRouteCreateBasic;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use DrutaBundle\Entity\Route as NewRoute;

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
                'site' => "Mis Rutas",
                'own_route' => true
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
                'site' => "Otras Rutas",
                'own_route' => false
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

        $ownRoute = false;
        if($route->getUser() == $user)
        {
            $ownRoute = true;
        }

        $poiModel = $this->get('druta.model.poi_model');
        $pois = $poiModel->findByRoute($route);

        $session = $request->getSession();
        $session->set('route_id', $route->getId());

        return $this->render('@Druta/Route/route_detail.html.twig',
            array(
                'user' => $user,
                'pois' => $pois,
                'site' => $route->getName(),
                'own_route' => $ownRoute
            )
        );
    }

    /**
     * @Route("/create_route/", name="create_route")
     */
    public function createRouteAction(Request $request)
    {
        $user = $this->getUser();

        $route = new NewRoute();

        $formBasic = $this->createForm(new FormRouteCreateBasic(), $route);
        $formBasic->handleRequest($request);

        return $this->render('@Druta/Route/route_form.html.twig',
            array(
                'formBasic' => $formBasic->createView(),
                'user' => $user,
                'site' => 'Crear Ruta'
            )
        );
    }

    /**
     * @Route("/save_route/", name="save_route")
     */
    public function saveRouteAction(Request $request)
    {
        if($request->request->has('save')) {
            $user = $this->getUser();

            $routeModel = $this->get('druta.model.route_model');

            $route = new NewRoute();
            $route->setUser($user);

            $form = $this->createForm(new FormRouteCreateBasic(), $route);
            $form->handleRequest($request);

            if ($form->isValid()) {
                $fileUploaderModel = $this->get('druta.model.file_uploader');
                $fileName = $fileUploaderModel->uploadFile($route);
                $route->setFilenameImage($fileName);

                $routeModel->add($route);
                $routeModel->applyChanges();

                $response = $this->forward('DrutaBundle:Route:myRoutes');

                return $response;
            } else {
                $this->addFlash(
                    'notice',
                    'Datos introducidos no validos'
                );

                $response = $this->forward('DrutaBundle:Route:myRoutes');

                return $response;
            }
        }
    }
}