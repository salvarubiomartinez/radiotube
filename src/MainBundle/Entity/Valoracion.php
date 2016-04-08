<?php

namespace MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Valoracion
 *
 * @ORM\Table(name="valoracion", indexes={@ORM\Index(name="videoId", columns={"videoId"})})
 * @ORM\Entity
 */
class Valoracion
{
    /**
     * @var integer
     *
     * @ORM\Column(name="valoracion", type="integer", nullable=false)
     */
    private $valoracion;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var \MainBundle\Entity\Video
     *
     * @ORM\ManyToOne(targetEntity="MainBundle\Entity\Video")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="videoId", referencedColumnName="id")
     * })
     */
    private $videoid;



    /**
     * Set valoracion
     *
     * @param integer $valoracion
     * @return Valoracion
     */
    public function setValoracion($valoracion)
    {
        $this->valoracion = $valoracion;

        return $this;
    }

    /**
     * Get valoracion
     *
     * @return integer 
     */
    public function getValoracion()
    {
        return $this->valoracion;
    }

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
     * Set videoid
     *
     * @param \MainBundle\Entity\Video $videoid
     * @return Valoracion
     */
    public function setVideoid(\MainBundle\Entity\Video $videoid = null)
    {
        $this->videoid = $videoid;

        return $this;
    }

    /**
     * Get videoid
     *
     * @return \MainBundle\Entity\Video 
     */
    public function getVideoid()
    {
        return $this->videoid;
    }
}
