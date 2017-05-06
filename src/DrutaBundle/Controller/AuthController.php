<?php

namespace DrutaBundle\Controller;

use DrutaBundle\Entity\User;
use DrutaBundle\Form\FormUserCreateBasic;
use DrutaBundle\Model\RoleModel;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\SecurityContext;


class AuthController extends Controller
{
    public function loginAction(Request $request)
    {
        $session = $request->getSession();
        $authenticationUtils = $this->get('security.authentication_utils');
        $error = $authenticationUtils->getLastAuthenticationError();

        if($error){
            $this->addFlash(
                'notice',
                'Usuario o contraseña incorrectos'
            );
        }

        $session->set('new_access', true);

        return $this->render('@Druta/Login/login.html.twig',
            array(
                'last_username' => $session->get(SecurityContext::LAST_USERNAME),
                'error' => $error
            )
        );
    }

    /**
     * @Route("/register", name="register")
     */
    public function registerAction(Request $request)
    {
        $user = new User();

        $formBasic = $this->createForm(new FormUserCreateBasic(), $user);
        $role = RoleModel::ROLE_USER;

        return $this->render('@Druta/Login/create_user.html.twig',
            array(
                "formBasic" => $formBasic->createView(),
                "role" => $role
            )
        );
    }

    /**
     * @Route("/create_user/{role}", name="create_user")
     */
    public function createUserAction(Request $request)
    {
        $role = $request->get('role');
        $request = $this->get('request');

        if($request->request->has('save')){
            $userModel = $this->get('druta.model.user_model');

            $password = $request->request->get('userCreateFormBasic')['password'];

            $user = new User();
            $form = $this->createForm(new FormUserCreateBasic(), $user);
            $form->handleRequest($request);
            $user->setPassword($password);
            $result = $userModel->registerUser($user, $role);

            $formBasic = $this->createForm(new FormUserCreateBasic(), $user);
            $formBasic->handleRequest($request);
            if($form->isValid()){
                switch ($result){
                    case 'use_exists':
                        $this->addFlash(
                            'notice',
                            'Error registrando el usuario. El email de registro de usuario ya existe. ¿ Has olvidado tu contraseña ?'
                        );
                        return $this->render('@Druta/Login/create_user.html.twig',
                            array(
                                'formBasic' => $formBasic->createView(),
                                'role' => $role
                            )
                        );
                        break;
                    case 'user_register_ok':
                        $request->getSession()
                            ->getFlashBag()
                            ->add('success', '¡Su usuario se ha registrado satisfactoriamente!')
                        ;
                        return $this->redirect($this->generateUrl('login'));
                        break;
                    case 'user_register_fail':
                        $this->addFlash(
                            'notice',
                            'Datos introducidos no validos'
                        );
                        return $this->render('@Druta/Login/create_user.html.twig',
                            array(
                                'formBasic' => $formBasic->createView(),
                                'role' => $role
                            )
                        );
                        break;
                }
            } else {
                $this->addFlash(
                    'notice',
                    'Datos introducidos no validos'
                );
                return $this->render('@Druta/Login/create_user.html.twig',
                    array(
                        'formBasic' => $formBasic->createView(),
                        'role' => $role
                    )
                );
            }
        } else {
            $this->addFlash(
                'notice',
                'Rol no permitido'
            );

            return $this->render('@Druta/Login/login.html.twig');
        }
    }
}