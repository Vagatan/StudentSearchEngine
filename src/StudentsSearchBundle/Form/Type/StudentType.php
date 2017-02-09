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

        $builder->add("name", TextType::class, [
                    "label" => "student.name",
                    "attr" => ["class" => "form-control"]])
                ->add("district", EntityType::class, [
                    "label" => "student.district",
                    "class" => "StudentsSearchBundle:District",
                    "placeholder" => "student.district_select",
                    "choice_label" => "name",
                    "attr" => ["class" => "form-control selectpicker"]])
                ->add('county', ChoiceType::class, [
                    "label" => "student.county",
                    "placeholder" => "student.county_select",
                    'expanded' => false,
                    'multiple' => false,
                    "attr" => ["class" => "form-control selectpicker"]])
                ->add('community', ChoiceType::class, [
                    "label" => "student.community",
                    "placeholder" => "student.community_select",
                    'expanded' => false,
                    'multiple' => false,
                    "attr" => ["class" => "form-control selectpicker"]])
                ->add("submit", SubmitType::class, [
                    "label" => "student.search",
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
