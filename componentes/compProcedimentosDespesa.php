<?php 
$aProcedimentoServidor = $oControllerSicasProcedimentoAutorizado->getAllProcedimentoServidor(18);
//Util::trace($aProcedimentoServidor);
?>
<table class="table table-condensed table-striped">
<?php 
if($aProcedimentoServidor){
?>
	<thead>
		<tr>
			<th>Guia</th>
			<th>Paciente</th>
			<th>Categoria</th>
			<th>Procedimento</th>
			<th>Data</th>
			<th>Qtd. Procedimentos</th>
			<th>Qtd. Proc. Realizados</th>
			<th>Valor Servico (R$)</th>
			<th>Desconto</th>
			<th>Valor a Descontar(R$)</th>
		</tr>
	</thead>
	<tbody>
<?php 
    foreach($aProcedimentoServidor as $oProcedimentoServidor){
?>
		<tr>
			<td><?=$oProcedimentoServidor['cd_encaminhamento']?></td>
    		<td><?=$oProcedimentoServidor['nm_pessoa']?></td>
    		<td><?=$oProcedimentoServidor['categoria']?></td>
    		<td><?=$oProcedimentoServidor['nm_procedimento']?></td>
    		<td><?=Util::formataDataHoraBancoForm($oProcedimentoServidor['dt_encaminhamento'])?></td>
    		<td><?=$oProcedimentoServidor['qtd_procedimento']?></td>
    		<td><?=$oProcedimentoServidor['qtd_procedimento']?></td>
    		<td><input type="text" class="form-control input-sm" name="val_servico_realizado[]" id="val_servico_realizado[]" /></td>
    		<td><input type="text" class="form-control input-sm" name="desconto_servidor[]" id="desconto_servidor[]" /></td>
    		<td><input type="text" class="form-control input-sm disabled" name="val_servico_realizado[]" id="val_servico_realizado[]" /></td>
    	</tr>
<?php
    }
?>
	</tbody>
<?php 
} else {
?>    	
	<tr class="warning">
		<td colspan="8">Nenhum procedimento autorizado foi encontrado.</td> 
	</tr>
<?php 
}
?>
</table>