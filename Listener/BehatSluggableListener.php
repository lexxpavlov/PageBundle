<?php

namespace Lexxpavlov\PageBundle\Listener;
 
class BehatSluggableListener extends \Gedmo\Sluggable\SluggableListener{
    
    public function __construct(){
        $this->setTransliterator(array('\Behat\Transliterator\Transliterator', 'transliterate'));
    }
}
