<?php

declare(strict_types=1);

namespace App\Tests\Controller\Admin;

use App\Controller\Admin\DashboardController;
use App\Tests\Common\WebTestCase;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;

class DashboardControllerTest extends WebTestCase
{
    public function testIndex(): void
    {
        $client = static::createClient();
        $response = $client->request(self::METHOD_GET,'/');

        $this->assertEquals(302, $response->getStatusCode());
    }

    public function testConfigureDashboard(): void
    {
        $dashboardController = $this->getContainer()->get(DashboardController::class);

        $this->assertInstanceOf(Dashboard::class, $dashboardController->configureDashboard());
    }

    public function testConfigureMenuItems(): void
    {
        $dashboardController = $this->getContainer()->get(DashboardController::class);

        $this->assertCount(2, iterator_to_array($dashboardController->configureMenuItems()));
    }
}
