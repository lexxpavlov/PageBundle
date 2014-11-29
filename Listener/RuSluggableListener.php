<?php

namespace Lexxpavlov\PageBundle\Listener;

use Gedmo\Sluggable\SluggableListener;

class RuSluggableListener extends SluggableListener
{
    public function __construct(){
        $this->setTransliterator(array('\Lexxpavlov\PageBundle\Urlizer\Ru', 'transliterate'));
    }
}
