<?php
/**
 * Tags fixtures.
 */

namespace App\DataFixtures;

use App\Entity\Tags;
use DateTimeImmutable;

/**
 * Class TagsFixtures.
 *
 * @psalm-suppress MissingConstructor
 */
class TagsFixtures extends AbstractBaseFixtures
{
    /**
     * Load data.
     *
     * @psalm-suppress PossiblyNullReference
     * @psalm-suppress UnusedClosureParam
     */
    public function loadData(): void
    {
        $this->createMany(50, 'tags', function (int $i) {
            $tags = new Tags();
            $tags->setTitle($this->faker->unique()->word);
            $tags->setCreatedAt(
                DateTimeImmutable::createFromMutable(
                    $this->faker->dateTimeBetween('-100 days', '-1 days')
                )
            );
            $tags->setUpdatedAt(
                DateTimeImmutable::createFromMutable(
                    $this->faker->dateTimeBetween('-100 days', '-1 days')
                )
            );

            return $tags;
        });

        $this->manager->flush();
    }
}
