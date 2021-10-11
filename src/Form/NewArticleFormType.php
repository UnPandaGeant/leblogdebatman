<?php

namespace App\Form;

use App\Entity\Article;
use Doctrine\DBAL\Types\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class NewArticleFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title',TextType::class, [
                'label' => 'Titre',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Merci de renseigner un titre'
                    ]),
                    new Length([
                        'min' => 2,
                        'minMessage' => 'Le titre doit contenir au moins {{ limit }} caractères',
                        'max' => 150,
                        'maxMessage' => 'Le titre doit contenir au maximum {{ limit }} caractères',
                    ]),
                ],
            ])


            ->add('content', TextareaType::class, [
                'label' => 'Contenu',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Merci de renseigner un contenu'
                    ]),
                    new Length([
                        'min' => 2,
                        'minMessage' => 'Le titre doit contenir au moins {{ limit }} caractères',
                        'max' => 50000,
                        'maxMessage' => 'Le titre doit contenir au maximum {{ limit }} caractères',
                    ]),
                ],
            ])



            ->add('save', SubmitType::class, [
                'label' => 'publier',
                'attr' => [
                    'class' => 'btn btn-outline-primary w-100'
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
        ]);
    }
}
