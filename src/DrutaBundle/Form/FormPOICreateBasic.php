<?php
namespace DrutaBundle\Form;

use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class FormPOICreateBasic extends AbstractType {

    private $routeId;

    function __construct($routeId)
    {
        $this->routeId = $routeId;
    }

    public function buildForm(FormBuilderInterface $builder, array $options) {



        $builder->add('id', 'text', array(
            'label' => 'id',
            'required' => false,
            'attr' => array(
                'placeholder' => 'Id',
                'class' => 'form-control input-circle')
        ))
            ->add('id','hidden')


            ->add('name', 'text', array(
                'label' => 'Nombre',
                'required' => true,
                'attr' => array(
                    'placeholder' => 'Nombre',
                    'class' => 'form-control')
                )
            )
            ->add('description', 'text', array(
                    'label' => 'Descripción',
                    'required' => true,
                    'attr' => array(
                        'placeholder' => 'Descripción',
                        'class' => 'form-control')
                )
            )
            ->add('latitude', 'text', array(
                    'label' => 'Latitud',
                    'required' => true,
                    'read_only' => true,
                    'attr' => array(
                        'placeholder' => 'Latitud',
                        'class' => 'form-control')
                )
            )
            ->add('longitude', 'text', array(
                    'label' => 'Longitud',
                    'required' => true,
                    'read_only' => true,
                    'attr' => array(
                        'placeholder' => 'Longitud',
                        'class' => 'form-control')
                )
            )
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
                'data_class' => 'DrutaBundle\Entity\POI'
            )
        );
    }


    public function getName() {
        return 'poiCreateFormBasic';
    }

}