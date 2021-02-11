<?php

namespace App\Form;

use App\Entity\Etat;
use App\Entity\Produit;
use App\Entity\Strategi;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class StrategiType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('prix_plancher',MoneyType::class)
            ->add('produit',EntityType::class, [
                'class' =>  Produit::class,
                'mapped'    =>  true,
                'choice_label'  =>  function (Produit $produit) {
                    return $produit->getNom();
                }
            ])
            ->add('etat',EntityType::class,[
                'class' =>  Etat::class,
                'mapped'    => true,
                'choice_label'  =>  function (Etat $etat) {
                    return $etat->getNom();
                }
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Strategi::class,
        ]);
    }
}
