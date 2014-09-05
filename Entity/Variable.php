<?php

namespace Ecedi\VarsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints as DoctrineAssert;

/**
 * @ORM\Entity
 * @ORM\Table(name="variable")
 * @DoctrineAssert\UniqueEntity(fields={"name"})
 */
class Variable
{
    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var datetime $dateInsert
     *
     * @ORM\Column(name="date_insert", type="datetime")
     */
    private $dateInsert;

    /**
     * @var datetime $dateUpdate
     *
     * @ORM\Column(name="date_update", type="datetime")
     */
    private $dateUpdate;

    /**
     * @var string $name
     *
     * @ORM\Column(name="name", type="string", length=255, unique=true)
     * @Assert\NotBlank()
     * @Assert\Length(
     *     max = "255"
     * )
     */
    private $name;

    /**
     * @var string $value
     *
     * @ORM\Column(name="value", type="text", nullable=true)
     */
    private $value;

    public function __construct($name, $value = null)
    {
        $this->setDateInsert(new \DateTime());
        $this->setDateUpdate(new \DateTime());
        $this->name = $name;
        $this->value = $value;
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
     * Set dateInsert
     *
     * @param datetime $dateInsert
     */
    public function setDateInsert($dateInsert)
    {
        $this->dateInsert = $dateInsert;
    }

    /**
     * Get dateInsert
     *
     * @return datetime
     */
    public function getDateInsert()
    {
        return $this->dateInsert;
    }

    /**
     * Set dateUpdate
     *
     * @param datetime $dateUpdate
     */
    public function setDateUpdate($dateUpdate)
    {
        $this->dateUpdate = $dateUpdate;
    }

    /**
     * Get dateUpdate
     *
     * @return datetime
     */
    public function getDateUpdate()
    {
        return $this->dateUpdate;
    }

    /**
     * Set name
     *
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set value
     *
     * @param string $value
     */
    public function setValue($value)
    {
        $this->value = $value;
    }

    /**
     * Get value
     *
     * @return string
     */
    public function getValue()
    {
        return $this->value;
    }
}
