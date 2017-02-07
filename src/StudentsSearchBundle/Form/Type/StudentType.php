<?php

namespace StudentsSearchBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class StudentType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {

        $builder->add("name", TextType::class, ["label" => "Nazwisko"])
                ->add("district", EntityType::class, [
                    "label" => "Województwo",
                    "class" => "StudentsSearchBundle:District",
                    "placeholder" => "Wybierz województwo",
                    "choice_label" => "name"])
                ->add('county', ChoiceType::class, [
                    "placeholder" => "Wybierz powiat",
                    "label" => "Powiat",
                    'expanded' => false,
                    'multiple' => false])
                ->add('community', ChoiceType::class, [
                    "placeholder" => "Wybierz gminę",
                    "label" => "Gmina",
                    'expanded' => false,
                    'multiple' => false])
                ->add("find", SubmitType::class, ["label" => "Szukaj"]);
    }

}
