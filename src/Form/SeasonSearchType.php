<?php

namespace App\Form;

use App\Entity\Season;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SeasonSearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add("season", EntityType::class, [
            'label' => "Sélectionner une saison",
            'label_attr' => [
                'class' => "text-white mr-3",
            ],
            'placeholder' => 'Toutes',
            'class' => Season::class,
            'choice_label' => 'name',
            'required' => false,
        ])
            ->add('submit', SubmitType::class, [
                'label' => 'Afficher',
                'attr' => [
                    'class' => 'btn btn-sm float-right login_btn'
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
        ]);
    }
}