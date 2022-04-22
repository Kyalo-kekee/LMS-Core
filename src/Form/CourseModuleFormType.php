<?php

namespace App\Form;

use App\Entity\CourseHeaderDetails;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
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
            ->add('ModuleName',null,[
                'label'=> false,
                'attr'=>['class' => 'form-control']
            ])
            ->add('ModuleDescription',TextareaType::class,[
                'label'=>false,
                'attr'=>['class'=>'form-control']
            ])
            ->add('ModuleContent',TextareaType::class,[
                'label'=>false,
                'attr'=>['id'=> 'editor-container', 'class'=>'form-control']
            ])
            ->add('ModuleDuration')
            ->add(
                'AttachmentFile',
                VichFileType::class,
                [
                    'mapped'=>false,
                    'label' => 'Course Material (PDF file)',
                    'required' => false,
                    'allow_delete' => true,
                    'delete_label' => 'delete file',
                    'asset_helper' => true,
                    'download_label' =>'download file',
                    'attr'=>[
                        'class'=>'custom-file-container__custom-file__custom-file-input'
                    ]
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
