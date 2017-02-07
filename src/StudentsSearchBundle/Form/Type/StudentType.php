<?php

namespace StudentsSearchBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class StudentType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder->add("find", SubmitType::class)
                ->add("name", TextType::class, ["label" => "Nazwisko"])
                ->add("district", EntityType::class, [
                    "label" => "Województwo",
                    "class" => "StudentsSearchBundle:District",
                    "placeholder" => "Wybierz województwo",
                    "choice_label" => "name"
                ])
        ;

        $builder->addEventListener(
                FormEvents::PRE_SET_DATA, function (FormEvent $event) {

            $form = $event->getForm();
            $district = $form->get('district')->getData();

            if (!$district || null === $district->getId()) {


                $form->add("county", EntityType::class, [
                    "label" => "Powiat",
                    "class" => "StudentsSearchBundle:County",
                    //"choices" => $counties,
                    "placeholder" => "Wybierz powiat",
                    "choice_label" => "name"
                ]);
            }

        });
    }

}
