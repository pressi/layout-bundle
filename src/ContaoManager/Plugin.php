<?php
declare(strict_types=1);

namespace IIDO\LayoutBundle\ContaoManager;


use Contao\CoreBundle\ContaoCoreBundle;
use Contao\ManagerPlugin\Bundle\BundlePluginInterface;
use Contao\ManagerPlugin\Bundle\Config\BundleConfig;
use Contao\ManagerPlugin\Bundle\Parser\ParserInterface;
use IIDO\CoreBundle\IIDOCoreBundle;
use IIDO\LayoutBundle\IIDOLayoutBundle;


class Plugin implements BundlePluginInterface
{

    /**
     * @inheritDoc
     */
    public function getBundles(ParserInterface $parser)
    {
        return [
            (new BundleConfig(IIDOLayoutBundle::class))->setLoadAfter([ContaoCoreBundle::class, IIDOCoreBundle::class])
        ];
    }
}
