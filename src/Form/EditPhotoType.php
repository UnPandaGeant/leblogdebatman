<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Validator\Constraints\NotBlank;

class EditPhotoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('photo', FileType::class, [
                'label' => 'Sélectionnez une nouvelle photo',
                'attr' => [
                    'accept' => 'image/jpeg, image/png'
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'vous devez selectionner un fichier',
                    ]),
                    new  File([
                        'maxSize' => '2M',
                        'maxSizeMessage' => 'Fichier trop volumineux ({{size}} {{suffix}}. La taille maximum autorisée est de {{limit}} {{suffix}}',
                        'mimeTypes' => [
                            'image/jpeg',
                            'image/png',
                        ],
                        'mimeTypesMessage' => 'l\'image doit etre de type jpg ou png !'
                    ]),
                ],
            ])

            ->add('save', SubmitType::class, [
                'label' => 'changer la photo',
                'attr' => [
                    'class' => 'btn btn-outline-primary w-100'
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
