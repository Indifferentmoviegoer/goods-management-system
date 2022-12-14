<?php

declare(strict_types=1);

namespace App\Helper;

class ImportHelper
{
    public static function initImportOptions(?bool $isSafeMode = true): bool
    {
        $isUnlimitedTime = set_time_limit(0);
        $isUnlimitedMemory = (bool)ini_set('memory_limit', '-1');

        return $isSafeMode ? $isUnlimitedMemory : $isUnlimitedTime && $isUnlimitedMemory;
    }
}
