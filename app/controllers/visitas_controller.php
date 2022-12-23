<?php
require_once "core/Controller.php";
require_once "core/Session.php";
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
/**
 * 
 */
class VisitasController extends ControllerRest
{
	function get(){
		Session::load();
		VisitaModel::create_table();
		$user = UserModel::user_logged();
		if(is_null($user)){
			header('location: /login/');
			return;
		}
		if(Session::g('control_visitas')){
			header('location: /');
			return;
		}
		
		$headers  = VisitaModel::get_vars();
		$headers[] = "fecha";
		$page = $this->get_param("page");
		$desde = $this->get_param("desde");
		$hasta = $this->get_param("hasta");
		$apartamento =  $this->get_param("apartamento");
		
		$visitado = $this->get_param("visitado");
		$page = $page?$page:1;
		if(!$user->is_admin()){
			$condicion = [['cliente','=',$user->get_key()]];
            if($visitado)$condicion[]=["visitado",'=',$visitado];
            if($desde)$condicion[]=["create_at",'>=', $desde];
            if($hasta)$condicion[]=["create_at", '<=',$hasta.=" 23:59:59"];
			$vars = array_filter(VisitaModel::get_vars(),function($a){ return $a != 'cliente';});
			$count = VisitaModel::count($condicion);
			$items = VisitaModel::all_where_and($condicion,20,$page);	
		}else{
			$condicion = [];
			if($visitado)$condicion[]=["visitado",'=',$visitado];
            if($desde)$condicion[]=["create_at",'>=', $desde];
            if($hasta)$condicion[]=["create_at", '<=',$hasta.=" 23:59:59"];
			$vars = VisitaModel::get_vars();
			$count = VisitaModel::count($condicion);
			$items = VisitaModel::all_where_and($condicion,20,$page);
		}
		$vv = new VisitasView(array(
			'items' => $items,
			'filtros'=> ['desde' => $desde ,'hasta' => $hasta ,'visitado' => $visitado,'apartamento'=>$apartamento],
			'user'=> $user,
			"table_vars" => $vars,
			'page'=> $page,
			'count'=>$count,
			"modal_class" => 'VisitaModel',
            'hide_modified' => true,
            'hide_actions' => true
		));
		return $vv->render();
	}

	function reporte(){
		Session::load();
		$user = UserModel::user_logged();
		$spreadsheet = new Spreadsheet();
		$cc = [];
		$desde = $this->get_param("desde");
		$hasta = $this->get_param("hasta");
		if(!$user->is_admin()){
			$cc = [['cliente','=',$user->get_key()]];
		}
		$condv = $cc;
		if($desde)$condv[]=["create_at",'>=', $desde];
        if($hasta)$condv[]=["create_at", '<=',$hasta.=" 23:59:59"];
		$apartamento =  $this->get_param("apartamento");

		$edi =  EdificioModel::all_where_and($cc,null,true);
	

		// Set document properties
		$spreadsheet->getProperties()->setCreator('Gestor de Visitas')
			    ->setLastModifiedBy('RemotePCSolutions')
			    ->setTitle('Reporte de Visitas')
			    ->setSubject('Reporte de Visitas')
			    ->setDescription('Reporte de Visitas XLSX.')
			    ->setCategory('Test result file');

		$spreadsheet->setActiveSheetIndex(0);
		$build = 1;
		foreach ($edi as $edificio) {
			$spreadsheet->createSheet();
			$linea = 1;
			$condicion = $cc;
			$condicion[] = ["edificio", "=","{$edificio->ID}"];
			$apartamentos = ApartamentoModel::all_where_and($condicion,null,null, false);
			//print_r($apartamentos);
			$spreadsheet->setActiveSheetIndex($build)

			->setCellValue('C'.$linea, "NOMBRE")
			->setCellValue('B'.$linea, "IDENTIFICACION")
			->setCellValue('A'.$linea, "FECHA")
			->setCellValue('D'.$linea, "DESTINO");
			
			$linea++;
			
			foreach($apartamentos as $apartamento) {
				$cond = $condv;
				$cond[] = ["destino","=","{$apartamento->ID}"];
				$visitas = VisitaModel::all_where_and($cond,null,null,true);
				//print_r($visitas);
				foreach ($visitas as $visita) {
					//print_r($myWorkSheet);
					$spreadsheet->setActiveSheetIndex($build)
					->setCellValue('C'.$linea, $visita->nombre)
					->setCellValue('B'.$linea, "".$visita->identificacion)
					->setCellValue('A'.$linea, "".$visita->get_create_at())
					->setCellValue('D'.$linea,$visita->destino->load()->nombre);
					$linea++;
				}
					
			}
            
            $invalidCharacters = $spreadsheet->setActiveSheetIndex($build)->getInvalidCharacters();
            $title = str_replace($invalidCharacters, '_', $edificio->load()->nombre);
            $spreadsheet->getActiveSheet()->setTitle($title);
			$build++;
			
		}
		
		$spreadsheet->removeSheetByIndex(0);
		
		$writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
		header('Cache-Control: max-age=0');
		header('Cache-Control: max-age=1');
		header("Content-type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
		header('Content-disposition: attachment;filename="reporte.xlsx"');
		header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
		header('Pragma: public'); // HTTP/1.0
		$writer->save('php://output');


	}
}