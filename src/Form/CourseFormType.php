<?php

namespace App\Form;

use App\Entity\CourseHeader;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CourseFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('CourseName',TextareaType::class,['label'=>false])
            ->add('CourseDuration',null,['label'=>false])
            ->add('CourserTutor',null,['label'=>false, 'disabled'=> true,
                ])
            ->add('ClassId',null,['label'=>false])
            ->add('IsActive',CheckboxType::class,['label'=>false])
            ->add('CourseCode',null,['label'=>false])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => CourseHeader::class,
        ]);
    }
}
