<?php
namespace App\Entity;

use Symfony\Component\Validator\Constraint as Assert;

class PropertySeach 
{
    
    /**
     * @var int
     */
    private $maxPrice;

     /**
     * @var int |null
     * @Assert\Range(min =10, max=400)
     */
    private $minSurface;

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