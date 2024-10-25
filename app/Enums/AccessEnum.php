<?php declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static PublicAccess()
 * @method static static PrivateAccess()

 */
final class AccessEnum extends Enum
{
    const PUBLIC_ACCESS = 'public';
    const PRIVATE_ACCESS = 'private';

    public function label(): string
    {
        return match ($this->value) {
            self::PUBLIC_ACCESS => 'Công khai',
            self::PRIVATE_ACCESS => 'Riêng tư',
            default => 'Không xác định',
        };
    }
    public static function getLimitedChoices(): array
    {
        return [
            self::PRIVATE_ACCESS,
            self::PUBLIC_ACCESS,
        ];
    }
    public static function isPublic(string $access): bool
{
    return $access === self::PUBLIC_ACCESS;
}


}
