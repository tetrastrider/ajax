<?php $usuario=strip_tags($_GET['usuario']);$password=strip_tags($_GET['password']);if(isset($usuario)&&!empty($usuario)&&isset($password)&&!empty($password)){$control->logearUsuario($usuario,md5($password));}else{echo '<script>window.location.assign("inicio")</script>';}