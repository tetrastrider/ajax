 
<div class="acerca">
<div class="ofrecidos">
	<div class="tucked-corners-top">
<div class="ofrecidos tucked-corners-bottom" id="code">
<?php $acerca = $control->acerca(); ?>
                    <?php foreach($acerca as $acerca){ ?>
                        <b><?= $acerca['acerca']; ?></b>
                    <?php } ?>
                </div></div>
</div>
</div>