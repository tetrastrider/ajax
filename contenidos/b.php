
<?php }elseif(empty($id)){ ?>
<li><a href="blog">Noticias</a></li>
<li class="divider"></li>
<li class="activo"title="<?=$categoria;?>"><a><?=$categoria;?></a></li>
<?php }else{ if($da=$control->simple($id)){?>
<li><a href="blog">Noticias</a></li>
<li class="divider"></li>
<li class="activo"title="<?=$da["categoria"];?>"><a><?=$da["categoria"];?></a></li>
<li class="divider"></li>
<li class="activo"title="<?=$da["titulo"];?>"><a><?=$da["titulo"];?></a></li>
<?php } ?>
<?php } ?>
