<?php

namespace App\Form;

use App\Entity\Hobby;
use App\Entity\Job;
use App\Entity\Person;
use App\Entity\Profile;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class PersonType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstname')
            ->add('name')
            ->add('old')
            ->add('createdAt', null, [
                'widget' => 'single_text',
            ])
            ->add('updatedAt', null, [
                'widget' => 'single_text',
            ])
            ->add('profile', EntityType::class, [
                'class' => Profile::class,
                'choice_label' => 'socialNetwork',
                'query_builder' => function (EntityRepository $er): QueryBuilder {
                    return $er->createQueryBuilder('p')
                        ->orderBy('p.socialNetwork', 'ASC');
                },
                'attr' => [
                    'class' => 'select2-search-for-single-selection',
                ],
            ])
            ->add('hobbies', EntityType::class, [
                'class' => Hobby::class,
                'choice_label' => 'designation',
                'required' => false,
                /* Form Type Symfony */
                'expanded' => false,
                'multiple' => true,
                'query_builder' => function (EntityRepository $er): QueryBuilder {
                    return $er->createQueryBuilder('h')
                        ->orderBy('h.designation', 'ASC');
                },
                'attr' => [
                    'class' => 'select2-search-for-multiple-selection',
                ],
            ])
            ->add('job', EntityType::class, [
                'class' => Job::class,
                'choice_label' => 'designation',
                'required' => false,
                'attr' => [
                    'class' => 'select2-search-for-single-selection',
                ],
            ])
            ->add('image', FileType::class, [
                'label' => 'Photo de profile',
                'mapped' => false,
                'required' => false,
                'constraints' => [
                  new File([
                      'maxSize' => '1024k',
                      'mimeTypes' => [
                          'image/jpeg',
                          'image/png',
                          'image/gif',
                      ],
                      'mimeTypesMessage' => 'Please upload a valid image',
                  ])
                ],
            ])
            ->add('Ok', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Person::class,
        ]);
    }
}
