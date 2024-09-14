<?php declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class AuthorizeEnum extends Enum
{
    const Member = 0;
    const Owner = 1;
    const Viewer = 2;
}
