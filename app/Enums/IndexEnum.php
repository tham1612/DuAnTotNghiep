<?php declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static High()
 * @method static static Medium()
 * @method static static Low()
 */
final class IndexEnum extends Enum
{
    const High = 'High';
    const Medium = 'Medium';
    const Low = 'Low';

    public function label(): string
    {
        return match ($this->value) {
            self::High => 'Cao',
            self::Medium => 'Trung bình',
            self::Low => 'Thấp',
            default => 'Không xác định',
        };
    }
    public static function getLimitedChoices(): array
    {
        return [
            self::High,
            self::Medium,
            self::Low,
        ];
    }

}
