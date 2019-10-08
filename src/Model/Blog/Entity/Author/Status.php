<?php

namespace App\Model\Blog\Entity\Author;


use Webmozart\Assert\Assert;

class Status
{
    public const ACTIVE = 'active';
    public const ARCHIVED = 'archived';

    private $name;

    public function __construct(string $name)
    {
        Assert::oneOf($name, [
            self::ACTIVE,
            self::ARCHIVED,
        ]);

        $this->name = $name;
    }

    public static function active(): self
    {
        return new self(self::ACTIVE);
    }

    public static function archived(): self
    {
        return new self(self::ARCHIVED);
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function isActive(): bool
    {
        return $this->name === self::ACTIVE;
    }

    public function isArchived(): bool
    {
        return $this->name === self::ARCHIVED;
    }
}