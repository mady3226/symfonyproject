<?php

namespace App\Form;

use App\Entity\Filtre;
use App\Entity\Produit;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FiltreType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('produit',EntityType::class, [
                'class' =>  Produit::class,
                'mapped'    =>  true,
                'choice_label'  =>  function (Produit $produit) {
                    return $produit->getNom();
                },
               'label' => 'Filtre'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Filtre::class,
        ]);
    }
}
