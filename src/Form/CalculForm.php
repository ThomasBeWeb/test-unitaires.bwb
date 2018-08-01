<?php
namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Entity\Zone;
use App\Entity\Spectateur;
use App\Entity\TheMatch;

class CalculForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('zone', EntityType::class, array(
            // looks for choices from this entity
            'class' => Zone::class,
        
            // uses the User.username property as the visible option string
            'choice_label' => 'niveau'

        ))
        //Choix spectateur Limit 10
        ->add('spectateur', EntityType::class, array(
            'class' => Spectateur::class,
            'query_builder' => function (EntityRepository $er) {
                return $er->createQueryBuilder('u')
                    ->setMaxResults(20);
            },
            'choice_label' => function ($spectateur) {
                return $spectateur->getRole()->getNom()." n° ".$spectateur->getId();
            }
        ))
        //Choix Match
        ->add('rencontre', EntityType::class, array(
            'class' => TheMatch::class,
            'choice_label' => function ($theMatch) {
                return "Match du ".$theMatch->getDateTheMatch()->format('d/m/Y');
            }
        ))
        ->add('save', SubmitType::class)
        ;
    }
}