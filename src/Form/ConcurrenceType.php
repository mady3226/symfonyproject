<?php

namespace App\Form;

use App\Controller\ConcurrenceController;
use App\Entity\Concurrence;
use App\Entity\Etat;
use App\Entity\Produit;
use App\Entity\Vendeur;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ConcurrenceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom',EntityType::class, [
                'class' =>  Produit::class,
                'mapped'    =>  true,
                'choice_label'  =>  function (Produit $produit) {
                    return $produit->getNom();
                }
            ])
            ->add('prix')
            ->add('vendeur',EntityType::class, [
                'class' =>  Vendeur::class,
                'mapped'    =>  true,
                'choice_label'  =>  function (Vendeur $vendeur) {
                    return $vendeur->getNom();
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
            'data_class' => Concurrence::class,
        ]);
    }


}
