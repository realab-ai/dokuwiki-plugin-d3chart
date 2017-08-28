/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

function resizeGraphContainer() {
    setTimeout(function(){
        jQuery("div[id^='__d3chart_'][id$='_chart']").each(function(i, tag) { try {
            var id = jQuery(tag).attr('id');
            var graph = jQuery('#' + id);
            var toc = jQuery('#dw__toc');
            var dWidth = parseInt(graph.parent().css('width')) -
                ( toc.css('float') === 'right' && parseInt(toc.css('height')) > 30 ? parseInt(toc.css('width')) : 0 );
            window.d3chart.get(id).width(dWidth).resume();
        }catch(err){
            console.warn(err.message);
        }});
    }, 500);
}
jQuery(document).ready(function(){
    if (typeof(window.d3chart)==="undefined") {
        window.d3chart = new Map();
    }
    jQuery("div[id^=__d3chart_][id$=_chart]").each(function(i, oChart) { try {
        var tag = jQuery(oChart).find("textarea[id^=__d3chart_]");
        var data = jQuery(tag).text();
        data = decodeURIComponent(escape(window.atob(data)));
        var id = jQuery(oChart).attr('id');
        
        var sType = jQuery(oChart).attr('type');
        switch(sType){
        case 'force':
            window.d3chart.set(id, netGobrechtsD3Force(id));
            var bDebug = jQuery(oChart).attr('debug');
            if (typeof(bDebug)!=="undefined") window.d3chart.get(id).debug(Number(bDebug));
            
            var nMinNodeRadius = jQuery(oChart).attr('minNodeRadius');
            if (typeof(nMinNodeRadius)!=="undefined") window.d3chart.get(id).minNodeRadius(Number(nMinNodeRadius));
            
            var nMaxNodeRadius = jQuery(oChart).attr('maxNodeRadius');
            if (typeof(nMaxNodeRadius)!=="undefined") window.d3chart.get(id).maxNodeRadius(Number(nMaxNodeRadius));
            
            var sColorScheme = jQuery(oChart).attr('colorScheme');
            if (typeof(sColorScheme)!=="undefined") window.d3chart.get(id).colorScheme(sColorScheme);
 
            var bDragMode = jQuery(oChart).attr('dragMode');
            if (typeof(bDragMode)!=="undefined") window.d3chart.get(id).dragMode(Number(bDragMode));
 
            var bShowLabels = jQuery(oChart).attr('showLabels');
            if (typeof(bShowLabels)!=="undefined") window.d3chart.get(id).showLabels(Number(bShowLabels));
 
            var bLabelsCircular = jQuery(oChart).attr('labelsCircular');
            if (typeof(bLabelsCircular)!=="undefined") window.d3chart.get(id).labelsCircular(Number(bLabelsCircular));
 
            var nLabelDistance = jQuery(oChart).attr('labelDistance');
            if (typeof(nLabelDistance)!=="undefined") window.d3chart.get(id).labelDistance(Number(nLabelDistance));
 
            var bShowTooltips = jQuery(oChart).attr('showTooltips');
            if (typeof(bShowTooltips)!=="undefined") window.d3chart.get(id).showTooltips(Number(bShowTooltips));
 
            var sTooltipPosition= jQuery(oChart).attr('tooltipPosition');
            if (typeof(sTooltipPosition)!=="undefined") window.d3chart.get(id).tooltipPosition(sTooltipPosition);
 
            var nLinkDistance = jQuery(oChart).attr('linkDistance');
            if (typeof(nLinkDistance)!=="undefined") window.d3chart.get(id).linkDistance(Number(nLinkDistance));
 
            var bShowLinkDirection = jQuery(oChart).attr('showLinkDirection');
            if (typeof(bShowLinkDirection)!=="undefined") window.d3chart.get(id).showLinkDirection(Number(bShowLinkDirection));
 
            var bUseDomParentWidth = jQuery(oChart).attr('useDomParentWidth');
            if (typeof(bUseDomParentWidth)!=="undefined") window.d3chart.get(id).useDomParentWidth(Number(bUseDomParentWidth));
 
            var nHeight = jQuery(oChart).attr('height');
            if (typeof(nHeight)!=="undefined") window.d3chart.get(id).height(Number(nHeight));
 
            var bShowBorder = jQuery(oChart).attr('showBorder');
            if (typeof(bShowBorder)!=="undefined") window.d3chart.get(id).showBorder(Number(bShowBorder));
 
            var bShowLegend = jQuery(oChart).attr('showLegend');
            if (typeof(bShowLegend)!=="undefined") window.d3chart.get(id).showLegend(Number(bShowLegend));
 
            var bLassoMode = jQuery(oChart).attr('lassoMode');
            if (typeof(bLassoMode)!=="undefined") window.d3chart.get(id).lassoMode(Number(bLassoMode));

            var bZoomMode = jQuery(oChart).attr('zoomMode');
            if (typeof(bZoomMode)!=="undefined") window.d3chart.get(id).zoomMode(Number(bZoomMode));

            window.d3chart.get(id).start(data);
            jQuery(window).on("resize", resizeGraphContainer);
            jQuery('#dw__toc h3').on("click", resizeGraphContainer);
            resizeGraphContainer();
            break;
        default:
            break;
        }
        jQuery(tag).remove();
    }catch(err){
        console.warn(err.message);
    }});
});
