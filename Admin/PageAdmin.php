<?php

namespace Lexxpavlov\PageBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class PageAdmin extends Admin
{
    protected $contentType = 'ckeditor'; // or null for simple textarea field

    public function setContentType($contentType) {
        $this->contentType = $contentType;
    }
    
    public function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('title')
            ->add('slug')
            ->add('published', null, array('editable' => true))
            ->add('createdAt')
            ->add('updatedAt')
        ;
    }

    public function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->with('General')
                ->add('slug', null, array('required' => false))
                ->add('title')
                ->add('content', $this->contentType)
                ->add('published')
            ->end()
            ->with('SEO')
                ->add('metaKeywords', null, array('required' => false))
                ->add('metaDescription', null, array('required' => false))
            ->end()
        ;
    }

    public function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('slug')
            ->add('title')
        ;
    }

    public function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('slug')
            ->add('title')
            ->add('content')
            ->add('metaKeywords')
            ->add('metaDescription')
        ;
    }
}
