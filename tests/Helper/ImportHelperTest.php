<?php

declare(strict_types=1);

namespace App\Tests\Helper;

use App\Helper\ImportHelper;
use App\Tests\Common\WebTestCase;

class ImportHelperTest extends WebTestCase
{
    public function testInitImportOptions(): void
    {
        $this->assertEquals(true, ImportHelper::initImportOptions());
    }
}
