<?php

namespace Lexxpavlov\PageBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class PageType extends AbstractType
{

    private $dataClass;

    /**
     * @param EntityManager
     */
    public function __construct($dataClass)
    {
        $this->dataClass = $dataClass;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('slug', 'text')
            ->add('title', 'text')
            ->add('content', $options['contentType'])
            ->add('published', 'checkbox')
            ->add('metaKeywords', 'textarea')
            ->add('metaDescription', 'textarea')
            ->add('save', 'submit')
            ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => $this->dataClass,
            'contentType' => 'ckeditor',
        ));
    }
    
    public function getName()
    {
        return 'lexxpavlov_page';
    }
}