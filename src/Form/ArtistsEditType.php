<?php

namespace App\Form;

use App\Entity\Artists;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class ArtistsEditType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('pseudo', TextType::class, ['label' => 'Pseudonyme', 'attr' => ['placeholder' => 'Entrez le pseudo de l\'artiste']])
            ->add('baseline', TextType::class, ['label' => 'Mini description (citation ou phrase fétiche)', 'attr' => ['placeholder' => 'Entrez votre texte ici']])
            // ->add('droit')
            ->add('password', PasswordType::class, ['label' => 'Mot de passe', 'attr' => ['placeholder' => 'Veuillez taper le mot de passe du compte de l\'artiste']])
            ->add('urlPageArtist', TextType::class, ['label' => 'URL de la page artiste', 'attr' => ['placeholder' => 'Entrez le lien de la page Instagram']])
            ->add('description', TextareaType::class, ['label' => 'Description'])
            ->add('emailArtist', EmailType::class, ['label' => 'Adresse Email', 'attr' => ['placeholder' => 'Entrez l\'adresse email de l\'artiste']])
            ->add('urlImageAvatar')
            ->add('urlSiteWebArtist', TextType::class, ['label' => 'Lien du site web', 'attr' => ['placeholder' => 'Entrez l\'adresse du site web']])
            ->add('urlFacebookArtist', TextType::class, ['label' => 'Lien de la page Facebook', 'attr' => ['placeholder' => 'Entrez le lien de la page Facebook']])
            ->add('urlInstagramArtist', TextType::class, ['label' => 'Lien de la page Instagram', 'attr' => ['placeholder' => 'Entrez le lien de la page Instagram']] )
            // ->add('dateCreation')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Artists::class,
        ]);
    }
}
