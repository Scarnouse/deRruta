<?php

namespace DrutaBundle\Controller;

use DrutaBundle\Entity\POI;
use DrutaBundle\Form\FormPOICreateBasic;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/user")
 */
class POIController extends Controller
{
    /**
     * @Route("/ajax/new_poi_form", name="ajax_new_poi")
     *
     */
    public function ajaxNewPOIAction(Request $request)
    {
        $session = $request->getSession();
        $routeId = $session->get('route_id');

        if(! $request->isXmlHttpRequest())
        {
            throw new NotFoundHttpException();
        }

        $latitude = $request->query->get('lat');
        $longitude = $request->query->get('lon');

        $poi = new POI();
        $poi->setLatitude($latitude);
        $poi->setLongitude($longitude);

        $form = $this->createForm(new FormPOICreateBasic($routeId), $poi);

        $html = $this->renderView('@Druta/POI/poi_form.html.twig',
            array(
                'form'=> $form->createView()
            )
        );

        $response = new JsonResponse(
            array(
                'html' => $html,
                'latitude' => $latitude,
                'longitude' => $longitude
            ), 200);
        return $response;
    }

    /**
     * @Route("/create_poi", name="create_poi")
     */
    public function createPOIAction(Request $request)
    {
        $request = $this->get('request');
        $routeId = $request->getSession()->get("route_id");

        if ($request->request->has('save')) {
            $poiModel = $this->get('druta.model.poi_model');

            $poi = new POI();

            $routeModel = $this->get('druta.model.route_model');
            $route = $routeModel->findById($routeId);

            $poi->setRoute($route);

            $form = $this->createForm(new FormPOICreateBasic($routeId), $poi);
            $form->handleRequest($request);

            $latitude = $poi->getLatitude();
            $longitude = $poi->getLongitude();
            $repeatedPOI = $poiModel->findByRouteAndLatitudeAndLongitude($route, $latitude, $longitude);

            if ($form->isValid() && !$repeatedPOI) {
                $poiModel->add($poi);
                $poiModel->applyChanges();

                $response = $this->forward('DrutaBundle:Route:routeDetail',
                     array(
                        'id' => $routeId
                     )
                );

                return $response;
            } elseif($repeatedPOI){
                $this->addFlash(
                    'notice',
                    'Coordenadas de POI repetidas'
                );
                $response = $this->forward('DrutaBundle:Route:routeDetail',
                    array(
                        'id' => $routeId
                    )
                );

                return $response;
            }
            else {
                $this->addFlash(
                    'notice',
                    'Datos introducidos no validos'
                );
                $response = $this->forward('DrutaBundle:Route:routeDetail',
                    array(
                        'id' => $routeId
                    )
                );

                return $response;
            }

        }
    }
}