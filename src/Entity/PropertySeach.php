<?php
namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;

class PropertySeach 
{
    
    /**
     * @var int
     */
    private $maxPrice;

     /**
     * @var int |null
     * @Assert\Range(min=10, max=400)
    */
    private $minSurface;

    
    /**
     * @var ArrayCollection
     */
    private $options;

    public function __construct()
    {
        $this->options =  new ArrayCollection();
    }

     /**
     * @return ArrayCollection $options
     */
    public function getoptions():ArrayCollection
    {
       return $this->options;
    }

    /**
     * @param ArrayCollection $options
     */
    public function setoptions(ArrayCollection $options)
    {
        $this->options = $options;
    }


    /**
     * @return int $maxPrice
     */
    public function getMaxPrice():?int
    {
       return $this->maxPrice;
    }

    /**
     * @param int | null $maxPrice
     * @return PropertySeach
     */
    public function setMaxPrice(int $maxPrice):PropertySeach
    {
        $this->maxPrice = $maxPrice;
        return $this;
    }

    /**
     * @return int $minSurface
     */
    public function getMinSurface():?int
    {
       return $this->minSurface;
    }

    /**
     * @param int | null  $minSurface
     * @return PropertySeach
     */
    public function setMinSurface(int $minSurface):PropertySeach
    {
        $this->minSurface = $minSurface;
        return $this;
    }
}