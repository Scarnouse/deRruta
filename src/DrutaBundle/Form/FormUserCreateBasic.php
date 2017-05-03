<?php

namespace DrutaBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class FormUserCreateBasic extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('id', HiddenType::class,
            array(
                'label' => 'id',
                'required' => false,
                'attr' => array(
                    'placeholder' => 'Id',
                    'class' => 'form-control input-circle'
                )
            )
        )->add('firstName', 'text',
            array(
                'label' => 'Nombre',
                'required' => true,
                'attr' => array(
                    'placeholder' => 'Introduce tu nombre',
                    'class' => 'form-control'
                )
            )
        )->add('lastName', 'text',
            array(
                'label' => 'Apellidos',
                'required' => false,
                'attr' => array(
                    'placeholder' => 'Introduce tus apellidos',
                    'class' => 'form-control'
                )
            )
        )->add('password', 'password',
            array(
                'label' => 'Contraseña',
                'required' => true,
                'attr' => array('class' => 'form-control')
            )
        )->add('username', 'email',
            array(
                'label' => 'Email',
                'required' => true,
                'attr' => array(
                    'placeholder' => 'Introduce tus email',
                    'class' => 'form-control'
                )
            )
        );
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
                'data_class' => 'DrutaBundle\Entity\User'
            )
        );
    }


    public function getName() {
        return 'userCreateFormBasic';
    }
}