<?php


namespace Tests\Kilip\Laravel\Alice\Fixtures;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Group
 *
 * @ORM\Entity
 * @ORM\Table(name="user_group")
 *
 * @package Tests\Kilip\Laravel\Alice\Fixtures
 */
class Group
{
    /**
     * @ORM\Id()
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     *
     * @var int
     */
    private $id;

    /**
     * @ORM\Column(name="name", type="string")
     *
     * @var null|string
     */
    private $name;

    /**
     * @ORM\Column(type="datetime")
     *
     * @var null|\DateTime
     */
    private $created;

    /**
     * @ORM\Column(type="datetime")
     *
     * @var null|\DateTime
     */
    private $updated;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string|null $name
     * @return Group
     */
    public function setName(?string $name): Group
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return \DateTime|null
     */
    public function getCreated(): ?\DateTime
    {
        return $this->created;
    }

    /**
     * @param \DateTime|null $created
     * @return Group
     */
    public function setCreated(?\DateTime $created): Group
    {
        $this->created = $created;
        return $this;
    }

    /**
     * @return \DateTime|null
     */
    public function getUpdated(): ?\DateTime
    {
        return $this->updated;
    }

    /**
     * @param \DateTime|null $updated
     * @return Group
     */
    public function setUpdated(?\DateTime $updated): Group
    {
        $this->updated = $updated;
        return $this;
    }
}