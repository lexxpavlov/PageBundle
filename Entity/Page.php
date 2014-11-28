<?php

namespace Lexxpavlov\PageBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

class Page
{
    /**
     * @var integer $id
     *
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    
    /**
     * @var string
     *
     * @Gedmo\Slug(fields={"title"}, updatable=false)
     * @ORM\Column(type="string", length=100, unique=true)
     */
    protected $slug;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255)
     */
    protected $title;

    /**
     * @var string
     *
     * @ORM\Column(type="text")
     */
    protected $content;

    /**
     * @var string
     *
     * @ORM\Column(type="text", name="meta_keywords", nullable=true)
     */
    protected $metaKeywords;

    /**
     * @var string
     *
     * @ORM\Column(type="text", name="meta_description", nullable=true)
     */
    protected $metaDescription;

    /**
     * @var boolean
     *
     * @ORM\Column(type="boolean", options={"default":false})
     */
    protected $published = false;
    
    /**
     * @var \DateTime
     *
     * @ORM\Column(type="datetime", name="published_at", nullable=true)
     * @Gedmo\Timestampable(on="change", field="published")
     */
    protected $publishedAt;

    public function __toString() {
        return $this->title ?: 'n/a';
    }

    /**
     * @var \Datetime
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(type="datetime", name="created_at")
     */
    protected $createdAt;

    /**
     * @var \Datetime
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(type="datetime", name="updated_at")
     */
    protected $updatedAt;
    
    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set slug
     *
     * @param string $slug
     * @return Page
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Get slug
     *
     * @return string 
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Set title
     *
     * @param string $title
     * @return Page
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string 
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set content
     *
     * @param string $content
     * @return Page
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Get content
     *
     * @return string 
     */
    public function getContent()
    {
        return $this->content;
    }
    
    /**
     * Set meta keywords
     * 
     * @param string $metaKeywords
     * @return Page
     */
    public function setMetaKeywords($metaKeywords)
    {
        $this->metaKeywords = $metaKeywords;
        
        return $this;
    }
    
    /**
     * Get meta keywords
     * 
     * @return string
     */
    public function getMetaKeywords()
    {
        return $this->metaKeywords;
    }
    
    /**
     * Set meta description
     * 
     * @param string $metaDescription
     * @return Page
     */
    public function setMetaDescription($metaDescription)
    {
        $this->metaDescription = $metaDescription;
        
        return $this;
    }
    
    /**
     * Set meta description
     * 
     * @return string
     */
    public function getMetaDescription()
    {
        return $this->metaDescription;
    }
    
    
    /**
     * Set published
     *
     * @param boolean $published
     * @return Page
     */
    public function setPublished($published)
    {
        $this->published = $published;

        return $this;
    }

    /**
     * Toggle published
     *
     * @return Page
     */
    public function togglePublished()
    {
        $this->published = !$this->published;

        return $this;
    }

    /**
     * Get published
     *
     * @return boolean 
     */
    public function getPublished()
    {
        return $this->published;
    }
    
    /**
     * Set published at
     *
     * @param \Datetime  $publishedAt
     * @return Page
     */
    public function setPublishedAt($publishedAt)
    {
        $this->publishedAt = $publishedAt;

        return $this;
    }
    
    /**
     * Get published at
     *
     * @return \Datetime 
     */
    public function getPublishedAt()
    {
        return $this->publishedAt;
    }

    /**
     * Sets created at
     *
     * @param  DateTime $createdAt
     * @return Page
     */
    public function setCreatedAt(\DateTime $createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Returns created at
     *
     * @return DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Sets updated at
     *
     * @param  DateTime $updatedAt
     * @return Page
     */
    public function setUpdatedAt(\DateTime $updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Returns updated at
     *
     * @return DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

}
