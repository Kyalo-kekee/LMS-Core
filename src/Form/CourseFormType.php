<?php

namespace App\Form;

use App\Entity\CourseHeader;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CourseFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('CourseName')
            ->add('CourseDuration')
            ->add('CourserTutor')
            ->add('ClassId')
            ->add('IsActive')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => CourseHeader::class,
        ]);
    }
}
