<?php

namespace App\Form;

use App\Entity\Player;
use App\Entity\Team;
use App\Repository\TeamRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PlayerType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('lastname', TextType::class, [
                'label' => false,
                'attr' => [
                    'placeholder' => 'Nom',
                ],
            ])
            ->add('firstname', TextType::class, [
                'label' => false,
                'attr' => [
                    'placeholder' => 'Prénom',
                ],
            ])
            ->add('birthdate', BirthdayType::class, [
                'widget' => 'choice',
                'html5' => false,
                'format' => "dd/MM/yyyy",
                'attr' => [
                    'autocomplete' => "off",
                ],
                'label_attr' => [
                    'class' => 'text-white',
                ],
                'placeholder' => [
                    'year' => 'Année', 'month' => 'Mois', 'day' => 'Jour',
                ],
                'required' => false,
                'label' => 'Date de naissance'
            ])
            ->add('email', EmailType::class, [
                'label' => false,
                'attr' => [
                    'placeholder' => 'E-mail'
                ],
                'required' => false
            ])
            ->add('teams', EntityType::class, [
                'label' => 'Sélectionner équipe par équipe',
                'label_attr' => ['class' => "text-white mr-3"],
                'class' => Team::class,
                'multiple' => true,
                'choice_label' => function (Team $team) use ($options) {
                    $choiceLabel = $team->getName() . ' (' . $team->getSeason()->getName() . ')';
                    return $choiceLabel;
                },
                'attr' => [
                    'class' => "selectpicker"
                ],
                'query_builder' => function (TeamRepository $teamRepository) use ($options) {
                    $query = $teamRepository->createQueryBuilder('t');
                    $query->leftJoin('t.club', 'tc');
                    $query->andWhere('tc.id = :club')->setParameter(':club', $options['club']->getId());

                    return $query;
                },
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Player::class,
            'club' => null
        ]);
    }
}