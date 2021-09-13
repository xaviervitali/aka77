<?php

namespace App\Form;

use App\Entity\BlogArticle;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;


class BlogArticleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titleArticle', TextType::class, [
                'label' => 'Titre de l\'article', 
                'attr' => [
                    'placeholder' => 'Entrez le titre de l\'article', 
                    'class'=>'articleTitle'
                ]])
            ->add('urlArticle', TextType::class, [
                'label' => '.', 
                'attr' => [
                    'class' => 'articleUrl',
                    'style' => 'display: none',
                ]])
            ->add('contentArticle', TextareaType::class, [
                'label' => 'Contenu de l\'article', 
                'required' => false 
                ])
            //->add('likeArticle', IntegerType::class, ['label' => 'Nombre de likes', 'attr' => ['placeholder' => 'A MASQUER ?']])
            //->add('dateModification')
            ->add('blogImg', FileType::class, [
                'data_class' => null, 
                'label' => 'Image de l\'article', 
                'attr' => [
                    'placeholder' => 'Ajoutez votre image si besoin', 
                    'class' => '' 
                ]])
            // ->add('category', TextType::class, ['label' => 'Catégorie', 'attr' => ['placeholder' => 'Entrez une catégorie pour votre article'], 'option' => ['']])
            ->add ('category', ChoiceType::class, [
                'choices' => [
                    'actu' => '1',
                    'zoom sur' => '2',
                    'divers' => '3',
                ], 
                ])
            ->add('author', TextType::class, ['label' => 'Auteur de l\'article', 'attr' => ['placeholder' => 'Entrez l\'auteur de l\'article']])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => BlogArticle::class,
        ]);
    }
}
