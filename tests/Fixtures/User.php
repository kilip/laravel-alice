<?php


namespace Tests\Kilip\Laravel\Alice\Fixtures;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class User
 * @ORM\Entity
 * @ORM\Table(name="user")
 * @package Tests\Kilip\Laravel\Alice\Fixtures
 */
class User
{
    /**
     * @ORM\Id()
     * @ORM\Column(name="id",type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     *
     * @var integer
     */
    private $id;

    /**
     * @ORM\Column(name="username", type="string")
     * @var null|string
     */
    private $username;

    /**
     * @ORM\Column(type="string")
     * @var null|string
     */
    private $fullname;

    /**
     * @ORM\Column(name="birth_date", type="date")
     * @var \DateTime
     */
    private $birthDate;

    /**
     * @ORM\Column(type="string", nullable=true)
     * @var null|string
     */
    private $email;

    /**
     * @ORM\Column(type="integer",nullable=true)
     * @var integer
     */
    private $favoriteNumber;

    /**
     * @ORM\ManyToOne(targetEntity="Group", cascade={"persist"})
     * @ORM\JoinColumn(name="group_id", referencedColumnName="id")
     * @var Group
     */
    private $group;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return Group
     */
    public function getGroup(): Group
    {
        return $this->group;
    }

    /**
     * @param Group $group
     * @return User
     */
    public function setGroup(Group $group): User
    {
        $this->group = $group;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getUsername(): ?string
    {
        return $this->username;
    }

    /**
     * @param string|null $username
     * @return User
     */
    public function setUsername(?string $username): User
    {
        $this->username = $username;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getFullname(): ?string
    {
        return $this->fullname;
    }

    /**
     * @param string|null $fullname
     * @return User
     */
    public function setFullname(?string $fullname): User
    {
        $this->fullname = $fullname;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getBirthDate(): \DateTime
    {
        return $this->birthDate;
    }

    /**
     * @param \DateTime $birthDate
     * @return User
     */
    public function setBirthDate(\DateTime $birthDate): User
    {
        $this->birthDate = $birthDate;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * @param string|null $email
     * @return User
     */
    public function setEmail(?string $email): User
    {
        $this->email = $email;
        return $this;
    }

    /**
     * @return int
     */
    public function getFavoriteNumber(): int
    {
        return $this->favoriteNumber;
    }

    /**
     * @param null|int $favoriteNumber
     * @return User
     */
    public function setFavoriteNumber($favoriteNumber): User
    {
        $this->favoriteNumber = $favoriteNumber;
        return $this;
    }
}