<?php

namespace App\Form;

use App\Entity\AssignmentHeader;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichFileType;

class AssignmentFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('AssignmentName',null,[
                'label'=>false,
                'attr'=>['class'=>'form-control']
            ])
            ->add('ModuleId',null,[
                'label'=>false,
                'attr'=>['class'=>'form-control']
            ])
            ->add('Content',null,[
                'label'=>false,
                'attr'=>['class'=>'form-control']
            ])
            ->add('SubmitBefore',null,[
                'label'=>false,
                'attr'=>['class'=>'form-control']
            ])
            ->add('UpdatedAt')
            ->add('ClassId',null,[
                'label'=>false,
                'attr'=>['class'=>'form-control']
            ])
            ->add(

                'AttachmentFile',
                VichFileType::class,
                [
                    'label' => 'Course Material (PDF file)',
                    'required' => false,
                    'allow_delete' => true,
                    'delete_label' => 'delete file',
                    'download_uri' => '...',
                    'download_label' => 'download file',
                    'asset_helper' => true,
                ]
            )
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => AssignmentHeader::class,
        ]);
    }
}
