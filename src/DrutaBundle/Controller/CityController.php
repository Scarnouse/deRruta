<?php

namespace DrutaBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class CityController extends Controller
{
    /**
     * @Route("/cities", name="cities")
     */
    public function citiesAction(Request $request)
    {
        //TODO get all cities and show how many routes get
    }
}