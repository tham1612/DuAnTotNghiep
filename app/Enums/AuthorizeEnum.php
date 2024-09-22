<?php declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static Member()
 * @method static static Owner()
 * @method static static Viewer()
 */
final class AuthorizeEnum extends Enum
{
    const Member = 'Member';
    const Owner = 'Owner';
    const Viewer = 'Viewer';

    /**
     * Trả về nhãn thân thiện cho từng giá trị Enum
     */
    public function label(): string
    {
        switch ($this->value) {
            case self::Member:
                return 'Thành viên';
            case self::Owner:
                return 'Chủ sở hữu';
            case self::Viewer:
                return 'Người xem';
            default:
                return 'Không xác định';
        }
    }
    public static function getLimitedChoices(): array
    {
        return [
            self::Member,
            self::Owner,
            self::Viewer,
        ];
    }
}

