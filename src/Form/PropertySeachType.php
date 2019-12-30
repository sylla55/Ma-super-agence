<?php

namespace App\Form;

use App\Entity\option;
use App\Entity\PropertySeach;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PropertySeachType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $optionss)
    {
        $builder
            ->add('maxPrice',IntegerType::class,[
                'required' => false,
                'label'=> false,
                'attr'=>[
                    'placeholder' => 'Prix maximal'
                ]
            ])
            ->add('minSurface',IntegerType::class,[
                'required' => false,
                'label'=> false,
                'attr'=>[
                    'placeholder' => 'Surface minimal'
                ]
            ])
            ->add('options',EntityType::class,[
                'required' => false,
                'label' => false,
                'class' => Option::class,
                'choice_label' => 'name',
                'multiple' => true,
                'expanded' => true
            ])
        ;
    }

    public function configureoptions(optionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => PropertySeach::class,
            'method' => 'get',
            'csrf_protection' => false
        ]);
    }

    public function getBlockPrefix()
    {
        return '';
    }
}
