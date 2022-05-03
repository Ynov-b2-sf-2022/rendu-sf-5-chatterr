<?php

namespace App\Form;

use App\Entity\Message;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class InsertMessageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            // ->add('content')
            // ->add('user')
            // ->add('category')
            ->add('content', TextareaType::class, [
                'attr' => [
                    'class' => 'tinymce', 
                    'rows' => '10', 
                    'cols' => '50', 
                    'placeholder' => 'Vous pouvez écrire votre message ici ...'
                ],
                'label' => false,
            ]);
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Message::class,
        ]);
    }
}
