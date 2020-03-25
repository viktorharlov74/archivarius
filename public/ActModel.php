<?php

include_once $_SERVER['DOCUMENT_ROOT']."/Classes/PHPExcel.php";
use Illuminate\Support\Facades\DB;
class ActModel
{

	// protected $cell_info="";
	public function __construct($id_req,$containers,$oranization="Организация",$adr="Рылеева 16"){

		$this->id_req=$id_req;
		$this->containers=$containers;
		$this->oranization=$oranization;
		$this->adr=$adr;
		$this->date=date("d.m.Y H:i");
		$this->filename='result'.$id_req.'.xlsx';
		$res_filename=DB::table('document')->where('request_id',$this->id_req)->get();
		$this->filecreate=(count($res_filename)==1) ? true: false;


	}

	public function CreateExel(){
		if (count($this->containers)>0)
		{
			if (!$this->filecreate){
				$xls = new PHPExcel();
				$shablon=\PHPExcel_IOFactory::createReader('Excel2007');
				$shablon = $shablon->load($_SERVER['DOCUMENT_ROOT'].'/Act.xlsx');
				$shablon->setActiveSheetIndex(0);
				$shablon->getActiveSheet()->setCellValue('C2', $this->oranization);
				$shablon->getActiveSheet()->setCellValue('C3', $this->adr);
				$shablon->getActiveSheet()->setCellValue('D4', $this->date);
				$shablon->getActiveSheet()->setCellValue('B7', strval(count($this->containers)));
				$start=14;
				foreach ($this->containers as $container) {
					$shablon->getActiveSheet()->setCellValue('B'.strval($start), $container->barcode);
					$start++;
				}
				

				$objWriter = PHPExcel_IOFactory::createWriter($shablon, 'Excel2007');
				$objWriter->save($this->filename);
				
				if ($this->addFileDB()){
					return  array('res' =>true,'value'=>'Акт создан. <a href="/'.$this->filename.'"> Скачать документ</a>');
				}
				else array('res' =>false,'value'=>'Ошибка добавления в БД');
				
			}
			else return array('res' =>false,'value'=>'Файл Уже создан');

			// $sheet=$xls->setActiveSheetIndex(0);
			// $catList = [
			// 	['name' => 'Tom', 'color' => 'red'],
			// 	['name' => 'Bars', 'color' => 'white'],
			// 	['name' => 'Jane', 'color' => 'Yellow'],
			// ];
			// $columnPosition = 0; // Начальная координата x
			// $startLine = 2; // Начальная координата y
			// $sheet->setCellValueByColumnAndRow($columnPosition, $startLine, 'Our cats');
			// $objWriter = \PHPExcel_IOFactory::createWriter($xls, 'Excel5');

			// $objWriter->save("CatList.xls");

			
		}
		else return array('res' =>false,'value'=>'нету контейнеров');
	}

	public function addFileDB(){
		if (!$this->filecreate){
			$rez=DB::table('document')->insert([
		        'request_id'=> $this->id_req,
		        'filename'=>$this->filename,
		        'type'=>'CONTAINERS_ACT',
		       ]);
		}
		$this->filecreate=true;
		return $rez;
	}

}
