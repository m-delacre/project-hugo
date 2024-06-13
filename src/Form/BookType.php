<?php

namespace App\Form;

use App\Entity\Book;
use App\Entity\BookList;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BookType extends AbstractType
{
    public function __construct(private FormListenerFactory $formListenerFactory)
    {
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Titre du livre :',
                'required' => true,
                'empty_data' => ''
            ])
            ->add('slug', TextType::class, [
                'label' => 'Slug perso (auto si non précisé) :',
                'required' => false
            ])
            ->add('pages', NumberType::class, [
                'label' => 'Nombre de pages :',
                'empty_data' => ''
            ])
            ->add('author', TextType::class, [
                'label' => "Nom de l'auteur :",
                'empty_data' => ''
            ])
            ->add('note', TextareaType::class, [
                'label' => 'Ajouter une note personnel sur le livre :'
            ])
            ->add('save', SubmitType::class, [
                'label' => 'Ajouter'
            ])
            ->addEventListener(FormEvents::PRE_SUBMIT, $this->formListenerFactory->autoSlug('name'))
            ->addEventListener(FormEvents::POST_SUBMIT, $this->formListenerFactory->timestamps());
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Book::class,
        ]);
    }
}
