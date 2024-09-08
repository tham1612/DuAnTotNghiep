<?php declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class IndexEnum extends Enum
{
    const High = 'High';
    const Medium = 'Medium';
    const Low = 'Low';
}