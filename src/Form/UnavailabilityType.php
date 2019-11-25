<?php

namespace App\Form;

use App\Entity\Room;
use App\Entity\Unavailability;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UnavailabilityType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $this->ownersRooms = $options['ownersRooms'];
        $builder
            ->add('startingOn', DateType::class)
            ->add('endingOn', DateType::class)
            ->add('room', EntityType::class, [
                'class' => Room::class,
                'choice_label' => 'summary',
                'choices' => $this->ownersRooms,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Unavailability::class,
            'ownersRooms' => null,
        ]);
    }
}
