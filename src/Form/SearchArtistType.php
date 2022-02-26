<?php

namespace App\Form;

use App\Data\SearchData;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SearchArtistType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('display_name', TextType::class, [
                'label' => false,
                'required' => false,
                'attr' => [
                    'placeholder' => 'Artist name'
                ]
            ])
            ->add('gender', TextType::class, [
                'label' => false,
                'required' => false,
                'attr' => [
                    'placeholder' => 'Gender'
                ]
            ])
            ->add('nationality', TextType::class, [
                'label' => false,
                'required' => false,
                'attr' => [
                    'placeholder' => 'Nationality'
                ]
            ])
            ->add('begin_date', TextType::class, [
                'label' => false,
                'required' => false,
                'attr' => [
                    'placeholder' => 'Begin date'
                ]
            ])
            ->add('end_date', TextType::class, [
                'label' => false,
                'required' => false,
                'attr' => [
                    'placeholder' => 'End date'
                ]
            ])
            ->add('offset', ChoiceType::class, [
                'label' => false,
                'required' => true,
                'choices' => [
                    'Starting value at position 0' => 0,
                    'Starting value at position 5000' => 5000,
                    'Starting value at position 10000' => 10000,
                    'Starting value at position 20000' => 20000,
                    'Starting value at position 40000' => 40000,
                ]
            ])
            ->add('limit', ChoiceType::class, [
                'label' => false,
                'required' => true,
                'choices' => [
                    'limit the result to 500 values' => 500,
                    'limit the result to 1000 values' => 1000,
                    'limit the result to 5000 values' => 5000,
                    'limit the result to 10000 values' => 10000,
                    'limit max 30000 values' => 30000,
                ]
            ]);
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => SearchData::class,
            'method' => 'GET',
            'csrf_protection' => false
        ]);
    }

    /**
     * @return string
     */
    public function getBlockPrefix(): string
    {
        return '';
    }
}
