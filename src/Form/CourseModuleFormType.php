<?php

namespace App\Form;

use App\Entity\CourseHeaderDetails;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;
use Vich\UploaderBundle\Form\Type\VichFileType;
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

                'ModuleAttachment',
                VichFileType::class,
                [
                    'label' => 'Course Material (PDF file)',
                    'required' => false,
                    'allow_delete' => true,
                    'delete_label' => 'delete file',
                    'download_uri' => '...',
                    'download_label' => '...',
                    'asset_helper' => true,
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
