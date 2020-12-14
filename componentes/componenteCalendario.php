<?php
if($formato == ""){
    $formato = ($hora) ? "%d/%m/%Y %H:%M:%S" : "%d/%m/%Y";
}
?>
<div class="row">
	<div class="col-md-10">
		<div class="input-group" id="datetimepicker2">
            <input type="text" class="form-control date" name="<?=$nomeCampo?>" id="<?=$nomeCampo?>" value="<?=$valorInicial?>" size="18" <?=$complemento?> />
            <span class="input-group-addon">
                <span class="glyphicon glyphicon-calendar" id="btnData<?=$nomeCampo;?>" style="cursor: pointer; border-width: 0px"></span>
            </span>
        </div>
        <script type="text/javascript">
        Calendar.setup({
            inputField : "<?=$nomeCampo;?>",
            trigger    : "btnData<?=$nomeCampo;?>",
            onSelect   : function() { this.hide();},
            showTime   : 24,
            dateFormat : "<?=$formato?>"
        });
        </script>
	</div>
</div>