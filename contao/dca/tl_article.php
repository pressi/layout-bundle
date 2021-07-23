<?php

$strArticleFileName = \IIDO\CoreBundle\Config\BundleConfig::getFileTable( __FILE__ );
$objArticleTable    = new \IIDO\CoreBundle\Dca\ExistTable( $strArticleFileName );

$config     = System::getContainer()->get('iido.core.config');
$objArticle = false;

$breakpoints = ['Small', 'Medium', 'Large', 'XLarge', 'XXLarge'];


if( Input::get('act') === 'edit' )
{
    $objArticle = \Contao\ArticleModel::findByPk( Input::get('id') );
}



/**
 * Palettes
 */

if( $config->get('includeArticleFields') )
//if( \IIDO\CoreBundle\Config\IIDOConfig::get('includeArticleFields') )
{
    $arrFields      = \Contao\StringUtil::deserialize( $config->get('articleFields'), true);
    $arrContent     = [];



    // Content

    if( in_array('columns', $arrFields) )
    {
        $arrContent[] = 'enableColumns';
    }

    if( count( $arrContent ) )
    {
        $objArticleTable->addLegend('content', 'layout');
        $objArticleTable->addFieldToLegend($arrContent, 'content');
    }
}



/**
 * Subpalettes
 */

//$cols       = ['Cols', 'Align', 'Justify', 'Order', 'Offset'];
$cols       = ['Cols', 'Align', 'Justify'];
$columns    = ['containerWidth', 'gutterSize'];
$subColumns = ['gutterYSize'];

foreach( $breakpoints as $breakpoint )
{
    $columns[] = 'gutter' . $breakpoint . 'Size';
}

$columns[] = 'otherYGutterSize';


foreach( $cols as $col )
{
    $columns[] = 'column' . $col;

    foreach( $breakpoints as $breakpoint )
    {
        $columns[] = 'column' . $breakpoint . $col;
    }
}

foreach( $breakpoints as $breakpoint )
{
    $subColumns[] = 'gutterY' . $breakpoint . 'Size';
}

$objArticleTable->addSubpalette('enableColumns', $columns);
$objArticleTable->addSubpalette('otherYGutterSize', $subColumns);



/**
 * Fields
 */

\IIDO\CoreBundle\Dca\Field::create('enableColumns', 'checkbox')
    ->setAsSelector()
    ->addToTable( $objArticleTable );

\IIDO\CoreBundle\Dca\Field::create('containerWidth', 'select')
    ->addEval('includeBlankOption', true)
    ->addEval('tl_class', 'clr w50')
    ->addEval('helpwizard', true)
    ->addConfig('explanation', 'containerWidth')
    ->addToTable( $objArticleTable );

\IIDO\CoreBundle\Dca\Field::create('gutterSize', 'select')
    ->addEval('includeBlankOption', true)
    ->addEval('tl_class', 'clr w16 label-nobreak')
    ->addEval('helpwizard', true)
    ->addConfig('explanation', 'gutterSize')
    ->addToTable( $objArticleTable );

\IIDO\CoreBundle\Dca\Field::create('otherYGutterSize', 'checkbox')
    ->setAsSelector()
    ->addEval('tl_class', 'clr w50', true)
    ->addToTable( $objArticleTable );

\IIDO\CoreBundle\Dca\Field::create('gutterYSize', 'select')
    ->addOptionsName('gutterSize')
    ->addEval('includeBlankOption', true)
    ->addEval('tl_class', 'clr w16 label-nobreak')
    ->addEval('helpwizard', true)
    ->addConfig('explanation', 'gutterSize')
    ->addToTable( $objArticleTable );

foreach( $cols as $col)
{
    \IIDO\CoreBundle\Dca\Field::create('column' . $col, 'select')
        ->setLangTable('tl_content')
        ->addEval('includeBlankOption', true)
        ->addEval('tl_class', 'w16 clr label-no-break')
        ->addToTable( $objArticleTable );
}

foreach( $breakpoints as $breakpoint )
{
    \IIDO\CoreBundle\Dca\Field::create('gutter' . $breakpoint . 'Size', 'select')
        ->addOptionsName('gutterSize')
        ->addEval('includeBlankOption', true)
        ->addEval('tl_class', 'w16')
        ->addToTable( $objArticleTable );

    \IIDO\CoreBundle\Dca\Field::create('gutterY' . $breakpoint . 'Size', 'select')
        ->addOptionsName('gutterSize')
        ->addEval('includeBlankOption', true)
        ->addEval('tl_class', 'w16')
        ->addToTable( $objArticleTable );

    foreach( $cols as $col)
    {
        \IIDO\CoreBundle\Dca\Field::create('column' . $breakpoint . $col, 'select')
            ->setLangTable('tl_content')
            ->addOptionsName('column' . $col)
            ->addEval('includeBlankOption', true)
            ->addEval('tl_class', 'w16')
            ->addToTable( $objArticleTable );
    }
}



$objArticleTable->updateDca();
