LexxpavlovPageBundle
=================

This bundle helps you to manage your static pages in Symfony2 project.

The bundle has a page entity with fields:
* title - the title of page
* content - html content. May use ckeditor for easy wysiwyg edit of content
* slug - use as url of page. May be autogenerated while create a new page
* published and publishedAt
* meta: keywords and description

If you use SonataAdminBundle, this bundle automatically adds an entity to it.

Installation (>=Symfony 2.1)
------------

### Composer

Download LexxpavlovPageBundle and its dependencies to the vendor directory. The bundle has a [StofDoctrineExtensionsBundle](https://github.com/stof/StofDoctrineExtensionsBundle) as required dependency, [Behat/Transliterator](https://github.com/Behat/Transliterator) and [IvoryCKEditorBundle](https://github.com/egeloen/IvoryCKEditorBundle) as optional dependencies.

You can use Composer for the automated process:

```bash
$ php composer.phar require lexxpavlov/pagebundle:dev-master
```

or manually add link to bundle into your `composer.json` and run `$ php composer.phar update`:

```json
{
...
    "require" : {
        ...
        "lexxpavlov/pagebundle": "dev-master"
    },
...
```

Composer will install bundle to `vendor/lexxpavlov` directory.

### Adding bundle to your application kernel

```php
// app/AppKernel.php

public function registerBundles()
{
    $bundles = array(
        // ...
        new Stof\DoctrineExtensionsBundle\StofDoctrineExtensionsBundle(),
        new Lexxpavlov\PageBundle\LexxpavlovPageBundle(),
        // ...
    );
}
```

If you are already have `StofDoctrineExtensionsBundle` in the your `AppKernel`, you don't need to add its twice.

Configuration
-------------

First you must create your own page entity class. It's easy to make by extend base page from bundle.

```php
<?php

namespace App\YourBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

use Lexxpavlov\PageBundle\Entity\Page as BasePage;

/**
 * @ORM\Entity()
 */
class Page extends BasePage
{
    // Be free to add your fields here
}

```

Here is the default configuration for the bundle:

```yaml
stof_doctrine_extensions:
    default_locale: %locale%
    orm:
        default:
            timestampable: true

lexxpavlov_page:
    entity_class: App\YourBundle\Entity\Page
```

This will activate doctrine Timestampable extention. Also you may activate Sluggable and Blameable extentions (see below). See more about doctrine extentions at [documentation](https://github.com/stof/StofDoctrineExtensionsBundle/blob/master/Resources/doc/index.rst).

Now you need create the table in your database:

```bash
$ php app/console doctrine:schema:update --dump-sql
```

This will show SQL query for creating the table in the database. You may manually run this query.

> **Note.** You may also execute `php app/console doctrine:schema:update --force` command, and Doctrine will create needed table for you. But I strongly recommend you to execute `--dump-sql` first and check SQL, which Doctrine will execute.

Usage
-----

If you use SonataAdminBundle, then you are already have admin tool for creating new pages. Otherwise you need to write your own creating tool, and here you may use predefined form:
```php
$form = $this->createForm('lexxpavlov_page');
```

There is the sample code for showing page, controller class and twig template. 

Controller:
```php
{# src/App/YourBundle/Controller/PageController.php #}

namespace App\YourBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use App\YourBundle\Entity\Page;

class DefaultController extends Controller
{
    /**
     * @Route("/page/{id}.html")
     * @Template()
     */
    public function pageAction(Page $page)
    {
    }
    
    // or find by slug:
    
    /**
     * @Route("/page/{slug}")
     * @Template("AppYourBundle:Default:page.html.twig")
     */
    public function slugAction(Page $page)
    {
    }
    
    // or find from repository
    
    /**
     * @Route("/page-find/{id}")
     * @Template("AppYourBundle:Default:page.html.twig")
     */
    public function findAction($id)
    {
        $repository = $this->getDoctrine()->getRepository('AppYourBundle:Page');
        
        if (is_numeric($id)) {
            $page = $repository->find($id);
        } else {
            $page = $repository->findOneBySlug($id);
        }
        
        return array('page' => $page);
    }
}
```

And template:

```twig
{# src/App/YourBundle/Resources/views/Default/page.html.twig #}

{% extends '::layout.html.twig'%}

{% block meta %}
{% if page.metaKeywords is defined %}
    <meta name="Keywords" content="{{ page.metaKeywords }}">
{% endif %}
{% if page.metaDescription is defined %}
    <meta name="Description" content="{{ page.metaDescription }}">
{% endif %}
{% endblock %}

{% block body %}

<div class="page">
    <h1 class="page-title">{{ page.title }}</h1>
    <div class="page-info">Created at {{ page.createdAt|date('d.m.Y') }} by {{ page.createdBy.username }}</div>
    <div class="page-content">{{ page.content|raw }}</div>
</div>

{% endblock %}
```

> **Note.** Do not forget add a `meta` block to the `<head>` section of `layout.html.twig`.

The page with id=1 and slug=test will be shown by controller at these urls:

* /page/1.html
* /page/test
* /page-find/1
* /page-find/test

Advanced configuration
----------------------

### Full configuration

```yaml
lexxpavlov_page:
    entity_class: App\SiteBundle\Entity\Page
    admin_class: Lexxpavlov\PageBundle\Admin\PageAdmin # or false to disable sonata admin service
    content_type: ckeditor # use your form type for content field, e.g. textarea
```

`ckeditor` form type is added by [IvoryCKEditorBundle](https://github.com/egeloen/IvoryCKEditorBundle).

### Activate autogeneration of slug field

LexxpavlovPageBundle marks `slug` field as `@Gedmo\Slug`. You need to activate its listener in StofDoctrineExtensionsBundle config:

```yaml

stof_doctrine_extensions:
    # ...
    class:
        sluggable: Lexxpavlov\PageBundle\Listener\BehatSluggableListener
    orm:
        default:
            sluggable: true
            # ...
```

BehatSluggableListener use Behat\Transliterator for convert non-latin string (`title` field) to normalized latin string, that may be used as page slug (used in page url).

You may write own listener for your needs, see [extension documentation](https://github.com/Atlantic18/DoctrineExtensions/blob/master/doc/sluggable.md#custom-transliterator) and code of [listener](https://github.com/lexxpavlov/PageBundle/blob/master/Listener/BehatSluggableListener.php) in this bundle. Listeners are very simple and must link to a static class with `transliterate` method.

### Append autoupdated user fields

You may add `createdBy` and `updatedBy` fields to your entity and use Blameable doctrine extention. Make next changes to your page entity class:

```php
<?php

namespace App\YourBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

use Gedmo\Mapping\Annotation as Gedmo;
use Lexxpavlov\PageBundle\Entity\Page as BasePage;

use App\YourBundle\Entity\User;

/**
 * @ORM\Entity()
 */
class Page extends BasePage
{
    
    /**
     * @var User
     *
     * @Gedmo\Blameable(on="create")
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumn(name="created_by", referencedColumnName="id")
     */
    protected $createdBy;

    /**
     * @var User
     *
     * @Gedmo\Blameable(on="update")
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumn(name="updated_by", referencedColumnName="id")
     */
    protected $updatedBy;

    
    /**
     * Set user, that updated entity
     *
     * @param User $updatedBy
     * @return Page
     */
    public function setUpdatedBy($updatedBy)
    {
        $this->updatedBy = $updatedBy;

        return $this;
    }

    /**
     * Get user, that updated entity
     *
     * @return User 
     */
    public function getUpdatedBy()
    {
        return $this->updatedBy;
    }
    
    /**
     * Set user, that created entity
     *
     * @param User $createdBy
     * @return Page
     */
    public function setCreatedBy($createdBy)
    {
        $this->createdby = $createdBy;

        return $this;
    }

    /**
     * Get user, that created entity
     *
     * @return User 
     */
    public function getCreatedBy()
    {
        return $this->createdBy;
    }

}

```

And activate Blameable extention in StofDoctrineExtensionsBundle config:

```yaml
stof_doctrine_extensions:
    # ...
    orm:
        default:
            blameable: true
            # ...
```
