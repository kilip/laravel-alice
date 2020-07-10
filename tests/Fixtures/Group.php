<?php

/*
 * This file is part of the Kilip Laravel Alice project.
 *
 * (c) Anthonius Munthi <https://itstoni.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Tests\Kilip\Laravel\Alice\Fixtures;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Group.
 *
 * @ORM\Entity
 * @ORM\Table(name="user_group")
 */
class Group
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     *
     * @var int
     */
    private $id;

    /**
     * @ORM\Column(name="name", type="string")
     *
     * @var string|null
     */
    private $name;

    /**
     * @ORM\Column(type="datetime")
     *
     * @var \DateTime|null
     */
    private $created;

    /**
     * @ORM\Column(type="datetime")
     *
     * @var \DateTime|null
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
     *
     * @return Group
     */
    public function setName(?string $name): self
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
     *
     * @return Group
     */
    public function setCreated(?\DateTime $created): self
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
     *
     * @return Group
     */
    public function setUpdated(?\DateTime $updated): self
    {
        $this->updated = $updated;

        return $this;
    }
}
