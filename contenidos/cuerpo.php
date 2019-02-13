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
<?php if($pagina==1){ ?><li class="selecion">Inicio</li><?php }else{ ?><li><a onclick="alex.pag(1,'<?=$orden?>','<?=$limit?>')">Inicio</a></li><?php } ?>
<?php if($pagina==1){ ?><li class="selecion">Anterior</li><?php }else{ ?><li><a onclick="alex.pag('<?= $ant?>','<?=$orden?>','<?=$limit?>')">Anterior</a></li><?php } ?>
<li><?=$pagina?></li>
<?php if($pagina==$total){ ?><li class="selecion">Siguiente</li><?php }else{ ?><li><a onclick="alex.pag('<?= $sig?>','<?=$orden?>','<?=$limit?>')">Siguiente</a></li><?php } ?>
<?php if($pagina==$total){ ?><li class="selecion">Fin</li><?php }else{ ?><li><a onclick="alex.pag('<?=$total?>','<?=$orden?>','<?=$limit?>')">Fin</a></li><?php } ?>
	</ul>
	</div>

</div>