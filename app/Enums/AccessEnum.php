<?php declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class AccessEnum extends Enum
{
    const public = 'public';
    const private = 'private';
    const workspace = 'workspace';


}