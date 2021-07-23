<?php
/*******************************************************************
 * (c) 2021 Stephan Preßl, www.prestep.at <development@prestep.at>
 * All rights reserved
 * Modification, distribution or any other action on or with
 * this file is permitted unless explicitly granted by IIDO
 * www.iido.at <development@iido.at>
 *******************************************************************/

namespace IIDO\LayoutBundle\EventListener;


use Contao\CoreBundle\ServiceAnnotation\Hook;
use Contao\PageRegular;
use Contao\LayoutModel;
use Contao\PageModel;
use Contao\System;
use IIDO\CoreBundle\Config\IIDOConfig;
use IIDO\CoreBundle\Util\PageUtil;


class PageListener
{
    protected PageUtil $pageUtil;


    protected IIDOConfig $config;



    public function __construct( PageUtil $pageUtil, IIDOConfig $config )
    {
        $this->pageUtil = $pageUtil;
        $this->config   = $config;
    }



    /**
     * @Hook("generatePage")
     */
    public function onGeneratePage( PageModel $pageModel, LayoutModel $layout, PageRegular $pageRegular ): void
    {
        $basicUtil  = System::getContainer()->get('iido.core.util.basic');
        $rootPage   = PageModel::findByPk( $pageModel->rootId );

        if( $this->config->get('enableBootstrap') )
        {
            if( file_exists($basicUtil->getRootDir( true ) . 'files/' . $pageModel->rootAlias . '/styles/bootstrap_variables.scss') )
            {
//                $GLOBALS['TL_CSS']['bootstrap'] = 'files/' . $pageModel->rootAlias . '/styles/bootstrap_variables.scss||static';
            }
            else
            {
                if( !$rootPage->includeBootstrapSelf )
                {
                    $GLOBALS['TL_CSS']['bootstrap'] = 'vendor/2do/layout-bundle/src/Resources/intern/styles/bootstrap-full.scss||static';
                }
            }


//            $GLOBALS['TL_CSS']['bootstrap_before'] = 'vendor/2do/layout-bundle/src/Resources/intern/styles/bootstrap-before.scss||static';
//
//            if( $basicUtil->getRootDir( true ) . 'files/' . $pageModel->rootAlias . '/styles/bootstrap_variables.scss' )
//            {
//                $GLOBALS['TL_CSS']['bootstrap'] = 'files/' . $pageModel->rootAlias . '/styles/bootstrap_variables.scss||static';
//            }
//
//            $GLOBALS['TL_CSS']['bootstrap'] = 'vendor/2do/layout-bundle/src/Resources/intern/styles/bootstrap.scss||static';
        }
    }
}
