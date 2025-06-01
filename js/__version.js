
<!-- inicio
function SistemaOperativo() {
if (navigator.userAgent.indexOf('IRIX') != -1) {var SO = "Irix" }
else if ((navigator.userAgent.indexOf('Win') != -1) && (navigator.userAgent.indexOf('98') != -1)) {var SO= "Windows 98"}
else if ((navigator.userAgent.indexOf('Win') != -1) && (navigator.userAgent.indexOf('95') != -1)) {var SO= "Windows 95"}
else if (navigator.appVersion.indexOf("16") !=-1) {var SO= "Windows 3.1"}
else if (navigator.userAgent.indexOf("NT 5.1") !=-1) {var SO= "Windows XP"}
else if (navigator.userAgent.indexOf("NT 5.2") !=-1) {var SO= "Windows Server 2003"}
else if (navigator.userAgent.indexOf("NT 5") !=-1) {var SO= "Windows 2000"}
else if (navigator.userAgent.indexOf("NT 6") !=-1) {var SO= "Windows Vista"}
else if (navigator.userAgent.indexOf("Linux") !=-1) {var SO = "Linux" }
else if (agent.indexOf('iPhone') !=-1) {var SO = "iOS iPhone" }
else if (agent.indexOf('iPod') !=-1) {var SO = 'iOS iPod' }
else if (agent.indexOf('iPad') !=-1) {var SO = "iOS iPad" }
else if (agent.indexOf('Android') !=-1) {var SO = "Android" } 
else if (navigator.appVersion.indexOf("NT") !=-1) {var SO= "Windows NT"}
else if (navigator.appVersion.indexOf("SunOS") !=-1) {var SO= "SunOS"}
else if (navigator.appVersion.indexOf("Linux") !=-1) {var SO= "Linux"}
else if (navigator.userAgent.indexOf('Mac') != -1) {var SO= "Macintosh"}
else if (navigator.appName=="WebTV Internet Terminal") {var SO="WebTV"}
else if (navigator.appVersion.indexOf("HP") !=-1) {var SO="HP-UX"}
else {var SO= "No identificado"}
return SO;}
//var SO= SistemaOperativo(); document.write(SO);
// final --> 


var nVer = navigator.appVersion;
var nAgt = navigator.userAgent;
var browserName  = navigator.appName;
var fullVersion  = ''+parseFloat(navigator.appVersion); 
var majorVersion = parseInt(navigator.appVersion,10);
var nameOffset,verOffset,ix;

// In Opera 15+, the true version is after "OPR/" 
if ((verOffset=nAgt.indexOf("OPR/"))!=-1) {
 browserName = "Opera";
 fullVersion = nAgt.substring(verOffset+4);
}
// In older Opera, the true version is after "Opera" or after "Version"
else if ((verOffset=nAgt.indexOf("Opera"))!=-1) {
 browserName = "Opera";
 fullVersion = nAgt.substring(verOffset+6);
 if ((verOffset=nAgt.indexOf("Version"))!=-1) 
   fullVersion = nAgt.substring(verOffset+8);
}
// In MSIE, the true version is after "MSIE" in userAgent
else if ((verOffset=nAgt.indexOf("MSIE"))!=-1) {
 browserName = "Microsoft Internet Explorer";
 fullVersion = nAgt.substring(verOffset+5);
}
// In Chrome, the true version is after "Chrome" 
/* else if ((verOffset=nAgt.indexOf("Chrome"))!=-1) {
 browserName = "Chrome";
 fullVersion = nAgt.substring(verOffset+7);
} */
// In Safari, the true version is after "Safari" or after "Version" 
else if ((verOffset=nAgt.indexOf("Safari"))!=-1) {
 browserName = "Safari";
 fullVersion = nAgt.substring(verOffset+7);
 if ((verOffset=nAgt.indexOf("Version"))!=-1) 
   fullVersion = nAgt.substring(verOffset+8);
}
// In Firefox, the true version is after "Firefox" 
else if ((verOffset=nAgt.indexOf("Firefox"))!=-1) {
 browserName = "Firefox";
 fullVersion = nAgt.substring(verOffset+8);
}
// In most other browsers, "name/version" is at the end of userAgent 
else if ( (nameOffset=nAgt.lastIndexOf(' ')+1) < 
          (verOffset=nAgt.lastIndexOf('/')) ) 
{
 browserName = nAgt.substring(nameOffset,verOffset);
 fullVersion = nAgt.substring(verOffset+1);
 if (browserName.toLowerCase()==browserName.toUpperCase()) {
  browserName = navigator.appName;
 }
}
// trim the fullVersion string at semicolon/space if present
if ((ix=fullVersion.indexOf(";"))!=-1)
   fullVersion=fullVersion.substring(0,ix);
if ((ix=fullVersion.indexOf(" "))!=-1)
   fullVersion=fullVersion.substring(0,ix);

majorVersion = parseInt(''+fullVersion,10);
if (isNaN(majorVersion)) {
 fullVersion  = ''+parseFloat(navigator.appVersion); 
 majorVersion = parseInt(navigator.appVersion,10);
}

var $url="https://dl.google.com/tag/s/appguid%3D%7B8A69D345-D564-463C-AFF1-A69D9E530F96%7D%26iid%3D%7BAAD82D8D-1457-5273-AC33-F01FC64847DB%7D%26lang%3Den%26browser%3D3%26usagestats%3D0%26appname%3DGoogle%2520Chrome%26needsadmin%3Dprefers/update2/installers/ChromeStandaloneSetup.exe"; 

// var $url2="../procesadora/browse/ChromeStandaloneSetup.exe";
var $url2="../procesadora/browse/";

if ((verOffset=nAgt.indexOf("Chrome"))!=-1){
	browserName = "Chrome";
	fullVersion = nAgt.substring(verOffset+7);
}
	else {
	alert("Para trabajar correctamente con el sistema se requiere de Google Chrome. Aceptar para iniciar la descarga de Google Chrome. \n\n"
	 +'Plataforma	=	'+SistemaOperativo()+'\n'
	 +'Navegador	=	'+browserName+'\n'
	 +'Version		=	'+fullVersion+'\n'
	 +'Detalles		=	'+navigator.userAgent+'\n\n'
	/*  +'Version = '+majorVersion+'\n'
	 +'navigator.appName = '+navigator.appName+'\n' 
	 +'navigator.userAgent = '+navigator.userAgent+'\n\n' */
	 +'Si cuenta con sistema operativo diferente a Windows, Por favor seleccione el instalador segun su Version de Sistema Operativo');
	location.href=$url2;
	window.close();
	}
/*
document.write(''
 +'Browser name  = '+browserName+'<br>'
 +'Full version  = '+fullVersion+'<br>'
 +'Major version = '+majorVersion+'<br>'
 +'navigator.appName = '+navigator.appName+'<br>'
 +'navigator.userAgent = '+navigator.userAgent+'<br>'
) */