<?php

namespace StudentsSearchBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class StudentType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {

        $builder->add("name", TextType::class, [//"label" => "Nazwisko",
                    "attr" => ["class" => "form-control"]])
                ->add("district", EntityType::class, [
                    "class" => "StudentsSearchBundle:District",
                    "placeholder" => "Wybierz województwo",
                    "choice_label" => "name",
                    "attr" => ["class" => "form-control selectpicker"]])
                ->add('county', ChoiceType::class, [
                    "placeholder" => "Wybierz powiat",
                    'expanded' => false,
                    'multiple' => false,
                    "attr" => ["class" => "form-control selectpicker"]])
                ->add('community', ChoiceType::class, [
                    "placeholder" => "Wybierz gminę",
                    'expanded' => false,
                    'multiple' => false,
                    "attr" => ["class" => "form-control selectpicker"]])
                ->add("submit", SubmitType::class, [
                    "attr" => ["class" => "btn btn-primary"]]);
        $builder->get("district")->resetViewTransformers();
        $builder->get("county")->resetViewTransformers();
        $builder->get("community")->resetViewTransformers();
    }

    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults(array(
            'csrf_protection' => false,
        ));
    }

}
