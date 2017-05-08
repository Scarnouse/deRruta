<?php

namespace ApiBundle\Controller;

use FOS\RestBundle\Context\Context;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations\Route;
use FOS\RestBundle\Util\Codes;
use FOS\RestBundle\View\View;
use FOS\RestBundle\Controller\Annotations\Post;
use JMS\Serializer\SerializationContext;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\GetSetMethodNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use DrutaBundle\Entity\User;

/**
 * @Route("/api/v1")
 */
class AuthController extends FOSRestController
{
    /**
     * @Post("/user/login")
     */
    public function loginAction(Request $request)
    {
        $view = View::create();

        $data = $request->request->all();

        if(!$request->request->has('email'))
        {
            $view = View::create(
                array(
                    'error' => '404',
                    'message' => 'Falta parámetro email',
                    404
                )
            );
            return $this->handleView($view);
        }

        if(!$request->request->has('password'))
        {
            $view = View::create(
                array(
                    'error' => '404',
                    'message' => 'Falta parámetro password',
                    404
                )
            );
            return $this->handleView($view);
        }

        $modelUser = $this->get('druta.model.user_model');
        $user = $modelUser->findByEmail($data['email']);

        if(!$user)
        {
            $view = View::create(
                array(
                    'error' => '409',
                    'message' => 'El usuario no existe',
                    409
                )
            );
            return $this->handleView($view);
        }

        $loginSuccess = $modelUser->loginByEmail($data['email'], $data['password']);

        if($loginSuccess)
        {
            $serializationContext = SerializationContext::create()->enableMaxDepthChecks();
            $serializationContext->setGroups(array('user'));
            $view
                ->setData($user)
                ->setStatusCode(Codes::HTTP_OK)
                ->setSerializationContext($serializationContext);

            return $view;
        } else {
            $view = View::create(array(
                    'error' => '401',
                    'message' => 'Credenciales incorrectas',
                    401
                )
            );
            return $this->handleView($view);
        }
    }
}