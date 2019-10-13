<?php

namespace App\Form;

use App\Entity\Owner;
use App\Entity\Region;
use App\Entity\Room;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RoomType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('summary')
            ->add('description')
            ->add('capacity')
            ->add('superficy')
            ->add('price')
            ->add('address')
            ->add('regions', EntityType::class, [
                'class' => Region::class,
                'choice_label' => 'name',
                'multiple' => true,
            ])
            ->add('owner', EntityType::class, [
                'class' => Owner::class,
                'choice_label' => "firstname"
            ])
            ->add('submit', SubmitType::class);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Room::class,
        ]);
    }
}
