<?php

namespace MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Comentario
 *
 * @ORM\Table(name="comentario", indexes={@ORM\Index(name="videoId", columns={"videoId"})})
 * @ORM\Entity
 */
class Comentario
{
    /**
     * @var string
     *
     * @ORM\Column(name="comentario", type="text", length=65535, nullable=false)
     */
    private $comentario;

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
     * Set comentario
     *
     * @param string $comentario
     * @return Comentario
     */
    public function setComentario($comentario)
    {
        $this->comentario = $comentario;

        return $this;
    }

    /**
     * Get comentario
     *
     * @return string 
     */
    public function getComentario()
    {
        return $this->comentario;
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
     * @return Comentario
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
