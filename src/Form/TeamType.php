<?php

namespace App\Form;

use App\Entity\Season;
use App\Entity\Team;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TeamType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'label' => false,
                'attr' => [
                    'placeholder' => 'Nom',
                ],
            ])
            ->add('division', TextType::class, [
                'label' => false,
                'attr' => [
                    'placeholder' => 'Division',
                ],
            ])
            ->add('season', EntityType::class, [
                'label' => 'Sélectionner une saison',
                'label_attr' => ['class' => "text-white mr-3"],
                'class' => Season::class,
                'choice_label' => 'name',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Team::class,
        ]);
    }
}