<?php

namespace App\Class;


/**
 * Class Search
 *
 * @package App
 */
class Search
{
    /**
     * @var string
     */
    private $string = '';

    /**
     * @var category[]
     */
    private $categories = [];

    
    public function getString()
    {
        return $this->string;
    }
    
    public function setString($string)
    {
        $this->string = $string;
        return $this;
    }
    
    public function getCategories()
    {
        return $this->categories;
    }
    
    public function setCategories($categories)
    {
        $this->categories = $categories;
        return $this;
    }
    
}
