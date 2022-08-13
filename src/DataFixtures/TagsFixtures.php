<?php
/**
 * Tags fixtures.
 */

namespace App\DataFixtures;

use App\Entity\Tags;

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
            $tag = new Tags();
            $tag->setTitle($this->faker->unique()->word);

            return $tag;
        });

        $this->manager->flush();
    }
}
