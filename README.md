LexxpavlovPageBundle
=================

This bundle helps you to manage your static pages in Symfony2 project.

Installation (>=Symfony 2.1)
------------

### Composer

Download LexxpavlovPageBundle and its dependencies to the vendor directory. The bundle has a [StofDoctrineExtensionsBundle](https://github.com/stof/StofDoctrineExtensionsBundle) as required dependency, [Behat/Transliterator](https://github.com/Behat/Transliterator) and [IvoryCKEditorBundle](https://github.com/egeloen/IvoryCKEditorBundle) as optional dependencies.

You can use Composer for the automated process:

```bash
$ php composer.phar require lexxpavlov/pagebundle
```

Composer will install bundles to `vendor` directory.

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

This will be activate doctrine Timestampable extention. Also you may activate Sluggable and Blameable extentions (see below). See more about doctrine extentions at [documentation](https://github.com/stof/StofDoctrineExtensionsBundle/blob/master/Resources/doc/index.rst).

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

### Append autoupdated user fields

You may add createdBy and updatedBy fields to your entity and use Blameable doctrine extention. Make next changes to your page entity class:

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

You may write own listener for your needs, see [extension documentation](https://github.com/Atlantic18/DoctrineExtensions/blob/master/doc/sluggable.md#custom-transliterator) and code of listener in this bundle.