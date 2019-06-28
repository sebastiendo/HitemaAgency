<?php

namespace App\Form;

use App\Entity\Property;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;


class PropertyType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', null,[
                'label' => 'Titre'])
                
            ->add('description')
            
            ->add('surface')
            
            ->add('rooms', null,[
                'label' => 'Pièce(s)'])
            
            ->add('bedrooms',  null,[
                'label' => 'Chambre(s)'])
            
            ->add('price', null,[
                'label' => 'Prix'])
            
            ->add('city',  null,[
                'label' => 'Ville'])
            
            ->add('adresse', null,[
                'label' => 'Adresse'])
            
            ->add('postalCode', null,[
                'label' => 'Code postal'])
            
            ->add('sold', null,[
                'label' => 'Vendu '])
            
            /*->add('createdAt', DateTimeType::class,[
                'label' => 'Crée le'])*/
            
            ->add('parking')
            
            ->add('pool', null,[
                'label' => 'Piscine'])
            
            ->add('garden', null,[
                'label' => 'Jardin']);
        
            }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Property::class,
            'csrf_protection' => true,
        ]);
    }
}
