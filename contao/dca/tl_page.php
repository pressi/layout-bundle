<?php
/*******************************************************************
 * (c) 2021 Stephan Preßl, www.prestep.at <development@prestep.at>
 * All rights reserved
 * Modification, distribution or any other action on or with
 * this file is permitted unless explicitly granted by IIDO
 * www.iido.at <development@iido.at>
 *******************************************************************/

$strPageTable = \IIDO\CoreBundle\Config\BundleConfig::getFileTable( __FILE__ );
$objPageTable = new \IIDO\CoreBundle\Dca\ExistTable( $strPageTable );

$config  = System::getContainer()->get('iido.core.config');

//$page = $rootPage = false;
//
//if( \Contao\Input::get('act') === 'edit' )
//{
//    $page = \Contao\PageModel::findByPk( \Contao\Input::get('id') );
//
//    if( $page )
//    {
//        $page = $page->loadDetails();
//
//        $rootPage = \Contao\PageModel::findByPk( $page->rootId );
//    }
//}


/**
 * Palettes
 */

if( $config->get('enableBootstrap') )
{
    $objPageTable->replacePaletteFields(['root', 'rootfallback'], ',includeLayout', ',includeLayout,includeBootstrapSelf');
}



/**
 * Fields
 */

\IIDO\CoreBundle\Dca\Field::create('includeBootstrapSelf', 'checkbox')
    ->addToTable( $objPageTable );



$objPageTable->updateDca();
