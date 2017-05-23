<?php

namespace ApiBundle\Controller;

use DrutaBundle\Entity\User;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations\Route;
use FOS\RestBundle\Util\Codes;
use FOS\RestBundle\View\View;
use JMS\Serializer\SerializationContext;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\Annotations\Post;


/**
 * @Route("api/v1")
 */
class UserController extends FOSRestController
{
    /**
     * @Post("/user/image")
     */
    public function getUserImage(Request $request)
    {
        $view = View::create();

        $data = $request->request->all();

        if(!$request->request->has('userId'))
        {
            $view = View::create(
                array(
                    'error' => '404',
                    'message' => 'Falta parámetro userId',
                    404
                )
            );
            return $this->handleView($view);
        }

        $modelUser = $this->get('druta.model.user_model');
        /** @var User $user */
        $user = $modelUser->findById($data['userId']);

        if(!$user){
            $view = View::create(
                array(
                    'error' => '409',
                    'message' => 'El usuario no exite',
                    409
                )
            );
            return $this->handleView($view);
        }

        $image = $user->getWebPathImage();

        $serializationContext = SerializationContext::create()->enableMaxDepthChecks();
        $view
            ->setData($image)
            ->setStatusCode(Codes::HTTP_OK)
            ->setSerializationContext($serializationContext);

        return $view;
    }
}