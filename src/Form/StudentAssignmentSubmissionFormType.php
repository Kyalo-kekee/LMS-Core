<?php

namespace App\Form;

use App\Entity\StudentAssignmentHeader;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichFileType;

class StudentAssignmentSubmissionFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('Content',TextareaType::class,[
                'label' => "Description",
                'attr'=>['class' => 'form-control']
            ])
            ->add(

                'AttachmentFile',
                VichFileType::class,
                [
                    'label' => 'Attach Assignment (PDF,.docs file)',
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
            'data_class' => StudentAssignmentHeader::class,
        ]);
    }
}
