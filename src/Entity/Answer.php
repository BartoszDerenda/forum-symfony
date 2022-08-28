<?php

namespace App\Entity;

use App\Repository\AnswerRepository;
use Doctrine\ORM\Mapping as ORM;
use DateTimeImmutable;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class Answer.
 *
 * @psalm-suppress MissingConstructor
 */
#[ORM\Entity(repositoryClass: AnswerRepository::class)]
#[ORM\Table(name: 'answers')]
class Answer
{
    /**
     * Primary key.
     *
     * @var int|null
     */
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    /**
     * Comment.
     *
     * @var string|null
     */
    #[ORM\Column(length: 5000)]
    private ?string $comment = null;

    /**
     * Image.
     *
     * @var string|null
     */
    #[ORM\Column(length: 100, nullable: true)]
    private ?string $image = null;

    /**
     * Created at.
     *
     * @var DateTimeImmutable|null
     */
    #[ORM\Column(type: 'datetime_immutable')]
    #[Gedmo\Timestampable(on: 'create')]
    private ?DateTimeImmutable $createdAt;

    /**
     * Updated at.
     *
     * @var DateTimeImmutable|null
     */
    #[ORM\Column(type: 'datetime_immutable')]
    #[Gedmo\Timestampable(on: 'update')]
    private ?DateTimeImmutable $updatedAt;

    /**
     * Question.
     *
     * @var Question|null
     */
    #[ORM\ManyToOne(targetEntity: Question::class)]
    #[ORM\JoinColumn(nullable: false)]
    private ?Question $question = null;

    /**
     * Author.
     *
     * @var User|null
     */
    #[ORM\ManyToOne(targetEntity: User::class)]
    #[ORM\JoinColumn(nullable: true)]
    #[Assert\Type(User::class)]
    private ?User $author = null;

    #[ORM\Column(type: 'boolean', options: ['default: 0'])]
    private ?bool $best_answer = false;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getComment(): ?string
    {
        return $this->comment;
    }

    public function setComment(string $comment): self
    {
        $this->comment = $comment;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeImmutable $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getQuestion(): ?Question
    {
        return $this->question;
    }

    public function setQuestion(?Question $question): self
    {
        $this->question = $question;

        return $this;
    }

    public function getAuthor(): ?User
    {
        return $this->author;
    }

    public function setAuthor(?User $author): self
    {
        $this->author = $author;

        return $this;
    }

    public function isBestAnswer(): ?bool
    {
        return $this->best_answer;
    }

    public function setBestAnswer(bool $best_answer): self
    {
        $this->best_answer = $best_answer;

        return $this;
    }
}
