<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use app\models\Sections;
use app\models\Tokens;
use app\models\Log;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Json;
use yii\web\Response;
use yii\web\Session;
use yii\web\Cors;
use yii\db\Connection;

class SectionsController extends \yii\web\Controller
{

	public $hall;
	public $buildingId;

    public function actionIndex() {
        return $this->render('index');
    }

	public function connectToDb() {
		/// CREATE VIEW `maps`.`sections` AS SELECT * FROM `provost`.`sections`;
	}

	public function fetchBuildings() {

		$arr['ISC']		=  '0001';
		$arr['LIB']		=  '0002';
		$arr['DEK']		=  '0003';
		$arr['HHC']		=  '0004';
		$arr['HHN']		=  '0004';
		$arr['HHS']		=  '0004';
		$arr['NH']		=  '0005';
		$arr['MEM']		=  '0006'; /// ???
		$arr['SU']		=  '0007';
		$arr['MAIN']	=  '0008';
		$arr['EAST']	=  '0009';
		$arr['SH']		=  '0010';
		$arr['ELJ']		=  '0011'; /// ???
		$arr['TH']		=  '0012';
		$arr['LJP']		=  '0013'; /// ???
		$arr['WILL']	=  '0014';
		$arr['CHEM']	=  '0015';
		$arr['MACH']	=  '0016';
		$arr['ENGR']	=  '0017';
		$arr['PS']		=  '0018'; /// ???
		$arr['STEU']		=  '0018'; /// ???
		$arr['FV']		=  '0019';
		$arr['ARC']		=  '0021';
		$arr['STAB']	=  '0022'; /// ???
		$arr['CC']		=  '0023'; /// ???
		$arr['MH']		=  '0024';

		if (!$arr[$this->hall]) {
			$exp = explode(' ',$this->hall);
			return $exp[0];
		}

		return $arr[$this->hall];

	}

	public function fetchCoords() {

		$arr['0021'] = '40.690893,-73.962043';						///'ARC'
		$arr['0023'] = '40.6910285949707,-73.96123504638672';		///'CC'
		$arr['0015'] = '40.691675,-73.963465';						///'CHEM'
		$arr['0003'] = '40.690072,-73.964735';						///'DEK'
		$arr['0009'] = '40.691230,-73.963968';						///'EAST'
		$arr['0017'] = '40.691282,-73.962845';						///'ENGR'
		$arr['0019'] = '40.693477630615234,-73.96247100830078';		///'FV'
		$arr['flsh'] = '40.699693,-73.948233';						///'FLSH'
		$arr['0004'] = '40.687801361083984,-73.9640884399414';		///'HH'
		$arr['0001'] = '40.691750,-73.965083';						///'ISC'
		$arr['0011'] = '40.690330505371094,-73.96407318115234';		///'ELJ'
		$arr['0002'] = '40.690799713134766,-73.96505737304688';		///'LIB'
		$arr['0016'] = '40.69172668457031,-73.96295166015625';		///'MACH'
		$arr['0008'] = '40.691342,-73.964296';						///'MAIN'
		$arr['0006'] = '40.69157028198242,-73.96427154541016';		///'MEM'
		$arr['0024'] = '40.693454,-73.963549';						///'MH'
		$arr['crr'] = '40.698393,-73.972519';						///'CRR'
		$arr['0005'] = '40.69179916381836,-73.96444702148438';		///'NH'
		$arr['0013'] = '40.690120697021484,-73.96381378173828';		///'LJP'
		$arr['w14'] = '40.738000,-73.998900';						///'W14'
		$arr['0018'] = '40.690250396728516,-73.96299743652344';		///'PS'
		$arr['0010'] = '40.691054,-73.964238';						///'SH'
		$arr['0022'] = '40.69165802001953,-73.96163940429688';		///'SBL'
		$arr['0018'] = '40.690377,-73.962631';						///'STEU'
		$arr['0007'] = '40.691599,-73.963907';						///'SU'
		$arr['0012'] = '40.69010925292969,-73.96412658691406';		///'TH'
		$arr['0014'] = '40.692935943603516,-73.9635009765625';		///'WILL'

		return $arr[$this->buildingId];

	}

    public function actionLookup() {

    	$this->connectToDb();

		//$this->doLogEntry();
		//$this->checkToken();

		$arrBlds = $this->fetchBuildings();
		$arrCords = $this->fetchCoords();

		$request = Yii::$app->request;
		$posts = $request->post();
		//$params = $request->bodyParams;
		//$stuff = print_r($_POST, true);

    	header("Access-Control-Allow-Origin: *");

		$sql = "
			select *
			from sections
			where status = 'A' and
			(
				school like '%".addSlashes($_POST['filter'])."%' or
				subject like '%".addSlashes($_POST['filter'])."%' or
				coursenum like '%".addSlashes($_POST['filter'])."%' or
				title like '%".addSlashes($_POST['filter'])."%' or
				instructor_last like '%".addSlashes($_POST['filter'])."%'
			)
			and room IS NOT NULL

			order by crn
			limit 75
			";

		$connection = Yii::$app->getDb();
		$command = $connection->createCommand($sql);

		$result = $command->queryAll();

		$rowCount = count($result);

		foreach($result as $key => $val) {

			$course = $val['semester'].'-'.$val['subject'].'-'.$val['section'];

			$exp_rm = explode(' ',$val['room']);

			$this->hall = $exp_rm[0];
			$this->buildingId = $this->fetchBuildings();

			$coords = $this->fetchCoords();
			$coordsExp = explode(',',$coords);

			$line[] = '<li id=""
				data-building="'.$this->buildingId.'"
				data-roomname="'.$val['room'].'"
				data-lat="'.$coordsExp[0].'"
				data-long="'.$coordsExp[1].'"
				data-title="'.$val['title'].'"
				data-professor="'.$val['instructor_last'].'"
				data-course="'.$course.'"
				data-times="'.$val['time'].'"
				class=" list-group-item class-item ">
			<div class="li-col li-icon li-icon-course"></div>
			<div class="li-col li-label "><span class="list-group-point">'.$course.'</span></div>
			<div class="li-col li-bldg "><span>'.$val['title'].'</span></div>
			</li>';

		}

		echo join('',$line);

		die();

	}

    public function actionPull() {

    	$this->connectToDb();

		//$this->doLogEntry();
		//$this->checkToken();

		$request = Yii::$app->request;
		$posts = $request->post();
		//$params = $request->bodyParams;
		//$stuff = print_r($_POST, true);



		/* TODO remove this when going live */
    	header("Access-Control-Allow-Origin: *");

		$sql = " select * from sections limit 10 ";

		$connection = Yii::$app->getDb();
		$command = $connection->createCommand($sql);

		$result = $command->queryAll();

		$rowCount = count($result);

		$out[] = $rowCount;
		$out[] = $result;

		echo json_encode($out);

		//Yii::info('blah blah', 'own');

		die();

	}


}
