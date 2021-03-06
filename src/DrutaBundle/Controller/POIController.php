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

        $poiId = $request->get('poiCreateFormBasic')['id'];

        if ($request->request->has('save')) {

            $poiModel = $this->get('druta.model.poi_model');
            $routeModel = $this->get('druta.model.route_model');

            if(!empty($poiId))
            {
                $poi = $poiModel->findById($poiId);

                $form = $this->createForm(new FormPOICreateBasic($routeId), $poi);
                $form->handleRequest($request);

                if($form->isValid())
                {
                    $poiModel->update($poi);
                    $poiModel->applyChanges();

                    $response = $this->forward('DrutaBundle:Route:routeDetail',
                        array(
                            'id' => $routeId
                        )
                    );

                    return $response;
                }
            }

            $poi = new POI();

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

    /**
     * @Route("ajax/edit_poi_form", name="ajax_edit_poi")
     */
    function editPOIAction(Request $request)
    {

        $session = $request->getSession();
        $routeId = $session->get('route_id');

        if(! $request->isXmlHttpRequest())
        {
            throw new NotFoundHttpException();
        }

        $poiId = $request->query->get('id');

        $poiModel = $this->get('druta.model.poi_model');
        $poi = $poiModel->findById($poiId);


        $form = $this->createForm(new FormPOICreateBasic($routeId), $poi);

        $html = $this->renderView('@Druta/POI/poi_form.html.twig',
            array(
                'form'=> $form->createView()
            )
        );

        $response = new JsonResponse(
            array(
                'html' => $html,
            ), 200);
        return $response;
    }

    /**
     * @Route("ajax/poi_delete/", name="ajax_delete_poi")
     */
    public function routeDeleteAction(Request $request)
    {
        $poiModel = $this->get('druta.model.poi_model');
        $poiId = $request->query->get('id');
        $poi = $poiModel->findById($poiId);

        $routeId = $poi->getRoute()->getId();

        if(!is_null($poi))
        {
            $poiModel->removePOI($poi);
            $poiModel->applyChanges();
        }

        $response = new JsonResponse(
            array(
                'id' => $routeId
            ), 200);
        return $response;
    }
}