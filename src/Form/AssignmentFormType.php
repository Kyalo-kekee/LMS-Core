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
            ->add('AssignmentName')
            ->add('ModuleId')
            ->add('Content')
            ->add('SubmitBefore')
            ->add('UpdatedAt')
            ->add('ClassId')
            ->add(

                'AttachmentFile',
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
            'data_class' => AssignmentHeader::class,
        ]);
    }
}
