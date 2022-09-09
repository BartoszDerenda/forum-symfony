<?php

/**
 * Tags entity.
 */

namespace App\Entity;

use App\Repository\TagsRepository;
use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class Tags.
 *
 * @psalm-suppress MissingConstructor
 */
#[ORM\Entity(repositoryClass: TagsRepository::class)]
class Tags
{
    /**
     * Primary key.
     */
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private int $id;

    /**
     * Title.
     */
    #[ORM\Column(type: 'string', length: 32)]
    #[Assert\Type('string')]
    #[Assert\NotBlank]
    #[Assert\Length(min: 3, max: 32)]
    private string $title;

    /**
     * Created at.
     */
    #[ORM\Column(type: 'datetime_immutable')]
    #[Gedmo\Timestampable(on: 'create')]
    private DateTimeImmutable $createdAt;

    /**
     * Updated at.
     */
    #[ORM\Column(type: 'datetime_immutable')]
    #[Gedmo\Timestampable(on: 'update')]
    private DateTimeImmutable $updatedAt;

    /**
     * Slug.
     */
    #[ORM\Column(type: 'string', length: 32)]
    #[Assert\Type('string')]
    #[Assert\Length(min: 3, max: 32)]
    #[Gedmo\Slug(fields: ['title'])]
    private string $slug;

    /**
     * Getter for Id.
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Getter for title.
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * Setter for title.
     *
     * @return $this
     */
    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Getter for created at.
     */
    public function getCreatedAt(): DateTimeImmutable
    {
        return $this->createdAt;
    }

    /**
     * Setter for created at.
     *
     * @return $this
     */
    public function setCreatedAt(DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Getter for updated at.
     */
    public function getUpdatedAt(): DateTimeImmutable
    {
        return $this->updatedAt;
    }

    /**
     * Setter for updated at.
     *
     * @return $this
     */
    public function setUpdatedAt(DateTimeImmutable $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Getter for slug.
     */
    public function getSlug(): string
    {
        return $this->slug;
    }

    /**
     * Setter for slug.
     *
     * @return $this
     */
    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * String conversion.
     *
     * @return string
     */
    public function __toString()
    {
        return $this->title;
    }
}
