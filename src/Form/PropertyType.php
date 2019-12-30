<?php

namespace App\Form;

use App\Entity\Property;
use App\Entity\Option;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PropertyType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', null,['label'=>'Titre'])
            ->add('description')
            ->add('surface')
            ->add('rooms',null,['label'=>'Piéce (s)'])
            ->add('bedrooms',null,['label'=>'Chambre (s)'])
            ->add('floor',null,['label'=>'Etage (s)'])
            ->add('price',null,['label'=>'Prix'])
            ->add('heat',ChoiceType::class,[
                'choices' =>$this->getChoiceType(),
                'label'=>'Chauffage'
            ])
            ->add('options',EntityType::class,[
                'class' => Option::class,
                'choice_label' => 'name',
                'multiple' => true,
                'expanded' => true
            ])
            ->add('city',null,['label'=>'Ville'])
            ->add('address',null,['label'=>'Adresse'])
            ->add('postalCode',null,['label'=>'Code postal'])
            ->add('sold',null,['label'=>'Vendu'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Property::class,
            'tranlation_domain' => 'forms'
        ]);
    }

    public function getChoiceType():array
    {
        $choice = Property::HEAT;
        $output = [];
        foreach($choice as $k=>$v){
            $output[$v] = $k;
        }
        return $output;
    }
}
