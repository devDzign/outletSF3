<?php

namespace UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use UserBundle\Model\ArticleSearch;

class ArticleSearchType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title',null,array(
                'required' => false,
            ))
            ->add('dateFrom', DateType::class, array(
                'required' => false,
                'widget' => 'single_text',
            ))
            ->add('dateTo', DateType::class, array(
                'required' => false,
                'widget' => 'single_text',
            ))
            ->add('isPublished',ChoiceType::class, array(
                'choices' => array('false'=>'non','true'=>'oui'),
                'required' => false,
            ))
            ->add('search',SubmitType::class)
        ;
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'csrf_protection' => false,
            'data_class' => 'UserBundle\Model\ArticleSearch'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'userbundle_articleSearch';
    }


}
