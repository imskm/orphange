function close_sticky()
{
	//
	//Note: need improvement
	// Not accurate..
	// working for the time being.
	// For now it only removes the first child's parent

	var parent = document.getElementsByClassName('actNotify-notice');
	console.log(parent[0]);

	parent[0].parentNode.removeChild(parent[0]);
}

var btnClose = document.getElementsByClassName('close');
for(var i = 0; i < btnClose.length; ++i)
{
	//console.log(btnClose[i]);
	btnClose[i].addEventListener("click", close_sticky);
}

// Removing overlay popup
// Probelm: target returns null because this
//   js is loads first and finds the element of id
//   overlay-popup which is not present in the DOM
//   as 'overlay-popup' is created by an Ajax response
document.getElementById('ajaxResponse').addEventListener('click', function(){
	//console.log("cliked");
	//document.getElementById('close-ok');
	//var target = document.getElementById('overlay-popup');
	document.getElementById('ajaxResponse').innerHTML = "";
});
