<div class="servicios">
<div id="simple">
<?php
$total=$control->paginacion($limit,$buscar,$categoria);
$from=(($pagina * $limit)- $limit);
 $data=$control->noticias($from,$limit,$orden,$buscar,$categoria,$id);
foreach($data as $data){ ?>
<div class="articulo">
<h3 title="<?=$data["titulo"];?>"><?=$data["titulo"];?></h3>
<img src="<?=$data["foto"];?>" class="imart"/>

<div class="descrip">
<p><?=$control::sanar($data["contenido"]);?></p>
</div>
<div class="leer" id="menu">
<!--***************************************************************************************-->
<menu id="menu">
<a onclick="via('noticias')" class="boton"title="atras">Atras</a>
</menu>
</div>
<div class="date">
<p><i class="fa fa-calendar"></i> PUBLICADO <?=$data["publicado"];?> </p>
<p class="autor"> <i class="fa fa-user"></i> <?=$data["user"];?></p>
<p><i class="fa fa-eye"></i> <?=$data["visitas"];?> Visitas</p>
<p class="autor"><i class="fa fa-comments"></i> <?php $cont=$control->comentariocont($data["id"]);?> COMENTARIOS</p>
<p><i class="fa fa-tags"></i> <?=$data["categoria"];?></p></div>
</div>
<?php } ?>
<div class="comentar">
<h2>Comentarios</h2>
<div class="comentarios">
<?php $come=$control->comentarioid($id);
foreach($come as $come){?>
<div class="comentarioscont">
<img src="<?=$come["foto"];?>" class="fotocom"/>
<p class="autor"><i class="fa fa-user"></i> <?=$come["autor"];?></p>
<p><?=$come["comentario"];?></p>
<p><i class="fa fa-calendar"></i> <?=$come["publicado"];?>
 <span class="autor"><i class="fa fa-tags"></i> <?=$data["categoria"];?></span></p>
</div>
<?php }
?>
</div>
<div class="formcom">
<form method="post" action="com.php">
<h2>Comentar</h2>
<input type="text" name="autor" placeholder="Nombre:"/>
<input type="text" name="correo" placeholder="Correo:"/>
<input type="hidden" name="id" value="<?=$_GET["id"];?>"/>
<input type="hidden" name="foto" value="imagenes/anonimo.png"/>
<textarea placeholder="Deja tu Comentario:" name="comentario"></textarea>	
<p><input type="submit" value="Enviar"/></p>
</form>
</div></div>
</div>

</div>
