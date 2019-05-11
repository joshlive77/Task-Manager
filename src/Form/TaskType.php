<?php
namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class TaskType extends AbstractType{

    public function buildForm(FormBuilderInterface $builder, array $options){

        $builder->setMethod('post')
                ->add('title', TextType::class, ['label' => 'Titulo'])
                ->add('content', TextareaType::class, ['label' => 'Contenido'])
                ->add('priority', ChoiceType::class, [
                    'label' => 'Prioridad',
                    'choices' => array(
                        'Alta' =>'high',
                        'Media' => 'medium',
                        'Baja' => 'low')
                        ])
                ->add('hours', TextType::class, ['label' => 'Horas presupuestadas'])
                ->add('submit', SubmitType::class, [
                        'label' => 'Crear Tarea',
                        'attr' => [
                            'class' => 'hollow button success'
                        ]
                    ]);
    }

}