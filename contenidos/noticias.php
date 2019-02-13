<div class="limite">
<form name="orden" method="get">
<label class="m custom-select">
<select onchange="alex.from(document.orden.cambio.value,'noticia','contenidos/cuerpo.php',document.orden.limit.value)" name="limit">
<option <?= $si?> value=5>5</option>
<option <?= $si2?> value=10>10</option>
<option <?= $si3?> value=15>15</option>
<option <?= $si4?> value=20>20</option>
<option <?= $si5?> value=25>25</option>
<option <?= $si6?> value=30>30</option>
</select>
</label>
<label class="n custom-select">
<select onchange="alex.from(document.orden.cambio.value,'noticia','contenidos/cuerpo.php',document.orden.limit.value)" name="cambio">
<option <?= $ok?> value=1>publicaciones anteriores</option>
<option <?= $ok1?> value=0>publicaciones nuevas</option>
</select></label> </form>
</div>

<div class="buscar">
<form name="buscador" action="noticias">
  <input type="text" name="b" placeholder="buscar:"/>
  <span class="boton bus" onclick="buscar(document.buscador.b.value)" value="buscar"title="buscar"></span></form>
</div>

<div class="servicios">
<div id="noticia">

<?php 
$total=$control->paginacion($limit,$buscar,$categoria);
$from=(($pagina * $limit)- $limit);
 $data=$control->noticias($from,$limit,$orden,$buscar,$categoria,$id);
foreach($data as $data){ ?>
<div class="articulo">

<img src="<?=$data["foto"];?>" class="imart"/>
<h3 title="<?=$data["titulo"];?>"><?=strtolower($data["titulo"]);?></h3>
<div class="descrip">
<p><?php echo $control::sanar($control->leermas($data["contenido"],1500));?></p>
</div>
<div class="leer">

<a class="boton" onclick="alex.val(<?=$data["id"];?>)" title="leer mas">leer mas</a>

</div>
<div class="date">
<p><i class="fa fa-calendar"></i> publicado <?=$data["publicado"];?> </p>
<p class="autor"> <i class="fa fa-user"></i> <?=$data["user"];?></p>
<p><i class="fa fa-eye"></i> <?=$data["visitas"];?> visitas</p>
<p class="autor"><i class="fa fa-comments"></i> <?php $cont=$control->comentariocont($data["id"]);?> comentarios</p>
<p><i class="fa fa-tags"></i> <?=$data["categoria"];?></p></div>
</div>
<?php } ?>
<div class="paginador">
<ul class="pagina">
<?php if($pagina==1){ ?><li class="selecion">inicio</li><?php }else{ ?><li><a onclick="alex.pag(1,'<?=$orden?>','<?=$limit?>')">inicio</a></li><?php } ?>
<?php if($pagina==1){ ?><li class="selecion">anterior</li><?php }else{ ?><li><a onclick="alex.pag('<?= $ant?>','<?=$orden?>','<?=$limit?>')">anterior</a></li><?php } ?>
<li><?=$pagina?></li>
<?php if($pagina==$total){ ?><li class="selecion">siguiente</li><?php }else{ ?><li><a onclick="alex.pag('<?= $sig?>','<?=$orden?>','<?=$limit?>')">siguiente</a></li><?php } ?>
<?php if($pagina==$total){ ?><li class="selecion">fin</li><?php }else{ ?><li><a onclick="alex.pag('<?=$total?>','<?=$orden?>','<?=$limit?>')">fin</a></li><?php } ?>
  </ul>
  </div>
</div>
<div class="categoria">
<h2>categorias</h2>
<div class="cat">
<?php $datos=$control->categoria();foreach($datos as $datos){?><a onclick="alex.cat('<?=$datos["categoria"];?>')"><p><i class="fa fa-tags"></i> <?=$datos["categoria"];?> </p></a><?php } ?>
<a onclick="alex.cat('')"><p><i class="fa fa-tags"></i> todas </p></a>
</div>
<h2>ultimos comentarios</h2>
<div class="combello">
<?php $come=$control->comentario();
foreach($come as $come){?>
<a onclick="alex.val(<?=$come["id_contenido"];?>)"><div class="comecont">
<img src="<?=$come["foto"];?>" class="fotocom"/>
<p class="autor"><i class="fa fa-user"></i> <?=$come["autor"];?></p>
<p><?=$control->leermas($come["comentario"],155);?></p>
<p><i class="fa fa-calendar"></i> <?=$come["publicado"];?>
 <span class="autor"><i class="fa fa-tags"></i> <?=$data["categoria"];?></span></p>
</div></a>
<?php }
?>
</div>
<!--audioplayer-->
<h2>musica</h2>
<audio id="audio" preload="auto" tabindex="0" controls="" type="audio/mpeg">
        <?php $si=$control->simusica(); foreach($si as $si):?>
        <source type="audio/mp3" src="<?=$si['musica']?>">
       <?php endforeach?>
    </audio>
            <ul id="playlist">
             <?php $mu=$control->musica(); foreach($mu as $mu):?>
        <li>
            <a href="<?=$mu['musica']?>">
                <h6><i class="fa fa-music"></i> <?=$mu['titulo']?></h6>
            </a>

        </li>
       <?php endforeach?>
    </ul>
<h2>enlases &uacute;tiles</h2>
    
  <div class='enlases'>
    <?php $link=$control->link(); foreach($link as $link):?>
    <a href="<?=$link['link']?>"title='<?=$link['nombre']?>'><h6><?=$link['nombre']?></h6></a>
    <?php endforeach ?>
  </div>
</div>

</div>
