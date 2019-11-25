<?php

namespace App\Form;

use App\Entity\Owner;
use App\Entity\Region;
use App\Entity\Room;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichImageType;


class RoomType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('summary', TextareaType::class)
            ->add('description', TextareaType::class)
            ->add('capacity', IntegerType::class)
            ->add('superficy', NumberType::class)
            ->add('price', NumberType::class)
            ->add('address', TextType::class)
            ->add('regions', EntityType::class, [
                'class' => Region::class,
                'choice_label' => 'name',
                'multiple' => true,
                'expanded' => true,
            ])
            ->add('owner', EntityType::class, [
                'class' => Owner::class,
                'choice_label' => 'familyName',
            ])
            ->add('imageName', TextType::class, ['disabled' => true])
            ->add('imageFile', VichImageType::class, ['required' => false]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Room::class,
        ]);
    }
}
