<?php

namespace App\Form;

use App\Data\SearchData;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SearchLocalisationType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('culture', TextType::class, [
                'label' => false,
                'required' => false,
                'attr' => [
                    'placeholder' => 'Culture',
                ]
            ])
            ->add('period', TextType::class, [
                'label' => false,
                'required' => false,
                'attr' => [
                    'placeholder' => 'Period'
                ]
            ])
            ->add('dynasty', TextType::class, [
                'label' => false,
                'required' => false,
                'attr' => [
                    'placeholder' => 'Dynasty'
                ]
            ])
            ->add('reign', TextType::class, [
                'label' => false,
                'required' => false,
                'attr' => [
                    'placeholder' => 'Reign'
                ]
            ])
            ->add('region', TextType::class, [
                'label' => false,
                'required' => false,
                'attr' => [
                    'placeholder' => 'Region'
                ]
            ])
            ->add('subregion', TextType::class, [
                'label' => false,
                'required' => false,
                'attr' => [
                    'placeholder' => 'Subregion'
                ]
            ])
            ->add('country', TextType::class, [
                'label' => false,
                'required' => false,
                'attr' => [
                    'placeholder' => 'Country'
                ]
            ])
            ->add('county', TextType::class, [
                'label' => false,
                'required' => false,
                'attr' => [
                    'placeholder' => 'County'
                ]
            ])
            ->add('city', TextType::class, [
                'label' => false,
                'required' => false,
                'attr' => [
                    'placeholder' => 'City'
                ]
            ])
            ->add('locale', TextType::class, [
                'label' => false,
                'required' => false,
                'attr' => [
                    'placeholder' => 'Locale'
                ]
            ])
            ->add('locus', TextType::class, [
                'label' => false,
                'required' => false,
                'attr' => [
                    'placeholder' => 'Locus'
                ]
            ])
            ->add('river', TextType::class, [
                'label' => false,
                'required' => false,
                'attr' => [
                    'placeholder' => 'River'
                ]
            ])
            ->add('excavation', TextType::class, [
                'label' => false,
                'required' => false,
                'attr' => [
                    'placeholder' => 'Excavation'
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
