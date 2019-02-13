<?php SESSION_START(); error_reporting(E_ALL);
/**************Pagina Noticias****************************************************************************/
$controlador=1;
if(isset($controlador)&&$controlador==1){
if(!isset($_GET["pagina"])){$pagina=1;}else{$pagina=$_GET["pagina"];}
$sig=($pagina+1);$ant=($pagina-1);
//if(!isset($_GET["entradas"])){$entradas=5;}else{$entradas=$_GET["entradas"];}
if(!isset($_GET["orden"])){$orden=0;}else{$orden=$_GET["orden"];}
if(!isset($_GET["limit"])){$limit=5;}else{$limit=$_GET["limit"];}
/*******************************Select*******************************************/
 if($limit==5){$si='selected';$si2='';$si3='';$si4='';$si5='';$si6='';}elseif ($limit==10) {
 $si='';$si2='selected';$si3='';$si4='';$si5='';$si6=''; }elseif ($limit==15) {
 $si='';$si2='';$si3='selected';$si4='';$si5='';$si6=''; }elseif ($limit==20) {
 $si='';$si2='';$si3='';$si4='selected';$si5='';$si6=''; }elseif ($limit==25) {
 $si='';$si2='';$si3='';$si4='';$si5='selected';$si6=''; }else{$si='';$si2='';$si3='';$si4='';$si5='';$si6='selected';}
 if($orden==0){$ok1='selected';$ok='';}else{$ok='selected';$ok1='';}
/*****************************************************************************************************************************/
if(empty($_GET["b"])){$buscar="";}else{$buscar=$_GET["b"];}
if(empty($_GET["categoria"])){$categoria="";}else{$categoria=$_GET["categoria"];}
if(isset($_GET["id"])){
if(!empty($_GET["id"])){(int)$id=$_GET["id"];}}else{$id="";}
/**********************************************************************************************/
}
class control extends PDO{
	private $contenido,$usuario,$total_pages,$busqueda,$totalbusqueda;
	public $conexion,$init;

	public function __construct(){
		$this->contenido=array();
		$this->busqueda=array();
		$this->totalbusqueda=array();
		$this->simple=array();
		$this->simpleb=array();
		$this->init=parse_ini_file('clase/config.ini');
		$PDO=new PDO(''.$this->init['driver'].':host='.$_SERVER['SERVER_NAME'].';dbname='.$this->init['db'].';',''.$this->init['usuario'].'','',ARRAY(PDO::ATTR_ERRMODE,PDO::ERRMODE_WARNING,PDO::ATTR_PERSISTENT=>true,PDO::MYSQL_ATTR_INIT_COMMAND=>"SET NAMES 'utf8'"));
		$this->conexion=$PDO;
		return $this->conexion;
	}
	public function leermas($palabra,$cantidad)
    {
        $substring = substr($palabra,0,$cantidad);
        return $substring ;
    }
	
	public function noticias($limit,$pages,$orden,$buscar="",$categoria="",$id="")
	{
	if($orden==0){ $ordenar="id DESC"; }else{ $ordenar="id ASC"; }
	
	$sql="SELECT * FROM noticias ";
	if(!empty($buscar)){$sql.="WHERE titulo LIKE '%".$buscar."%'";}
	if(!empty($categoria)){$sql.="WHERE categoria='$categoria'";}
	if(!empty($id)){$sql.="WHERE id='$id'";}
	$sql.="ORDER BY $ordenar LIMIT $limit,$pages";
	$query=$this->conexion->query($sql);
	return $query;
	}
	public function simple($id){

	$query=$this->conexion->query("SELECT * FROM noticias WHERE id=$id")or die('error');

		if($data=$query->fetch(PDO::FETCH_ASSOC)){
			$this->simple=$data;
		}
		return $this->simple;
		}
	public function inoticia($titulo,$foto,$contenido,$user,$categoria){
		$query=$this->conexion->query("INSERT INTO noticias (titulo,foto,contenido,user,categoria) VALUES ('$titulo','$foto','$contenido','$user','$categoria')")or die('error');
		return $query;
	}
	public function anoticia($titulo,$foto,$contenido,$user,$categoria,$id){
		$query=$this->conexion->query("UPDATE noticias SET titulo='$titulo',foto='$foto',contenido='$contenido',user='$user',categoria='$categoria' WHERE id=$id")or die('error');
		return $query;
	}

	public static function sanar($contenido=''){
      $rip=true;
      if($contenido!=''){
        if($rip==true){
        $cadena='<p><a><h1><h2><h3><h4><h5><h6><b><a><ul><li><div><span><hr><img><small><pre><code><strong><br><ol><ul>';
      $curado=strtolower(strip_tags($contenido,$cadena));
      $curado=str_replace('&nbsp;','',$curado);
      $curado=str_replace('<small>','',$curado);
      $curado=str_replace('</small>','',$curado);
      $curado=str_replace('<h1>','<h3>',$curado);
      $curado=str_replace('<h1>','</h3>',$curado);
      $curado=str_replace('<h2>','<h4>',$curado);
      $curado=str_replace('<h2>','</h4>',$curado);
      $curado=str_replace('../','',$curado);
      $curado=preg_replace('/\<p><\/p>/','',$curado);
      $curado=preg_replace('/\<p>\s?<br>\s?<\/p>/','',$curado);
        return trim($curado);
      }else{
        $contenido=filter_var($contenido,FILTER_SANITIZE_SPECIAL_CHARS);
        return $contenido;
      }
          // 
      }
    

  }

	public function paginacion($limit,$buscar="",$categoria=""){

	$sql="SELECT COUNT(*) as num FROM noticias ";
	if(!empty($buscar)){$sql.="WHERE titulo LIKE '%".$buscar."%'";}
	if(!empty($categoria)){$sql.="WHERE categoria='$categoria'";}
	$sql.="ORDER BY id DESC";

	$query=$this->conexion->query($sql);
	$total_results=$query->fetch();
	$total_pages=ceil($total_results['num'] / $limit);$this->total_pages=$total_pages;
	return $this->total_pages;
	}
	public function categoria()
	{	$query=$this->conexion->query("SELECT * FROM categoria ORDER BY id ASC");
		return $query;
	}
	public function comentario()
	{	$query=$this->conexion->query("SELECT * FROM comentario ORDER BY id DESC LIMIT 5");
		return $query;
	}
	public function comentariocont($id)
	{	$query=$this->conexion->query("SELECT COUNT(*) AS cuantos FROM comentario WHERE id_contenido='$id'");
		if($data=$query->fetch(PDO::FETCH_ASSOC)){echo $data["cuantos"];}
 		return $data["cuantos"];
 	}
public function comentarioid($id)
	{	$query=$this->conexion->query("SELECT * FROM comentario WHERE id_contenido=$id ORDER BY id DESC");
		return $query;
	}
	public function icoment($comentario,$autor,$foto,$correo,$id){
		$query=$this->conexion->query("INSERT INTO comentario (comentario,autor,foto,correo,id_contenido) VALUES ('$comentario','$autor','$foto','$correo','$id')")or die('error');
		return $query;
	}
	
function acerca(){
	$query=$this->conexion->query("SELECT acerca FROM acerca");
return $query;
}
function servicio(){
	$query=$this->conexion->query("SELECT servicio FROM servicios");
	return $query;
}
function actualizarAcerca($acerca){
	$query=$this->conexion->query("UPDATE acerca SET acerca='$acerca'")or die('falla query');return $query;
}
function actualizarservicio($servicio){
	$query=$this->conexion->query("UPDATE servicios SET servicio='$servicio'")or die('falla query');
	return $query;
}
public function personal()
{$query=$this->conexion->query("SELECT * FROM personal ORDER BY id_p DESC");
	return $query;
}
function ultimas(){
	$query=$this->conexion->query("SELECT * FROM noticias ORDER BY id DESC LIMIT 6")or die('falla query');
	return $query;
}

function borracontenido($id){
	$this->conexion->query("DELETE FROM noticias WHERE id=$id");
}
function totalcontenido(){$query=$this->conexion->query("SELECT COUNT(*) AS cuantos FROM contenido");
return $query;
}

function verusuario(){
	$query=$this->conexion->query("SELECT * FROM usuarios");
return $query;
}
function usuario($id){$query=$this->conexion->query("SELECT * FROM usuarios WHERE id_usuario=$id");
while($data=$query->fetch()){
	$this->usuario=$data;
}
return $this->usuario;
}
function logear()
{
	$qry = "SELECT usrid, username, oauth FROM usermeta WHERE username='".$nombre."' AND pass='".$clave."' AND status='active'";
$res = mysql_query($qry);
$num_row = mysql_num_rows($res);
$row=mysql_fetch_assoc($res);
if( $num_row == 1 ) {
	echo 'true';
	$_SESSION['uName'] = $row['username'];
	$_SESSION['oId'] = $row['orgid'];
	$_SESSION['auth'] = $row['oauth'];
	}
else {
	echo 'false';
}
}
function logearUsuario($usuario,$pass){

	$query=$this->conexion->query("SELECT * FROM usuarios WHERE usuario ='$usuario' AND password = '$pass'")or die('fallo log');
	if($datau=$query->fetch()){
		foreach($datau as $i){
			if($i>0){
				
				
				$_SESSION['user']=$datau['usuario'];
				$_SESSION['id']=$datau['id_usuario'];
				$_SESSION['role']=$datau['role'];
	
			}
		} echo 'true';

	}else{
			echo 'false';
			//echo '<script>window.location.assign("godmode")</script>';
		}
		}

function insertarUsuario($nombre,$apellido,$usuario,$password,$correo){
			$query=$this->conexion->query("INSERT INTO usuarios (nombre,apellido,usuario,password,correo) VALUES ('$nombre','$apellido','$usuario','$password','$correo')")or die('error');
			return $query;
	}
	function borrarusuario($id){
$query=$this->conexion->query("DELETE FROM usuarios WHERE id_usuario=$id");
return $query;
}
	function cuentaBuscador($s){
		$query=$this->conexion->query("SELECT count(*) AS cuantos FROM contenido WHERE id_region LIKE '%".$s."%'");
		return $query;
	}
	function allowes_images($file_name){$allowed_ext=array('jpg','jpeg','png','gif');
	$file_ext=end(explode('.',$file_name));
	return(in_array($file_ext,$allowed_ext)==true)?true:false;}

	function watermark_image($file,$destination){
	$watermark=imagecreatefrompng('./imagenes/watermark.png');
	$source=getimagesize($file);
	$source_mime=$source['mime'];
	if($source_mime=='image/png'){$image=imagecreatefrompng($file);
	}elseif($source_mime=='image/jpeg'){
		$image=imagecreatefromjpeg($file);
	}elseif($source_mime=='image/gif'){
		$image=imagecreatefromgif($file);
	}imagecopy($image,$watermark,0,0,0,0,imagesx($watermark),imagesy($watermark));
	imagepng($image,$destination);
}
public function musica(){
		$query=$this->conexion->query("SELECT * FROM musica ORDER BY RAND()");
		return $query;
	}
	public function simusica(){
		$query=$this->conexion->query("SELECT * FROM musica ORDER BY RAND() LIMIT 1");
		return $query;
	}
function carrusel(){
	$query=$this->conexion->query("SELECT * FROM baner ORDER BY RAND()");return $query;
}
function carruselporid($id){
	$query=$this->conexion->query("SELECT baner FROM baner WHERE id_baner=$id");
	if($data=$query->fetch(PDO::FETCH_ASSOC)){
		$this->simpleb=$data;
}
	return $this->simpleb;
}
function borrarcarrusel($id){$query=$this->conexion->query("DELETE FROM baner WHERE id_baner=$id");
return $query;
}
function inserarcarrusel($baner){
	$query=$this->conexion->query("INSERT INTO baner (baner) VALUES ('$baner')")or die('error');
	if($data=$query->fetch()){$this->foto=$data;
	}return $this->foto;
}
function destacados(){
	$query=$this->conexion->query("SELECT * FROM contenido ORDER BY cont DESC LIMIT 6")or die('error');
	return $query;
}
function contador($id){
	$consult=$this->conexion->query("SELECT visitas FROM noticias WHERE id=$id");
	if($data=$consult->fetch())
		{$contar=$data["visitas"];}
	$contar=$contar+1;
	$query=$this->conexion->query("UPDATE noticias SET visitas='$contar' WHERE id=$id")or die('error');
	return $query;
}
public function link()
    {
        $query=$this->conexion->query("SELECT * FROM links ORDER BY nombre ASC");
        return $query->fetchall();
    }
}
/***********************************************************/
class thumbnail
{
	var $img;

	function thumbnail($imgfile)
	{
		//detect image format
		$this->img["format"]=preg_replace("/.*\.(.*)$/","\\1",$imgfile);
		$this->img["format"]=strtoupper($this->img["format"]);
		if ($this->img["format"]=="JPG" || $this->img["format"]=="JPEG") {
			//JPEG
			$this->img["format"]="JPEG";
			$this->img["src"] = ImageCreateFromJPEG ($imgfile);
		} elseif ($this->img["format"]=="PNG") {
			//PNG
			$this->img["format"]="PNG";
			$this->img["src"] = ImageCreateFromPNG ($imgfile);
		} elseif ($this->img["format"]=="GIF") {
			//GIF
			$this->img["format"]="GIF";
			$this->img["src"] = ImageCreateFromGIF ($imgfile);
		} elseif ($this->img["format"]=="WBMP") {
			//WBMP
			$this->img["format"]="WBMP";
			$this->img["src"] = ImageCreateFromWBMP ($imgfile);
		} else {
			//DEFAULT
			echo "Not Supported File";
			exit();
		}
		@$this->img["lebar"] = imagesx($this->img["src"]);
		@$this->img["tinggi"] = imagesy($this->img["src"]);
		//default quality jpeg
		$this->img["quality"]=75;
	}

	function size_height($size=100)
	{
		//height
    	$this->img["tinggi_thumb"]=$size;
    	@$this->img["lebar_thumb"] = ($this->img["tinggi_thumb"]/$this->img["tinggi"])*$this->img["lebar"];
	}

	function size_width($size=100)
	{
		//width
		$this->img["lebar_thumb"]=$size;
    	@$this->img["tinggi_thumb"] = ($this->img["lebar_thumb"]/$this->img["lebar"])*$this->img["tinggi"];
	}

	function size_auto($size=100)
	{
		//size
		if ($this->img["lebar"]>=$this->img["tinggi"]) {
    		$this->img["lebar_thumb"]=$size;
    		@$this->img["tinggi_thumb"] = ($this->img["lebar_thumb"]/$this->img["lebar"])*$this->img["tinggi"];
		} else {
	    	$this->img["tinggi_thumb"]=$size;
    		@$this->img["lebar_thumb"] = ($this->img["tinggi_thumb"]/$this->img["tinggi"])*$this->img["lebar"];
 		}
	}

	function jpeg_quality($quality=75)
	{
		//jpeg quality
		$this->img["quality"]=$quality;
	}

	function show()
	{
		//show thumb
		@Header("Content-Type: image/".$this->img["format"]);

		/* change ImageCreateTrueColor to ImageCreate if your GD not supported ImageCreateTrueColor function*/
		$this->img["des"] = ImageCreateTrueColor($this->img["lebar_thumb"],$this->img["tinggi_thumb"]);
    		@imagecopyresized ($this->img["des"], $this->img["src"], 0, 0, 0, 0, $this->img["lebar_thumb"], $this->img["tinggi_thumb"], $this->img["lebar"], $this->img["tinggi"]);

		if ($this->img["format"]=="JPG" || $this->img["format"]=="JPEG") {
			//JPEG
			imageJPEG($this->img["des"],"",$this->img["quality"]);
		} elseif ($this->img["format"]=="PNG") {
			//PNG
			imagePNG($this->img["des"]);
		} elseif ($this->img["format"]=="GIF") {
			//GIF
			imageGIF($this->img["des"]);
		} elseif ($this->img["format"]=="WBMP") {
			//WBMP
			imageWBMP($this->img["des"]);
		}
	}

	function save($save="")
	{
		//save thumb
		if (empty($save)) $save=strtolower("./thumb.".$this->img["format"]);
		/* change ImageCreateTrueColor to ImageCreate if your GD not supported ImageCreateTrueColor function*/
		$this->img["des"] = ImageCreateTrueColor($this->img["lebar_thumb"],$this->img["tinggi_thumb"]);
    		@imagecopyresized ($this->img["des"], $this->img["src"], 0, 0, 0, 0, $this->img["lebar_thumb"], $this->img["tinggi_thumb"], $this->img["lebar"], $this->img["tinggi"]);

		if ($this->img["format"]=="JPG" || $this->img["format"]=="JPEG") {
			//JPEG
			imageJPEG($this->img["des"],"$save",$this->img["quality"]);
		} elseif ($this->img["format"]=="PNG") {
			//PNG
			imagePNG($this->img["des"],"$save");
		} elseif ($this->img["format"]=="GIF") {
			//GIF
			imageGIF($this->img["des"],"$save");
		} elseif ($this->img["format"]=="WBMP") {
			//WBMP
			imageWBMP($this->img["des"],"$save");
		}
	}
}
/********************HERRAMIENTAS****************************************/
class tools
{
	function fecha()
{
date_default_timezone_set('America/La_Paz');

$dias = array("Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","Sábado");
$meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");

echo $dias[date('w')]." ".date('d')." de ".$meses[date('n')-1]. " del ".date('Y') ;
}

function hora()
{
date_default_timezone_set('America/La_Paz');
echo date('H:i.s.A');
}
}
$control = new control;/****************control***********************/
$tools = new tools;

if(!empty($id)){ $control->contador($_GET["id"]); }
/*************************************chat principal************************************************************/
$rednaxela255177 = array('007AFF','FF7000','FF7000','15E25F','CFC700','CFC700','CF1100','CF00BE','F00');
$user_colour = array_rand($rednaxela255177);
if(isset($_SESSION["user"])){$cuadro=$_SESSION["user"].".jpg";}else{$cuadro="anonimo.png";}
?>