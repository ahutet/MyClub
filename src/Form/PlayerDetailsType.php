<?php

namespace App\Form;

use App\Entity\PlayerDetails;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PlayerDetailsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nbMatch', IntegerType::class, [
                'label' => 'Nombre de match',
                'label_attr' => [
                    'class' => 'text-white',
                ],
                'attr' => [
                    'placeholder' => '0',
                ],
            ])
            ->add('nbMinutes', IntegerType::class, [
                'label' => 'Nombre de minutes',
                'label_attr' => [
                    'class' => 'text-white',
                ],
                'attr' => [
                    'placeholder' => '0',
                ],
            ])
            ->add('nbPass', IntegerType::class, [
                'label' => 'Nombre de passes',
                'label_attr' => [
                    'class' => 'text-white',
                ],
                'attr' => [
                    'placeholder' => '0',
                ],
            ])
            ->add('nbGoals', IntegerType::class, [
                'label' => 'Nombre de buts',
                'label_attr' => [
                    'class' => 'text-white',
                ],
                'attr' => [
                    'placeholder' => '0',
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => PlayerDetails::class,
        ]);
    }
}