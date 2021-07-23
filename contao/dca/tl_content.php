<?php

$strContentFileName = \IIDO\CoreBundle\Config\BundleConfig::getFileTable( __FILE__ );
$objContentTable = new \IIDO\CoreBundle\Dca\ExistTable( $strContentFileName );

$content = $article = false;
$breakpoints = ['Small', 'Medium', 'Large', 'XLarge', 'XXLarge'];

if( Input::get('act') === 'edit' )
{
    $content = ContentModel::findByPk( Input::get('id') );
    $article = ArticleModel::findByPk( $content->pid );
}



/**
 * Palettes
 */

//$cols       = ['Width', 'Align', 'Justify', 'Order', 'Offset'];
$cols       = ['Width', 'Align', 'Order', 'Offset'];
$columns    = [];

foreach( $cols as $col )
{
    $columns[] = 'column' . $col;

    foreach( $breakpoints as $breakpoint )
    {
        $columns[] = 'column' . $breakpoint . $col;
    }
}

$objContentTable->addLegend('column', 'expert', 'before', 'all');

if( $article && $article->enableColumns )
{
    $objContentTable->addFieldToLegend($columns, 'column', 'append', 'all');
}
else
{
    $objContentTable->addFieldToLegend(['enableColumns'], 'column', 'append', 'all');
}



/**
 * Subpalette
 */

$objContentTable->addSubpalette('enableColumns', $columns);



/**
 * Fields
 */

foreach( $cols as $col)
{
    \IIDO\CoreBundle\Dca\Field::create('column' . $col, 'select')
        ->addEval('includeBlankOption', true)
        ->addEval('tl_class', 'w16 label-nobreak')
        ->addToTable( $objContentTable );
}


foreach( $breakpoints as $breakpoint )
{
    foreach( $cols as $col)
    {
        \IIDO\CoreBundle\Dca\Field::create('column' . $breakpoint . $col, 'select')
            ->addOptionsName('column' . $col)
            ->addEval('includeBlankOption', true)
            ->addEval('tl_class', 'w16')
            ->addToTable( $objContentTable );
    }

//    \IIDO\CoreBundle\Dca\Field::create('column' . $breakpoint . 'Align', 'select')
//        ->addOptionsName('columnAlign')
//        ->addEval('includeBlankOption', true)
//        ->addEval('tl_class', 'w16')
//        ->addToTable( $objContentTable );

//    \IIDO\CoreBundle\Dca\Field::create('column' . $breakpoint . 'Justify', 'select')
//        ->addOptionsName('columnJustify')
//        ->addEval('includeBlankOption', true)
//        ->addEval('tl_class', 'w16')
//        ->addToTable( $objContentTable );

//    \IIDO\CoreBundle\Dca\Field::create('column' . $breakpoint . 'Order', 'select')
//        ->addOptionsName('columnOrder')
//        ->addEval('includeBlankOption', true)
//        ->addEval('tl_class', 'w16')
//        ->addToTable( $objContentTable );

//    \IIDO\CoreBundle\Dca\Field::create('column' . $breakpoint . 'Offset', 'select')
//        ->addOptionsName('columnOffset')
//        ->addEval('includeBlankOption', true)
//        ->addEval('tl_class', 'w16')
//        ->addToTable( $objContentTable );
}

//\IIDO\CoreBundle\Dca\Field::create('columnWidth', 'select')
//    ->addEval('tl_class', 'w16')
//    ->addToTable( $objContentTable );

//\IIDO\CoreBundle\Dca\Field::create('columnAlign', 'select')
//    ->addEval('includeBlankOption', true)
//    ->addEval('tl_class', 'w16')
//    ->addToTable( $objContentTable );

//\IIDO\CoreBundle\Dca\Field::create('columnJustify', 'select')
//    ->addEval('includeBlankOption', true)
//    ->addEval('tl_class', 'w16')
//    ->addToTable( $objContentTable );

//\IIDO\CoreBundle\Dca\Field::create('columnOrder', 'select')
//    ->addEval('includeBlankOption', true)
//    ->addEval('tl_class', 'w16')
//    ->addToTable( $objContentTable );

//\IIDO\CoreBundle\Dca\Field::create('columnOffset', 'select')
//    ->addEval('includeBlankOption', true)
//    ->addEval('tl_class', 'w16')
//    ->addToTable( $objContentTable );


//\IIDO\CoreBundle\Dca\Field::create('columnSmallWidth', 'select')
//    ->addOptionsName('columnWidth')
//    ->addEval('includeBlankOption', true)
//    ->addEval('tl_class', 'w16')
//    ->addToTable( $objContentTable );
//
//\IIDO\CoreBundle\Dca\Field::create('columnMediumWidth', 'select')
//    ->addOptionsName('columnWidth')
//    ->addEval('includeBlankOption', true)
//    ->addEval('tl_class', 'w16')
//    ->addToTable( $objContentTable );
//
//\IIDO\CoreBundle\Dca\Field::create('columnLargeWidth', 'select')
//    ->addOptionsName('columnWidth')
//    ->addEval('includeBlankOption', true)
//    ->addEval('tl_class', 'w16')
//    ->addToTable( $objContentTable );
//
//\IIDO\CoreBundle\Dca\Field::create('columnXLargeWidth', 'select')
//    ->addOptionsName('columnWidth')
//    ->addEval('includeBlankOption', true)
//    ->addEval('tl_class', 'w16')
//    ->addToTable( $objContentTable );
//
//\IIDO\CoreBundle\Dca\Field::create('columnXXLargeWidth', 'select')
//    ->addOptionsName('columnWidth')
//    ->addEval('includeBlankOption', true)
//    ->addEval('tl_class', 'w16')
//    ->addToTable( $objContentTable );


$objContentTable->updateDca();

//echo "<pre>"; print_r( $GLOBALS['TL_DCA'][ $strContentFileName ] ); exit;
