<?php
/**
 * DokuWiki Plugin d3chart (Action Component)
 *
 * @MIT License
 * @author  Liheng <heng.li@realab.ai>
 */
     
// must be run within DokuWiki
if(!defined('DOKU_INC')) die();
     
if(!defined('DOKU_PLUGIN')) define('DOKU_PLUGIN',DOKU_INC.'lib/plugins/');
require_once DOKU_PLUGIN.'syntax.php';

// See help: https://www.dokuwiki.org/devel:syntax_plugins

class syntax_plugin_d3chart extends DokuWiki_Syntax_Plugin {

    public function getPType() {
        return 'block';
    }

    public function getType() {
        return 'protected';
    }

    public function getSort() {
        return 0;
    }
     
    public function connectTo($mode) {
        $this->Lexer->addEntryPattern('<d3chart.*?>(?=.*?</d3chart>)', $mode, 'plugin_d3chart');
    }
    
    public function postConnect() {
        $this->Lexer->addExitPattern('</d3chart>', 'plugin_d3chart');
    }
    
    public function handle($match, $state, $pos, Doku_Handler $handler) {
        $end = $pos + strlen($match);
        $match = base64_encode($match);
        return array($match, $state, $pos, $end);
    }

    public function render($mode, Doku_Renderer $renderer, $data) {
        // $data is returned by handle()
        if ($mode == 'xhtml'  || $mode == 'odt') {
            list($match, $state, $pos, $end) = $data;
            switch ($state) {
                case DOKU_LEXER_ENTER :  
                    $matches = array();
                    $match = base64_decode($match);
                    preg_match('/<d3chart(.*?)>/', $match, $matches);
                    $d3chartid = uniqid('__d3chart_');
                    $class = $renderer->startSectionEdit($data[$pos], 'plugin_d3chart');
                    $renderer->doc .= '<div class="' . $class . '">';
                    $renderer->doc .= '<div id="' . $d3chartid . '_chart' . '" ' . $matches[1] . '>';
                    $renderer->doc .= '<textarea class="d3chart_data" id="'.$d3chartid.'" style="visibility:hidden;">';
                    break;
                case DOKU_LEXER_UNMATCHED :  
                    $renderer->doc .= trim($match);
                    break;
                case DOKU_LEXER_EXIT :       
                    $renderer->doc .= '</textarea>';
                    $renderer->doc .= '</div>';
                    $renderer->doc .= '</div>';
                    $renderer->doc .= '<textarea style="visibility:hidden;">' . 'blank line' . '</textarea>';
                    $renderer->finishSectionEdit($data[$end]);
                    break;
            }
            return true;
        }
        return false;
    }
}

