<?php

namespace App\Form;

use App\Entity\Artwork;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Doctrine\ORM\EntityRepository;
use App\Entity\Classification;
use App\Entity\DatingArtwork;
use App\Entity\Artist;

class ArtworkType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('number', TextType::class, [
                'required' => false,
            ])
            ->add('name', TextType::class, [
                'required' => true,
            ])
            ->add('title', TextType::class, [
                'required' => true,
            ])
            ->add('dimensions', TextType::class, [
                'required' => false,
            ])
            ->add('medium', TextType::class, [
                'required' => true,
            ])
            ->add('classification', EntityType::class, [
                'class' => Classification::class,
                'required' => true,
                'query_builder' => function (EntityRepository $er) {
                    return ($er->createQueryBuilder('c')
                        ->setMaxResults(5000)
                        ->orderBy('c.classification', 'ASC'));
                },
            ])
            ->add('dating_artwork', EntityType::class, [
                'class' => DatingArtwork::class,
                'required' => true,
                'query_builder' => function (EntityRepository $er) {
                    return ($er->createQueryBuilder('d')
                        ->setMaxResults(5000)
                        ->orderBy('d.object_begin_date', 'ASC'));
                },
            ])
            ->add('artist', EntityType::class, [
                'class' => Artist::class,
                'required' => true,
                'query_builder' => function (EntityRepository $er) {
                    return ($er->createQueryBuilder('a')
                        ->setMaxResults(5000)
                        ->orderBy('a.display_name', 'ASC'));
                },
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Artwork::class,
        ]);
    }
}
