<?php

namespace DrutaBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class FormRouteCreateBasic extends AbstractType
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
        )->add('name', 'text',
            array(
                'label' => 'Nombre',
                'required' => true,
                'attr' => array(
                    'placeholder' => 'Introduce nombre de ruta',
                    'class' => 'form-control'
                )
            )
        )->add('description', 'text',
            array(
                'label' => 'Descripción',
                'required' => false,
                'attr' => array(
                    'placeholder' => 'Introduce breve descripción de la Ruta',
                    'class' => 'form-control'
                )
            )
        )->add('fileImage', FileType::class,
            array(
                'label' => 'Imagen de la Ruta',
                'required' => false,
                'attr' => array(
                    'class' => 'file'
                ),
                'data_class' => null
            )
        );
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
                'data_class' => 'DrutaBundle\Entity\Route'
            )
        );
    }


    public function getName() {
        return 'routeCreateFormBasic';
    }
}