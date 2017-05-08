<?php

namespace DrutaBundle\Controller;

use DrutaBundle\Form\FormUserModifyBasic;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;


/**
 * @Route("/user")
 */
class UserController extends Controller
{

    /**
     * @Route("/profile", name="profile")
     */
    public function profileAction(Request $request)
    {
        $user = $this->getUser();

        $formBasic = $this->createForm(new FormUserModifyBasic(), $user);
        $formBasic->handleRequest($request);

        return $this->render('@Druta/User/user_form.html.twig',
            array(
                'formBasic' => $formBasic->createView(),
                'user' => $user,
                'site' => 'Perfil'
            )
        );
    }

    /**
     * @Route("/save_user_profile", name="save_user_profile")
     */
    public function saveUserProfileAction(Request $request)
    {
        if($request->request->has('save'))
        {
            $userModel = $this->get('druta.model.user_model');

            $userId = $request->request->get('userModifyFormBasic')['id'];
            $user = $userModel->findById($userId);

            if(!$userId)
            {
                $formBasic = $this->createForm(new FormUserModifyBasic(), $user);

                return $this->render('@Druta/User/user_form.html.twig',
                    array(
                        'formBasic' => $formBasic->createView(),
                        'error_msg' => "Error actualizando el usuario. Intentelo de nuevo",
                        'site' => "Perfil"
                    )
                );

            } else {

                $form = $this->createForm(new FormUserModifyBasic(), $user);
                $form->handleRequest($request);

                if($form->isValid())
                {
                    $fileUploaderModel = $this->get('druta.model.file_uploader');
                    $fileName = $fileUploaderModel->uploadFile($user);
                    $user->setFilenameImage($fileName);
                    $userModel->update($user);
                    $userModel->applyChanges();
                }
            }
        }

        return $this->render('@Druta/User/user_form.html.twig',
            array(
                'formBasic' => $form->createView(),
                'ok_msg' => "Perfil actualizado correctamente",
                'user' => $user,
                'site' => "Perfil"
            )
        );
    }

}