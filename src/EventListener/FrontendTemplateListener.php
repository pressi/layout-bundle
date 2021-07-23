<?php
declare(strict_types=1);

/*******************************************************************
 * (c) 2020 Stephan Preßl, www.prestep.at <development@prestep.at>
 * All rights reserved
 * Modification, distribution or any other action on or with
 * this file is permitted unless explicitly granted by IIDO
 * www.iido.at <development@iido.at>
 *******************************************************************/

namespace IIDO\LayoutBundle\EventListener;


use Contao\ArticleModel;
use Contao\CoreBundle\ServiceAnnotation\Hook;
use Contao\StringUtil;


class FrontendTemplateListener
{

    /**
     * @Hook("parseFrontendTemplate")
     */
    public function onParseFrontendTemplate( string $buffer, string $templateName ): string
    {
        global $objPage;
        /* @var \PageModel $objPage */

        if( str_starts_with($templateName, 'mod_article') )
        {
            if( str_starts_with($templateName, 'mod_articlenav') )
            {
                return $buffer;
            }

            $article = false;

            preg_match_all('/id="([A-Za-z0-9\-_]{0,})"/', $buffer, $idMatches);

            if( is_array($idMatches) && count($idMatches[0]) > 0 )
            {
                $idOrAlias = $idMatches[1][0];

                if( str_starts_with($idOrAlias, 'article-') )
                {
                    $idOrAlias = preg_replace('/^article-/', '', $idOrAlias);
                }

                $article = ArticleModel::findByIdOrAlias( $idOrAlias );
            }

            if( $article && $article->noContent )
            {
                return '';
            }


            $cssID = StringUtil::deserialize($article->cssID, TRUE);
            $articleClasses = [];
//            $strBuffer = ArticleTemplateRenderer::parseTemplate( $strBuffer, $templateName );

            $columnContOpen = $columnContClose = '';

            if( $article->enableColumns )
            {
                $columnContOpen     = '<div class="container"><div class="row">';
                $columnContClose    = '</div></div>';

                echo "<pre>"; print_r( $buffer ); exit;
            }

//            $buffer = \preg_replace('/<div([A-Za-z0-9\s\-,;.:\(\)?!_\{\}="]+)class="mod_article([A-Za-z0-9\s\-,;.:\(\)?!_\{\}]{0,})"([A-Za-z0-9\s\-,;.:\(\)?!_\{\}="]{0,})>/', '<section$1class="mod_article' . ($articleClasses ? ' ' . implode(' ', $articleClasses) : '') . '$2"$3><div class="article-inside">' . $columnContOpen, $buffer, 1, $count);

//            if( $count )
//            {
//                $buffer .= $columnContClose . '</section>';
//            }
        }

        return $buffer;
    }

}
