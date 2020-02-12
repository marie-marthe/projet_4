<?php

namespace App\Form;

use App\Entity\Booking;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


class BookingType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('bookingDate', DateType::class, array(
                'label'  => 'Date de réservation',
                'widget' => 'single_text',
                'html5'  => false,
                'attr'   => array('class' => 'datepicker', 'placeholder' => 'JJ-MM-AAAA'),
                'format' => 'dd-MM-yyyy'
            ))
            ->add('ticketCategory',ChoiceType::class, array(
                'choices'          => array(
                    'Journée'      => true,
                    'Demi-journée' => false
                ),
                'label'   => 'Type de billet',
                'expanded'=> true
            ))
            ->add('userMail', EmailType::class, array(
                'label'   =>'Votre adresse Mail',
                'required'=> true,
                'attr'    => array('placeholder' => 'exemple@mail.fr'),
            ))
            ->add('ticketQuantity', HiddenType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // uncomment if you want to bind to a class
            'data_class' => Booking::class
        ]);
    }
}
