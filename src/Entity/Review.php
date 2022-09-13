<?php

namespace App\Entity;

use App\Repository\ReviewRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=ReviewRepository::class)
 */
class Review
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     * @Groups({"api_read_movies"})
     */
    private $username;

    /**
     * @ORM\Column(type="string", length=255)
     * 
     */
    private $email;

    



     /**
     * @Assert\Length(
     *      min = 100,
     *      minMessage = "Votre critique doit contenir {{ limit }} charactères minimun"
     * )
     * @ORM\Column(type="text")
     * @Groups({"api_read_movies"})
     */
    private $content;
    
     
     

    /**
     * @Assert\Range(
     *      min = 0,
     *      max = 5)
     * @ORM\Column(type="float")
     * @Groups({"api_read_movies"})
     */
    private $rating;

    /**
     * @ORM\Column(type="json")
     * @Groups({"api_read_movies"})
     */
    private $reactions = [];

    /**
     * @ORM\Column(type="datetime_immutable")
     * @Groups({"api_read_movies"})
     */
    private $watchedAt;

    /**
     * @ORM\ManyToOne(targetEntity=Movie::class, inversedBy="reviews")
     *
     */
    private $movie;

   
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getRating(): ?int
    {
        return $this->rating;
    }

    public function setRating(int $rating): self
    {
        $this->rating = $rating;

        return $this;
    }

    public function getReactions(): ?array
    {
        return $this->reactions;
    }

    public function setReactions(array $reactions): self
    {
        $this->reactions = $reactions;

        return $this;
    }

    public function getWatchedAt(): ?\DateTimeImmutable
    {
        return $this->watchedAt;
    }

    public function setWatchedAt(\DateTimeImmutable $watchedAt): self
    {
        $this->watchedAt = $watchedAt;

        return $this;
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

    

}