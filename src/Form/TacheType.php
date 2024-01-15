<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Tache;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;


class TacheType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                "attr" => ["class" => "form-group"],
                "label" => "Nom",
                "required" => false,
            ])
            ->add('description', TextType::class, [
                "required" => false,
                "label" => "Decription de la tâche",
                "attr" => ["class"=>"form-group"],
            ])
            ->add('intervention_delay', DateTimeType::class, [
                "required" => false,
                "attr" => ["class"=>"form-group", "name"=>"my_date",'data-date-start-date'=> "+0d"],
                "label" => "Date effective",
                "required" => false,
            ])
            ->add('priority',ChoiceType::class, [
                'choices'  => [
                    'Choisir une priorité' => '',
                    'Urgent' => 'Urgent',
                    'Important' => 'Important',
                    'Faible' => 'Faible',],
                "label" => "Priorité",
                
            ])
            ->add('category_id', EntityType::class, [
                'class' => Category::class,
                'attr' => ["value"=>"category_id","class"=>"form-group"],
                'placeholder' => 'Choisir une catégorie',
                'choice_label' => 'name',
                'label' => "Type de tâche",
            ])
            ->add('Valider', SubmitType::class, [
                'attr' => ['class' => 'save btn btn-success','name'=>'Valider'],
            ]);
            
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Tache::class,
        ]);
    }
}
