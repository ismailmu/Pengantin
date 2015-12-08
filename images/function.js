var ajax,timeOut,statusAjax=false;
var element=new Array();
var text_hasil=new Array();

if (window.XMLHttpRequest) { ajax = new XMLHttpRequest(); } 
else if (window.ActiveXObject) { ajax = new ActiveXObject("Microsoft.XMLHTTP"); } 
else { alert("Browser tidak mendukung Ajax."); }

function getData(link_tujuan,divId)
{
	if(!ajax) return true;
	if (statusAjax==true) {
		nextAjax="getData('"+link_tujuan+"','"+divId+"')";
		return false;
	}
	
	timeOut=false;
	element=divId.split('&');
	
	try { ajax.open("GET",link_tujuan,true); }
	catch(err) { alert(err.description); }
	
	ajax.onreadystatechange = function()
		{
			if(ajax.readyState == 1) {
				statusAjax=true;
				for(var i=0;i<element.length;i++) {
					if(document.getElementById('load_'+element[i])) document.getElementById('load_'+element[i]).style.display='block';
					if(document.getElementById(element[i])) document.getElementById(element[i]).innerHTML='';
				}
				timeOut=setTimeout("replayGet('"+link_tujuan+"','"+divId+"')",20000);
			}
			else if ((ajax.readyState == 4) && (ajax.status == 200)) {
				clearTimeout(timeOut);
				statusAjax=false;
				text_hasil=ajax.responseText.split('&&&');
				
				for(var i=0;i<element.length;i++) {
					if(document.getElementById('load_'+element[i])) document.getElementById('load_'+element[i]).style.display='none';
					if(document.getElementById(element[i])) document.getElementById(element[i]).innerHTML=text_hasil[i];
				}
			}
		}
	ajax.send(null);
	return false;
}

function replayGet(link_tujuan,divId) {
	if(statusAjax==true) {
		ajax.abort();
		statusAjax=false;
		clearTimeout(timeOut);
		return getData(link_tujuan,divId);
	}
}

//------------------------------------------------------------------------------------------------

function focusCari(param) {
	if(param.value=='Pencarian Product') param.value=''
}

function blurCari(param) {
	if(param.value=='') param.value='Pencarian Product'
}

//------------------------------------------------------------------------------------------------

function validasi(element,param)
{	
	var nilai = element.value;
	
    if(param=='email') {
		var myPattern = new RegExp ("^[a-zA-Z0-9_]+@[a-zA-Z0-9_]+[.][a-zA-Z.]+$");
		
		if(! myPattern.test (nilai) && nilai!="" ) {
			alert("Penulisan Email Salah!");
			
			this.focus();
		}
	}
	else if(param=='angka') {
	}
}

//------------------------------------------------------------------------------------------------

function valnumber(angka) // 0212373
{ 
     var isi = angka.value;
	 var hasil='';
	 
	 for(var i=0;i<isi.length;i++)
	 {
	 	var nilai = isi.substr(i,1);
	 	if(parseFloat(nilai)||parseFloat(nilai)==0)
	 	{
			hasil+= nilai;
	 	}
	 }
	 angka.value = hasil;
}

//------------------------------------------------------------------------------------------------
