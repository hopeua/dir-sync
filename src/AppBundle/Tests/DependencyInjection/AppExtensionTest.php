<?php
namespace AppBundle\Tests\DependencyInjection;

use AppBundle\DependencyInjection\AppExtension;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class AppExtensionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var AppExtension
     */
    private $extension;

    public function setUp()
    {
        parent::setUp();

        $this->extension = $this->getExtension();
    }

    public function testParametersSet()
    {
        $config = [
            'sync' => [
                'master' => [
                    'storage' => 'local',
                    'path'    => '/test/path',
                    'filters' => [],
                ],
                'slave' => [
                    'storage'  => 'local',
                    'path'     => '/test/path',
                    'path_tpl' => '/test/path/tpl',
                    'filters'  => [],
                ],
            ],
        ];

        $this->extension->load($config, $container = $this->getContainer());

        // Test parameters
        $parameters = [
            'master.path',
            'master.filters',
            'slave.path',
            'slave.path_tpl',
            'slave.filters',
        ];

        foreach ($parameters as $param) {
            $this->assertTrue($container->hasParameter($param));
        }

        // Test storage alias
        $this->assertTrue($container->hasAlias('master.storage'));
        $this->assertTrue($container->hasAlias('slave.storage'));
    }

    protected function getExtension()
    {
        return new AppExtension();
    }

    private function getContainer()
    {
        $container = new ContainerBuilder();

        return $container;
    }
}
