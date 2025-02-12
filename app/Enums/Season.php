<?php

namespace App\Enums;

enum Season: string
{
    case Spring = 'spring';
    case Summer = 'summer';
    case Autumn = 'autumn';
    case Winter = 'winter';
    case All = 'all';

    public static function offsetFromCurrent(): array
    {
        $season = self::current();

        return [
            $season->name => 0,
            Season::All->name => 1,
            $season->previous()->name => 2,
            $season->next()->name => 3,
            $season->next()->next()->name => 4,
        ];
    }

    public static function current(): self
    {
        $month = date('n');

        if ($month >= 3 && $month <= 5) {
            return self::Spring;
        }

        if ($month >= 6 && $month <= 8) {
            return self::Summer;
        }

        if ($month >= 9 && $month <= 11) {
            return self::Autumn;
        }

        return self::Winter;
    }

    public function previous(): self
    {
        return match ($this) {
            self::Spring => self::Winter,
            self::Summer => self::Spring,
            self::Autumn => self::Summer,
            self::Winter => self::Autumn,
            self::All => throw new \RuntimeException('Should not happen: Unexpected call on Season->previous() with All case')
        };
    }

    public function next(): self
    {
        return match ($this) {
            self::Spring => self::Summer,
            self::Summer => self::Autumn,
            self::Autumn => self::Winter,
            self::Winter => self::Spring,
            self::All => throw new \RuntimeException('Should not happen: Unexpected call on Season->next() with All case')
        };
    }
}
