<?php
/*******************************************************************
 * (c) 2021 Stephan Preßl, www.prestep.at <development@prestep.at>
 * All rights reserved
 * Modification, distribution or any other action on or with
 * this file is permitted unless explicitly granted by IIDO
 * www.iido.at <development@iido.at>
 *******************************************************************/

$strConfTable = \IIDO\CoreBundle\Config\BundleConfig::getFileTable( __FILE__ );
$objConfTable = new \IIDO\CoreBundle\Dca\ExistTable( $strConfTable );



/**
 * Palettes
 */

$objConfTable->addLegend('layout');
$objConfTable->addFieldToLegend('enableBootstrap', 'layout');



/**
 * Fields
 */

\IIDO\CoreBundle\Dca\Field::create('enableBootstrap', 'checkbox')
    ->addToTable( $objConfTable );



$objConfTable->updateDca();
