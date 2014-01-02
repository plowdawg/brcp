$(document).ready(function()
{
	var background$ = $("img#background");
	alert($(window).width());
	alert(background$.width());
	alert((parseInt($(window).width()) - (parseInt(background$.width())/2)).toString() + "px");
	background$.css("margin-left",(parseInt($(window).width()) - (parseInt(background$.width())/2)).toString() + "px");
});