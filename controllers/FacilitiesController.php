<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use app\models\Facilities;
use app\models\FacilitiesSearch;
use app\models\Tokens;
use app\models\Log;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Json;
use yii\web\Response;
use yii\web\Session;


/**
 * FacilitiesController implements the CRUD actions for Facilities model.
 */
class FacilitiesController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],

            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index', 'view', 'create', 'update', 'delete'],
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],

        ];
    }

    public function actionInfo()
	{
		return \Yii::createObject([
			'class' => 'yii\web\Response',
			'format' => \yii\web\Response::FORMAT_JSON,
			'data' => [
				'message' => 'hello world',
				'code' => 100,
			],
		]);
	}

	private function doLogEntry() {

	    $log = new Log();
    	$log->remote_addr		= $_SERVER['REMOTE_ADDR'];
    	$log->user_agent		= $_SERVER['HTTP_USER_AGENT'];
    	$log->request_method	= $_SERVER['REQUEST_METHOD'];
		$log->server_info		= json_encode($_SERVER);
		$log->session_info		= json_encode(Yii::$app->session);
    	$log->request_info		= json_encode($_REQUEST);

    	if($log->save(false)){
			return true;
    	} else {
			$arr['success'] = false;
			$arr['message'] = 'Error. Log entry not saved.';
			echo json_encode($arr);
			die();
    	}

	}

	private function checkToken() {

		if ($_SERVER['REQUEST_METHOD']=='GET'){
			$reqtokn = addslashes($_GET['token']);
		};
		if ($_SERVER['REQUEST_METHOD']=='POST'){
			$reqtokn = addslashes($_POST['token']);
		};

		$token = Tokens::find()
			->where('token = :token', [':token' => $reqtokn])
			->andWhere('create_date > :create_date', [':create_date' => date('Y-m-d')])
			->one();

		if (date('Y-m-d',strtotime($token->attributes['create_date'])) != date('Y-m-d')) {

			$arr['request'] = $_REQUEST;
			$arr['match'] = $token->attributes;
			$arr['date'] = date('Y-m-d');
			$arr['cdate'] = date('Y-m-d',strtotime($token->attributes['create_date']));
			$arr['success'] = false;
			$arr['message'] = 'invalid token';

			header('Content-Type: application/json');
			echo json_encode($arr);
			die();
		}

	}

	private function checkRemote($remote) {

		if (strpos($remote, ALLOWED_IPS) === false) {
			$arr['success'] = false;
			$arr['message'] = 'Error. Remote address not recognized.';
			echo json_encode($arr);
			die();
		} else {
			return true;
		}
	}

	public function actionPut() {

		$this->doLogEntry();
		$this->checkToken();
		$remote = $this->checkRemote($_SERVER['REMOTE_ADDR']);

    	header("Access-Control-Allow-Origin: *");

    	$model = $this->findModel($_POST['id']);

		$model->accessible			= addslashes($_POST['info']['accessible']);
		/// $model->bldg_abbre			= addslashes($_POST['info']['bldgAbbr']);
		$model->bldg_name			= addslashes($_POST['info']['bldgName']);
		/// $model->bldg_code			= ltrim(addslashes($_POST['info']['buildingId']),'0');
		/// $model->floor				= ltrim(addslashes($_POST['info']['floorId']),'0');
		$model->room_name			= addslashes($_POST['info']['label']);
		/// $model->latitude			= addslashes($_POST['info']['latitude']);
		/// $model->longitude			= addslashes($_POST['info']['longitude']);
		$model->new_room_no			= addslashes($_POST['info']['newRoomNo']);

		//$model->gk_display			= addslashes($_POST['info']['gkDisplay']);
		$model->gk_display			= 'Y';
		$model->gk_category			= addslashes($_POST['info']['category']);
		$model->gk_fontsize			= addslashes($_POST['info']['fontSize']);
		$model->gk_partialpath		= addslashes($_POST['info']['partialPath']);
		$model->gk_showoncreation	= addslashes($_POST['info']['showOnCreation']);
		$model->gk_showtooltip		= addslashes($_POST['info']['showToolTip']);
		$model->gk_tooltiptitle		= addslashes($_POST['info']['tooltipTitle']);
		$model->gk_tooltipbody		= addslashes($_POST['info']['tooltipBody']);
		$model->gk_type				= addslashes($_POST['info']['type']);

		if ($model->save(false)) {
			$arr['success']	= true;
			$arr['message']	= '';
			$arr['remote']	= $remote;
			//$arr['id']	= $model->id;
			//$arr['post']	= json_encode($_POST);
		} else {
			$arr['success'] = false;
			$arr['message'] = 'Error. Changes were not saved.';
		}

		header('Content-Type: application/json');
		echo json_encode($arr);
		die();
	}

    public function actionGet() {

		$this->doLogEntry();
		$this->checkToken();

    	header("Access-Control-Allow-Origin: *");

		$sql = "
		select * from facilities
		where gk_display = 'Y'
		or gk_department != ''


		/*
		space_type not in (7500,7700,7600)
		and department not in ('CIRCULATION','INACTIVE','UNUSABLE')

		and room_name != ''
		and room_name != 'office'

		and floor not like '%bsm%'

		and room_name not like '%ele%'
		and room_name not like '%class%'
		and room_name not like '%storage%'
		and room_name not like '%corr%'
		and room_name not like '%cl.%'
		and room_name not like '% cl%'
		and room_name not like '%mech%'
		and room_name not like '%inactive%'
		and room_name not like '%tele%'
		and room_name not like '%equip%'
		and room_name not like '%closet%'
		and room_name not like '%elec%'
		and room_name not like '%lobby%'
		and room_name not like '%shower%'
		and room_name not like '%switch%'
		and room_name not like '%janit%'
		and room_name not like '%server%'
		and room_name not like '%studio%'
		and room_name not like '%asso%'
		and room_name not like '%booth%'
		and room_name not like '%cubicle%'
		and room_name not like '%seat%'


		and room_name not like '%men%'
		and room_name not like '%fac%'
		and room_name not like '%tech%'
		*/

		";

		if ($_GET['building'] != '') {
			$bldg = addslashes($_GET['building']);
			$sql .= " AND bldg_abbre = '$bldg' ";
		}

		if ($_GET['webapp']=='display') {
			$sql .= " AND gk_display != 'N' ";
		}

		if ($_GET['webapp']!='manage') {
			$sql .= " AND gk_display != 'N' ";
		}

		$sql .= " group by bldg_abbre, floor, gk_department, department, room_name ";

		$sql .= " order by bldg_abbre asc, room_name asc, floor asc, new_room_no asc, department asc ";

		//$_GET['limit'] = '10';
		if ($_GET['limit'] > '0') {
			$limit = addslashes($_GET['limit']);
			$sql .= " limit $limit ";
		}

		$connection = Yii::$app->getDb();
		$command = $connection->createCommand($sql);

		$result = $command->queryAll();

		$rowCount = count($result);

		if ($result[0]) {

			$out['type'] = 'FeatureCollection';

			$i = 0;

			foreach($result as $key=>$value) {

				foreach($value as $key2=>$value2) {
					$value2 = trim($value2);
					//$value2 = str_replace("'", '', $value2);
					//$value2 = str_replace('"', '', $value2);
					$value2 = mb_convert_encoding($value2, 'UTF-8', 'UTF-8');
					//$value[$key2] = addslashes($value2);
					$value[$key2] = str_replace("\\\\", "\\", $value[$key2]);
				}

				$value['floor'] = preg_replace('/[^0-9,.]/', '', trim($value['floor']));

				if (trim($value['floor']) == '') {
					$value['floor'] = '1';
				}

				$value['room_name'] = ucwords(strtolower($value['room_name']));
				//$value['room_name'] = 'hello';

				if (trim($value['space_type']) == '7701') {
					$value['room_name'] = 'Restroom';
				}

				// 	if (trim($value['gk_department']) == '' && $value['gk_display'] != 'Y') {
				// 		$skip = false;
				// 		$needles[] = 'fac';
				// 		$needles[] = 'ofc';
				// 		$needles[] = 'conf';
				// 		$needles[] = 'wom';
				// 		foreach($needles as $needle) {
				// 			$pos = stripos('_'.$value['room_name'], $needle);
				// 			if ($pos > 0) {
				// 				$skip = true;
				// 			}
				// 		}
				// 		if ($skip) {
				// 			continue;
				// 		}
				// 	}

				$value['bldg_code'] = str_pad($value['bldg_code'], 4, '0', STR_PAD_LEFT);
				$value['floor'] = str_pad($value['floor'], 4, '0', STR_PAD_LEFT);

				$out['features'][$i]['type'] = 'Feature';

				//$out['features'][$i]['properties']['buildingId']		= trim($value['bldg_code']);
				$out['features'][$i]['properties']['buildingId']		= '0001';
				//$out['features'][$i]['properties']['floorId']			= trim($value['floor']);
				$out['features'][$i]['properties']['floorId']			= '0001';
				$out['features'][$i]['properties']['label']				= trim($value['room_name']);

				$out['features'][$i]['properties']['location']			= '';
				$out['features'][$i]['properties']['type']				= '';

				//$out['features'][$i]['properties']['base64']			= '';

				$out['features'][$i]['properties']['mapLabelId']		= trim($value['id']);

				$out['features'][$i]['properties']['category']			= trim($value['gk_category'])=='' ? 'Label' : trim($value['gk_category']);
				$out['features'][$i]['properties']['fontSize']			= trim($value['gk_fontsize'])<'2' ? intval(24) : intval(trim($value['gk_fontsize']));
				$out['features'][$i]['properties']['partialPath']		= trim($value['gk_partialpath'])=='' ? 'Information' : trim($value['gk_partialpath']);
				$out['features'][$i]['properties']['showOnCreation']	= trim($value['gk_showoncreation'])=='' ? false : trim($value['gk_showoncreation']);
				$out['features'][$i]['properties']['showToolTip']		= trim($value['gk_showtooltip'])=='' ? false : trim($value['gk_showtooltip']);
				$out['features'][$i]['properties']['tooltipTitle']		= trim($value['gk_tooltiptitle'])=='' ? '' : trim($value['gk_tooltiptitle']);
				$out['features'][$i]['properties']['tooltipBody']		= trim($value['gk_tooltipbody'])=='' ? '' : trim($value['gk_tooltipbody']);
				$out['features'][$i]['properties']['type']				= trim($value['gk_type'])=='' ? 'IconWithText' : trim($value['gk_type']);

				$out['features'][$i]['geometry']['type']				= 'Point';

				//$out['features'][$i]['geometry']['coordinates'][]		= trim($value['longitude']);
				//$out['features'][$i]['geometry']['coordinates'][]		= trim($value['latitude']);

				//$out['features'][$i]['geometry']['coordinates'][]		= -94.58123779296875;
				//$out['features'][$i]['geometry']['coordinates'][]		= 39.045143127441406;

				$out['features'][$i]['geometry']['coordinates'][]		= floatval(-94.58 . rand(10000000000, 99999999999));
				$out['features'][$i]['geometry']['coordinates'][]		= floatval( 39.04 . rand(100000000000,999999999999));

				if (trim($value['new_room_no']) == '') {
					$value['new_room_no'] = '-';
				}

				if (trim($value['gk_display']) == '') {
					$value['gk_display'] = '-';
				}

				$out['features'][$i]['user_properties']['recordId']			= trim($value['id']);
				$out['features'][$i]['user_properties']['accessible']		= trim($value['accessible']);
				$out['features'][$i]['user_properties']['bldgName']			= trim($value['bldg_name']);
				$out['features'][$i]['user_properties']['bldgAbbr']			= trim($value['bldg_abbre']);
				$out['features'][$i]['user_properties']['roomNo']			= trim($value['room_no'])==''?'1':trim($value['room_no']);
				$out['features'][$i]['user_properties']['newRoomNo']		= trim($value['new_room_no']);
				$out['features'][$i]['user_properties']['gkDisplay']		= trim($value['gk_display']);
				$out['features'][$i]['user_properties']['gkDepartment']		= trim($value['gk_department']);
				$out['features'][$i]['user_properties']['count']			= $i . ' ' . $rowCount;
				//$out['features'][$i]['user_properties']['sql']			= $sql;

				$i++;

			}
		} else {
			$out['success'] = false;
			$out['message'] = 'no matches';
			$out['sql'] = $sql;
		}

		// 	echo '<pre>';
		// 	print_r($out);
		// 	echo '</pre>';
		// 	die();

		header('Content-Type: application/json');
		//echo json_encode($out, JSON_PRETTY_PRINT);
		echo json_encode($out);
		die();

    }

    public function actionToggle() {

    	$sql = " UPDATE facilities SET gk_display = '".addslashes($_POST['display'])."' WHERE id = '".addslashes($_POST['id'])."' ";

		try {
		    $connection = Yii::$app->getDb();
			$command = $connection->createCommand($sql);
			$result = $command->query();
			$arr['success'] = true;
			$arr['message'] = '';
		} catch (\yii\db\Exception $e) {
			$arr['success'] = true;
			$arr['message'] = $e;
		}

		header('Content-Type: application/json');
		echo json_encode($arr);
		die();

    }

    public function actionLookup() {

    	//die();

    	if (@$_GET['field']=='') {
    		$out[] = 'no match';
    		return Json::encode($out);
			die();
    	}

		$connection = Yii::$app->getDb();
		$command = $connection->createCommand("
			SELECT DISTINCT(".$_GET['field'].")
			FROM facilities
			ORDER BY ".$_GET['field']." ASC ");

		$result = $command->queryAll();

		if ($result[0]) {
			foreach($result as $key=>$value) {
				$rec = trim($value[$_GET['field']]);
				if ($rec > '0') {
					//$rec = preg_replace('/[^A-Za-z0-9\. -]/', '', $rec);
					$out[] = $rec;
				}
			}
		} else {
			$out[] = 'no match';
		}

		return Json::encode($out);
		die();
    }

    /**
     * Lists all Facilities models.
     * @return mixed
     */
    public function actionIndex()
    {
    	//die();

        $searchModel = new FacilitiesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Facilities model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
    	//die();

        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Facilities model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
    	die();

        $model = new Facilities();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Facilities model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
    	//die();

        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
			Yii::$app->session->setFlash('success', "Success, the record has been updated.");
            return $this->redirect(['update', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Facilities model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
    	die();

        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Facilities model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Facilities the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Facilities::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
