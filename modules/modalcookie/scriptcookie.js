$(document).ready(function(){
$("#setCookie").click(function () {
$.cookie("popup", "24house", {expires: 0} );
$("#popupBlock").hide();
});
if ( $.cookie("popup") == null )
{
setTimeout(function(){
$("#popupBlock").show();
}, delay_popup)
}
else { $("#popupBlock").hide();
}
});