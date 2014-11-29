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

    public function setContentType($contentType)
    {
        $this->contentType = $contentType;
    }
    
    public function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('title')
            ->add('slug')
            ->add('published', null, array('editable' => true))
            ->add('createdAt', 'datetime')
            ->add('updatedAt', 'datetime')
        ;
    }

    public function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->with('General')
                ->add('slug', null, array('required' => false))
                ->add('title')
                ->add('content', $this->contentType)
                ->add('published', null, array('required' => false))
            ->end()
            ->with('SEO')
                ->add('metaKeywords', null, array('required' => false))
                ->add('metaDescription', null, array('required' => false))
            ->end()
        ;
        $formMapper->setHelps(array(
            'slug' => 'Leave blank for automatic filling from title field',
        ));
    }

    public function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('slug')
            ->add('title')
            ->add('published')
        ;
    }

    public function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('slug')
            ->add('title')
            ->add('content')
            ->add('published')
            ->add('publishedAt', 'datetime')
            ->add('createdAt', 'datetime')
            ->add('updatedAt', 'datetime')
            ->add('metaKeywords')
            ->add('metaDescription')
        ;
    }
}
