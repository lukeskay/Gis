<?php
    if (isset($_POST['cuenta'] ) || isset($_POST['distrito'])){
	$v_cta=$_POST['cuenta'];
	$v_dist=$_POST['distrito'];
	// $v_cta='123';
	// $v_dist='19150';
	
	$conexion=pg_connect("host=150.150.122.166 port= 5432 dbname=Principal user=postgres password=milk2k1")or die("NO se pudo conectar la base de datos".pg_last_error());
	
	
	$sql="SELECT  clientes.inm_cod,clientes.inm_doc,clientes.inm_nomcli,clientes.tipocli,agen_distri.inm_dist,cuentas.inm_cta,cuentas.inm_scta,
         cuentas.tip_cuenta,cuentas.inm_codusu,agencias.inm_age,agencias.age_nom,inmuebles.inm_supter,
          inmuebles.inm_supcub,inmuebles.inm_eda,inmuebles.inm_tipedi,inmuebles.coef_edif,domicilios.loc_prov,domicilios.inm_loc,
          domicilios.inm_bar,domicilios.inm_cal,domicilios.inm_nro,domicilios.inm_pis,domicilios.inm_dto,domicilios.inm_man,
          domicilios.inm_blk,domicilios.inm_lot,domicilios.inm_cas
          FROM agen_distri join agencias on agen_distri.inm_age=agencias.inm_age join cuentas on agencias.inm_age=cuentas.inm_age
          join clientes on cuentas.inm_cod=clientes.inm_cod join inmuebles on clientes.inm_cod=inmuebles.inm_cod join domicilios 
          on inmuebles.inm_cod=domicilios.inm_cod where (inm_dist=$v_dist) AND (inm_cta=$v_cta)";
	$resultado=pg_query($conexion,$sql);
	if (!$resultado){
		die("Error, no se ejecutó la consulta.");
	}else{
		$array["data"]=[];
		while ($data=pg_fetch_assoc($resultado)){
			$array["data"][]=$data;
		};
		echo json_encode($array);
	};
	pg_free_result($resultado);
	pg_close($conexion);

};
?>
