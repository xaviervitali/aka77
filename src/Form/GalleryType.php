<?php
namespace App\Form;

use App\Entity\Gallery;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class GalleryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('imgName', TextType::class, ['label' => 'Nom de l\'image', 'attr' => ['placeholder' => 'Entrez le nom de l\'image']])
            ->add('uploadGalleryForm', FileType::class, [
                'label' => 'Sélectionnez votre image',
                'attr' => [
                    'placeholder' => 'Cliquez ici pour choisir votre image',
                    'required' => false,
                ]])
            ->add('artist', TextType::class, ['label' => 'Nom de l\'artiste', 'attr' => ['placeholder' => 'Entrez le nom de l\'artiste']])
            ->add('imgDescription', TextareaType::class, ['label' => 'Description de l\'image', 'attr' => ['placeholder' => 'Entrez la description de l\'image']])
            //->add('imgMedium', TextType::class, ['label' => 'URL de l\'image medium', 'attr' => ['placeholder' => 'URL Image Medium']])
            //->add('imgSmall', TextType::class, ['label' => 'URL de l\'image small', 'attr' => ['placeholder' => 'URL Image Small']])
            //->add('imgLike')
            //->add('dateUpdate')
            // POUR AJOUTER LES CHOIX : https: //symfony.com/doc/current/reference/forms/types/choice.html#choice-label;
            ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Gallery::class,
        ]);
    }
}

