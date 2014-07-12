/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
function closePop() {
    $("#popup").hide();
    bright('app_wrapper');
}

function center_popup(pwidth,pheight) {
   size_popup(pwidth, pheight);
   var bwidth = $(window).width();
   var bheight = $(window).height();
   var leftPos = (bwidth/2) - (pwidth/2);
   var topPos = (bheight/2) - (pheight/2);
   $("#popup").css("top", topPos+"px");
   $("#popup").css("left", leftPos+"px");
   dim('app_wrapper');
}

function size_popup(pwidth, pheight) {
   $("#popup").css("width", pwidth + "px");
   $("#popup").css("height", pheight + "px");
}

function mouse_pos_popup(pwidth, pheight) {
   size_popup(pwidth, pheight);
   $("#popup").css("top", (window.mouseYPos+10)+"px");
   $("#popup").css("left", (window.mouseXPos+10)+"px");
    

}
function getMousePosition(timeoutMilliSeconds) {
    // "one" attaches the handler to the event and removes it after it has executed once
    $(document).one("mousemove", function (event) {
        window.mouseXPos = event.pageX;
        window.mouseYPos = event.pageY;
        // set a timeout so the handler will be attached again after a little while
        setTimeout("getMousePosition(" + timeoutMilliSeconds + ")", timeoutMilliSeconds);
    });
}

function dim(divid) {
    $("#"+divid).css("filter", "alpha(opacity=15)");
    $("#"+divid).css("opacity", "0.15");
    $("#"+divid).css("zoom", "1");
}

function bright(divid) {
    $("#"+divid).css("filter", "none");
    $("#"+divid).css("opacity", "1");
    $("#"+divid).css("zoom", "1");
}

function toggle(divName) {
    $("#"+divName).toggle('slow');
}