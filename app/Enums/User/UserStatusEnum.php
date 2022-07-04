<?php

namespace App\Enums\User;

use Illuminate\Support\Str;

enum UserStatusEnum: int
{
    case ACTIVE = 1;
    case IN_ACTIVE = 2;

    public function description(): string
    {
        return match ($this) {
            self::ACTIVE => 'Active',
            self::IN_ACTIVE => 'In Active',
        };
    }

    public function filamentTableColor(): string
    {
        return match ($this) {
            self::ACTIVE => 'success',
            self::IN_ACTIVE => 'danger',
        };
    }

    public function filamentTableColorMatcher(): array
    {
        return [
            $this->filamentTableColor() => function () {
                return true;
            },
        ];
    }

    public function hexColor(): string
    {
        $rgbColor = Str::of($this->rbgColor())
            ->remove(['rgb(', ')'])
            ->explode(', ');

        return sprintf('#%02x%02x%02x', ...$rgbColor);
    }

    public function rbgColor(): string
    {
        return match ($this) {
            self::ACTIVE => 'rgb(25, 135, 84)',
            self::IN_ACTIVE => 'rgb(220, 53, 69)',
        };
    }
}
