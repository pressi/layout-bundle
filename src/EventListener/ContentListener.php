<?php
/*******************************************************************
 * (c) 2021 Stephan Preßl, www.prestep.at <development@prestep.at>
 * All rights reserved
 * Modification, distribution or any other action on or with
 * this file is permitted unless explicitly granted by IIDO
 * www.iido.at <development@iido.at>
 *******************************************************************/

namespace IIDO\LayoutBundle\EventListener;


use Contao\ArticleModel;
use Contao\ContentModel;
use Contao\CoreBundle\ServiceAnnotation\Hook;
use Contao\System;
use JetBrains\PhpStorm\Pure;


class ContentListener
{

    /**
     * @Hook("getContentElement")
     */
    public function onGetContentElement( ContentModel $contentModel, string $buffer, $element ): string
    {
        $contentUtil    = System::getContainer()->get('iido.utils.content');
        $article        = ArticleModel::findByPk( $contentModel->pid );
        $elementClasses = [];

        list($elementType, $insideClass, $tag) = $contentUtil->getContentElementData( $contentModel );
        $elementData = [$elementType, $insideClass, $tag];

        if( $article->enableColumns || $contentModel->showAsColumn )
        {
            $elementClasses[] = 'column-item';

            $elementClasses = array_merge($elementClasses, $this->getColumnClasses($contentModel, 'width'));
            $elementClasses = array_merge($elementClasses, $this->getColumnClasses($contentModel, 'align'));

//            if( $contentModel->columnSmallWidth )
//            {
//                if( $contentModel->columnSmallWidth === 'fill' )
//                {
//                    $elementClasses[] = 'col-sm';
//                }
//                else
//                {
//                    $elementClasses[] = 'col-sm-' . $contentModel->columnSmallWidth;
//                }
//            }
//
//            if( $contentModel->columnMediumWidth )
//            {
//                if( $contentModel->columnMediumWidth === 'fill' )
//                {
//                    $elementClasses[] = 'col-md';
//                }
//                else
//                {
//                    $elementClasses[] = 'col-md-' . $contentModel->columnMediumWidth;
//                }
//            }
//
//            if( $contentModel->columnLargeWidth )
//            {
//                if( $contentModel->columnLargeWidth === 'fill' )
//                {
//                    $elementClasses[] = 'col-lg';
//                }
//                else
//                {
//                    $elementClasses[] = 'col-lg-' . $contentModel->columnLargeWidth;
//                }
//            }
//
//            if( $contentModel->columnXLargeWidth )
//            {
//                if( $contentModel->columnXLargeWidth === 'fill' )
//                {
//                    $elementClasses[] = 'col-xl';
//                }
//                else
//                {
//                    $elementClasses[] = 'col-xl-' . $contentModel->columnXLargeWidth;
//                }
//            }
//
//            if( $contentModel->columnXXLargeWidth )
//            {
//                if( $contentModel->columnXXLargeWidth === 'fill' )
//                {
//                    $elementClasses[] = 'col-xxl';
//                }
//                else
//                {
//                    $elementClasses[] = 'col-xxl-' . $contentModel->columnXXLargeWidth;
//                }
//            }
        }

        $buffer = $contentUtil->addClassesToContentElement( $buffer, $contentModel, $elementClasses, $elementData );

        return $buffer;
    }



    protected function getColumnClasses(ContentModel $contentModel, string $mode, string $breakpoint = ''): array
    {
        $varName    = 'column' . ucfirst($breakpoint) . ucfirst($mode);
        $value      = $contentModel->{$varName};

        $prefix     = $this->getModePrefix( $mode, 'self' );
        $classes    = [];

        if( !$breakpoint )
        {
            if( $value && $prefix === 'col' && $value !== 'fill' )
            {
                $classes[] = $prefix . '-' . $value;
            }
            else
            {
                $classes[] = $prefix;
            }

            $breakpoints = ['Small', 'Medium', 'Large', 'XLarge', 'XXLarge'];

            foreach( $breakpoints as $breakpoint )
            {
                $bpPrefix   = $this->getBreakpointPrefix( $breakpoint );
                $varName    = 'column' . ucfirst($breakpoint) . ucfirst($mode);

                $value      = $contentModel->{$varName};

                if( $value )
                {
                    if( $value === 'fill' && $prefix === 'col' )
                    {
                        $classes[] = $prefix . '-' . $bpPrefix;
                    }
                    else
                    {
                        $classes[] = $prefix . '-' . $bpPrefix . '-' . $value;
                    }
                }
            }
        }
        else
        {
            $bpPrefix   = $this->getBreakpointPrefix( $breakpoint );

            if( $value )
            {
                if( $value === 'fill' && $prefix === 'col' )
                {
                    $classes[] = $prefix . '-' . $bpPrefix;
                }
                else
                {
                    $classes[] = $prefix . '-' . $bpPrefix . '-' . $value;
                }
            }
        }

        return $classes;
    }



    protected function getModePrefix( string $mode, $submode = 'items' ): string
    {
        return match (strtolower($mode))
        {
            "align" => 'align-' . $submode,
            "justify" => 'justify-content',
            "order" => 'order',
            "offset" => 'offset',
            default => 'col'
        };
    }



    protected function getBreakpointPrefix( string $breakpoint ): string
    {
        return match (strtolower($breakpoint))
        {
            "small" => 'sm',
            "medium" => 'md',
            "large" => 'lg',
            "xlarge" => 'xl',
            "xxlarge" => 'xxl',
            default => '',
        };
    }
}
