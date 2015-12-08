var ajax = false;

if (window.XMLHttpRequest) { ajax = new XMLHttpRequest(); } 
else if (window.ActiveXObject) { ajax= new ActiveXObject("Microsoft.XMLHTTP"); } 
else { alert("Browser tidak mendukung Ajax."); }

function opacity(elemet,duration,from,to,toggle) {

	var appearFadeEffect = new Spry.Effect.Opacity(element,0.01, 1, {duration : duration, from: from, to: to, toggle: toggle});

	//appearFadeEffect.name = 'AppearFade';
	var registeredEffect = SpryRegistry.getRegisteredEffect(element, appearFadeEffect);
	registeredEffect.start();
	return registeredEffect;
}

function getData(link_tujuan,div)
{
	if (!ajax) return true;
	 		
	try { ajax.open("GET", link_tujuan,true); }
	catch(err) { alert(err.description); }
	ajax.onreadystatechange = function()
		{
			if (ajax.readyState == 1) document.getElementById(div+"_load").style.display='block';
			if ((ajax.readyState == 4) && (ajax.status == 200))
			{
				document.getElementById(div).innerHTML=ajax.responseText;
				document.getElementById(div+"_load").style.display='none';
				init();
			}
	}
	ajax.send(null);
	return false;
}

function viewselect(element1,element2) {
	if(element1.value=='') {
		document.getElementById(element2).disabled=false;
		document.getElementById(element2).style.visibility = 'visible';
	}
	else {
		document.getElementById(element2).disabled=true;
		document.getElementById(element2).style.visibility = 'hidden';
	}
}

function valnumber(angka)
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

function valnominal(angka) 
{ 
     var isi = angka.value;
	 var hasil='';
	 
	 for(var i=0;i<isi.length;i++)
	 {
	 	var nilai = isi.substr(i,1);
	 	if(parseFloat(nilai)||parseFloat(nilai)==0)
	 	{
			if(i==1 && hasil==0) hasil=nilai;
			else hasil+= nilai;
	 	}
	 }
	 angka.value = hasil;
}

function valdesimal(angka) 
{ 
     var isi = angka.value;
	 var hasil='';
	 var koma=0;
	 
	 for(var i=0;i<isi.length;i++)
	 {
	 	var nilai = isi.substr(i,1);
	 	if(parseFloat(nilai)||parseFloat(nilai)==0||nilai=='.')
	 	{
			if(i==0)
			{
				if(nilai!='.')
				{
					hasil+= nilai;
					var digit1=nilai;
				}
			}
			else if(i==1)
			{
				if(nilai=='.')
				{
					hasil+= nilai;
					koma++;					
				}
				else
				{
					if(digit1=='0')	hasil= nilai;
					else hasil+= nilai;
				}
			}
			else
			{
				if(nilai=='.')
				{
					if(koma==0)
					{
						hasil+= nilai;
						koma++;
					}
				}
				else hasil+= nilai;
			}
	 	}
	 }
	 
	 angka.value = hasil;
}

function changeDate(f,yyyy,mm){
	if ((f.yyyy.value)%4==0) var dm = new Array('31','29','31','30','31','30','31','31','30','31','30','31');
	else var dm = new Array('31','28','31','30','31','30','31','31','30','31','30','31');
	var c = f.mm.value-1;
	f.dd.length=dm[c];
	for(i=0;i<dm[c];i++){
		num = i+1;
		if(num<10) num = "0"+num;
		f.dd.options[i].value = num;
		f.dd.options[i].text = num;
	}
}// JavaScript Document

function showLeft(id,jum) {
	document.getElementById(id).style.display='block';
	document.getElementById('t'+id).style.background='#FF9103';
	document.getElementById('t'+id).style.color='#FFFFFF';
	
	for(var i=1;i<=jum;i++) {
		if(i!=id) { 
			document.getElementById(i).style.display='none';
			document.getElementById('t'+i).style.background='#eaeaea';
			document.getElementById('t'+i).style.color='#333333';
		}
	}
}

function validasi(element,param)
{	
	var nilai = element.value;
	
    if(param=='email') {
		var myPattern = new RegExp ("^[a-zA-Z0-9_]+@[a-zA-Z0-9_]+[.][a-zA-Z.]+$");
		
		if(! myPattern.test (nilai)) {
			alert("Penulisan Email Salah!");
			
			element.focus();
		}
	}
	else if(param=='angka') {
	}
}

function blank(param) {
	param.value="";
}

var ya='url(images/ya.png) right no-repeat';
var tidak='url(images/tidak.png) right no-repeat';

function valPass(element1,element2) {
	if(element1.value=='') element1.style.background='none';
	else { 
		if(element1.value==document.getElementById(element2).value) element1.style.background=ya; 
		else element1.style.background=tidak; 
	}
}