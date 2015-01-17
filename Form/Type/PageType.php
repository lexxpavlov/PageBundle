<?php

namespace Lexxpavlov\PageBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class PageType extends AbstractType
{
    private $contentType;

    public function __construct($contentType)
    {
        $this->contentType = $contentType;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', 'text')
            ->add('slug', 'text', array('required' => false))
            ->add('content', $options['contentType'])
            ->add('published', 'checkbox', array('required' => false))
            ->add('metaKeywords', 'textarea', array('required' => false))
            ->add('metaDescription', 'textarea', array('required' => false))
            ->add('save', 'submit')
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'contentType' => $this->contentType,
        ));
    }
    
    public function getName()
    {
        return 'lexxpavlov_page';
    }
}