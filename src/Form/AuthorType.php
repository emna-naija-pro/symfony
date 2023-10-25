<?php  

// src/Form/AuthorType.php
namespace App\Form;

use Doctrine\DBAL\Types\IntegerType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType as TypeIntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class AuthorType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username', TextType::class, [
                'label' => 'Nom d\'utilisateur',
                'attr' => [
                    'placeholder' => 'Entrez le nom d\'utilisateur',
                ],
            ])
            ->add('email', EmailType::class, [
                'label' => 'Email',
                'attr' => [
                    'placeholder' => 'Entrez l\'adresse e-mail',
                ],
            ])
            ->add('nbBooks', TypeIntegerType::class, [  // Correction de la configuration de 'nbBooks'
                'label' => 'Nombre de livres',  // Correction du label pour 'nbBooks'
                'attr' => [
                    'placeholder' => 'Entrez le nombre de livres',
                ],
            ])
            /*->add('save', SubmitType::class, [
                'label' => 'Ajouter l\'auteur',
            ])*/;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Configurez ici les options du formulaire, le cas échéant
        ]);
    }
}



?>