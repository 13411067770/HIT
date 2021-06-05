//1903010226Ajax函数
function show(url, areaId, str1, str2, type) {
	var xmlhttp;
	if (str1.length == 0) {
		document.getElementById(areaId).innerHTML = "";
		return;
	}
	if (window.XMLHttpRequest) { 
		// code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp = new XMLHttpRequest();
	} else { 
		// code for IE6, IE5
		xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.onreadystatechange = function() {
		if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
			document.getElementById(areaId).innerHTML = xmlhttp.responseText;
		}
	}
	xmlhttp.open("GET",url+"?str1="+str1+"&str2="+str2+"&type="+type,true);
	xmlhttp.send();
}
