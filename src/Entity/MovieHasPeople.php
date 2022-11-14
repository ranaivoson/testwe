<?php

namespace App\Entity;

use App\Repository\MovieHasPeopleRepository;
use Doctrine\ORM\Mapping as ORM;
use RuntimeException;
use Symfony\Component\Serializer\Annotation\Ignore;

#[ORM\Entity(repositoryClass: MovieHasPeopleRepository::class)]
class MovieHasPeople
{
    public CONST ENUM_SIGNIFICANCE = ['principal', 'secondaire'];

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Ignore]
    #[ORM\ManyToOne(inversedBy: 'movieHasPeople')]
    #[ORM\JoinColumn(name: 'Movie_id', referencedColumnName: 'id', nullable: false)]
    private ?Movie $movie = null;

    #[Ignore]
    #[ORM\ManyToOne(inversedBy: 'movieHasPeople')]
    #[ORM\JoinColumn(name: 'People_id', referencedColumnName: 'id',nullable: false)]
    private ?People $people = null;

    #[ORM\Column(length: 255)]
    private ?string $role = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $significance = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMovie(): ?Movie
    {
        return $this->movie;
    }

    public function setMovie(?Movie $movie): self
    {
        $this->movie = $movie;

        return $this;
    }

    public function getPeople(): ?People
    {
        return $this->people;
    }

    public function setPeople(?People $people): self
    {
        $this->people = $people;

        return $this;
    }

    public function getRole(): ?string
    {
        return $this->role;
    }

    public function setRole(string $role): self
    {
        $this->role = $role;

        return $this;
    }

    public function getSignificance(): ?string
    {
        return $this->significance;
    }

    public function setSignificance(?string $significance): self
    {
        if (!is_null($significance) && !in_array($significance, self::ENUM_SIGNIFICANCE, true)){
            throw new RuntimeException('Significance should be : '. implode(' - ',self::ENUM_SIGNIFICANCE));
        }

        $this->significance = $significance;

        return $this;
    }
}
