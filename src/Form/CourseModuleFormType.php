<?php

namespace App\Form;

use App\Entity\CourseHeaderDetails;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;
use Vich\UploaderBundle\Form\Type\VichImageType;

class CourseModuleFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('CourseId')
            ->add('ModuleName')
            ->add('ModuleDescription')
            ->add('ModuleContent')
            ->add('ModuleDuration')
            ->add(

                'ModuleAttachmentFile',
                VichImageType::class,
                [
                    'label' => 'Course Material (PDF file)',
                    'constraints' => [
                        new File([
                            'maxSize' => '10240k',
                            'mimeTypes' => [
                                'application/pdf',
                                'application/x-pdf',
                            ],
                            'mimeTypesMessage' => 'Please upload a valid PDF document',
                        ])
                    ],
                ]
            )
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => CourseHeaderDetails::class,
        ]);
    }
}
