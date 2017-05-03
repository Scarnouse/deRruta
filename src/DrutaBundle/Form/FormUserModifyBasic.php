<?php

namespace DrutaBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class FormUserModifyBasic extends AbstractType
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
        )->add('fileImage', FileType::class,
            array(
            'label' => 'Cambiar la imagen de perfil',
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
                'data_class' => 'DrutaBundle\Entity\User'
            )
        );
    }


    public function getName() {
        return 'userModifyFormBasic';
    }
}