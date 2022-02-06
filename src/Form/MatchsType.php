<?php

namespace App\Form;

use App\Entity\Matchs;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Entity\Personnage;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class MatchsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('gagner')
            ->add('personnageJoueur', EntityType::class, [
                // looks for choices from this entity
                'class' => Personnage::class,
                'choice_label' => 'id',
            ])
            ->add('personnageAdversaire', EntityType::class, [
                // looks for choices from this entity
                'class' => Personnage::class,
                'choice_label' => 'id',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Matchs::class,
            'csrf_protection' => false
        ]);
    }
}
