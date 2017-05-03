<?php

namespace DrutaBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/user")
 */
class DefaultController extends Controller
{
    /**
     * @Route("/dashboard", name="dashboard")
     */
    public function dashboardAction(Request $request)
    {
        $user = $this->getUser();

        return $this->render('@Druta/Default/dashboard.html.twig',
            array(
                'user' => $user
            )
        );
    }

}
