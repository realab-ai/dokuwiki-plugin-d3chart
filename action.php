<?php
/**
 * DokuWiki Plugin d3chart (Action Component)
 *
 * @MIT License
 * @author  Liheng <heng.li@realab.ai>
 */

// must be run within Dokuwiki
if(!defined('DOKU_INC')) die();

class action_plugin_d3chart extends DokuWiki_Action_Plugin {

    /**
     * Registers a callback function for a given event
     *
     * @param Doku_Event_Handler $controller DokuWiki's event controller object
     * @return void
     */
    public function register(Doku_Event_Handler $controller) {

       $controller->register_hook('TPL_METAHEADER_OUTPUT', 'BEFORE', $this, 'handle_tpl_metaheader_output');
       $controller->register_hook('TOOLBAR_DEFINE', 'AFTER', $this, 'toolbar');
    }

    /**
     * [Custom event handler which performs action]
     *
     * @param Doku_Event $event  event object by reference
     * @param mixed      $param  [the parameters passed as fifth argument to register_hook() when this
     *                           handler was registered]
     * @return void
     */

    public function handle_tpl_metaheader_output(Doku_Event &$event, $param) {
        $event->data["script"][] = array (
            "type" => "text/javascript",
            "src" => $this->get_asset('url_d3'),
            "_data" => "",
        );
        $event->data["script"][] = array (
            "type" => "text/javascript",
            "src" => $this->get_asset('url_d3force'),
            "_data" => "",
        );
        $event->data["script"][] = array (
            "type" => "text/javascript",
            "src" => $this->get_asset('url_jqscript'),
            "_data" => "",
        );
        $event->data["link"][] = array (
            "type" => "text/css",
            "rel" => "stylesheet",
            "href" => $this->get_asset('url_d3force_css'),
        );
    }

    /**
     * Add a button for inserting tables to the toolbar array
     *
     * @param Doku_Event $event
     */
    function toolbar($event) {
        $event->data[] = array(
            'type'  => 'picker',
            'title' => $this->getLang('spec-d3-charts'),
            'icon'  => '../../plugins/d3chart/images/d3chart.png',
            'list' => array(
                array(
                    'type'   => 'format',
                    'title'  => $this->getLang('btn-d3force-create'),
                    'icon'   => '../../plugins/d3chart/images/d3force.png',
                    'key' => 'f',
                    'open' => '<d3chart '. $this->get_d3force_config_text().'>\n',
                    'sample' => $this->get_d3force_example_text(),
                    'close' => '</d3chart>\n',
                ),
            ),
        );
    }
        
    private function get_d3force_config_text() {
        return 'type="force" debug=0 minNodeRadius=13 maxNodeRadius=36 colorScheme="color20" dragMode=1 showLabels=1 labelsCircular=0 labelDistance=13 showTooltips=1 tooltipPosition="node" linkDistance=78 showLinkDirection=0 useDomParentWidth=0 height=618 showBorder=0 showLegend=1 lassoMode=0 zoomMode=0 nodeEventToOpenLink="click" nodeLinkTarget="none"';
    }
    
    private function get_d3force_example_text() {
         return '{
  "data":{
    "nodes":[
      {
        "ID":"7839",
        "LABEL":"KING is THE KING, you know?",
        "COLORVALUE":"10",
        "COLORLABEL":"Accounting",
        "SIZEVALUE":5000,
        "LABELCIRCULAR":true,
        "LINK":"http://apex.oracle.com/",
        "INFOSTRING":"This visualization is based on the well known emp table."
      },
      {
        "ID":"7698",
        "LABEL":"BLAKE",
        "COLORVALUE":"30",
        "COLORLABEL":"Sales",
        "SIZEVALUE":2850
      }
    ],
    "links":[
      {
        "FROMID":"7839",
        "TOID":"7839",
        "STYLE":"dotted",
        "COLOR":"blue",
        "INFOSTRING":"This is a self link (same source and target node) rendered along a path with the STYLE attribute set to dotted and COLOR attribute set to blue."
      },
      {
        "FROMID":"7698",
        "TOID":"7839",
        "STYLE":"dashed"
      }
    ]
  }
}\n';
    }
    
    private function get_asset($asset) {
        $u = $this->getConf($asset);
        if(!preg_match('#^(?:(?:https?:)?/)?/#', $u)) {
            $info = $this->getInfo();
            $u = DOKU_BASE."lib/plugins/".$info['base']."/assets/".$u;
        }
        return $u;
    }

}

// vim:ts=4:sw=4:et:

