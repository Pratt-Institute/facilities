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
			$arr['remote'] = $remote;
			$arr['message'] = 'Error. Remote address not recognized.';
			echo json_encode($arr);
			die();
		} else {
			return true;
		}
	}


	public function actionLoad() {

		echo 'loads done';
		die();
		return true;

		$path = '/Users/iancampbell/Sites/points_sample.json';

		$myfile = fopen($path, "r") or die("Unable to open file!");
		$contents = fread($myfile,filesize($path));

		$obj = json_decode($contents, true);

		foreach ($obj['features'] as $key=>$value) {

			if ($value['properties']['SUITE']) {

				echo "<p>";
				// 	echo '<br>Building: '.$bldg = $value['properties']['buildingId'];
				// 	echo '<br>Floor: '.$floor = $value['properties']['floorId'];
				// 	echo '<br>Room: '.$room = $value['properties']['SUITE'];

				$bldg = $value['properties']['buildingId'];
				$floor = $value['properties']['floorId'];
				$room = $value['properties']['SUITE'];

				$label = $value['properties']['label'];
				$label = mb_convert_encoding($label, 'UTF-8', 'UTF-8');
				$label = iconv("UTF-8", "UTF-8//IGNORE", $label);
				$label = preg_replace("/[^\\x00-\\xFFFF]/", "", $label);
				$label = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $label);

				$category = $value['properties']['CATEGORY'];

				//$label_exp = explode(',',$label);
				//$label_exp = explode(' ',$label);
				$label_exp = explode('.',$label);
				$label0 = addslashes($label_exp[0]);

				$sql = "
					select
						id,
						bldg_abbre,
						room_no,
						new_room_no,
						room_name,
						gk_bldg_id,
						gk_floor_id,
						latitude,
						longitude

					from facilities
					where gk_bldg_id = '$bldg'
					and gk_floor_id = '$floor'
					/*and (room_no like '%$room%' or new_room_no like '%$room%' or room_name like '%$label0%')*/
					/*and (room_no like '%$room%' or new_room_no like '%$room%')*/

					and (room_name like '%$category%')

					";

				$connection = Yii::$app->getDb();
				$command = $connection->createCommand($sql);

				$result = $command->queryAll();

				$rowCount = count($result);

				if ($result[0]) {

					foreach($result as $key1=>$value1) {

						$id			= $value1['id'];
						$latitude	= $value['properties']['latitude'];
						$longitude	= $value['properties']['longitude'];

						if (strlen(strval($value1['latitude'])) < 12) {

							//echo "<pre>";
							//echo $key1;
							//print_r($value1);
							//echo "</pre>";

        					$model = $this->findModel($id);

        					//echo "<pre>";
        					//print_r($model);
        					//echo "</pre>";

							$model->latitude		= $latitude;
							$model->longitude		= $longitude;

							if($model->save(false)){
								echo '<br>saved '.$id;
								//die();
							} else {
								$arr['success'] = false;
								$arr['message'] = 'Error. Log entry not saved.';
								echo json_encode($arr);
								die();
							}
						}
					}

				} else {

					echo "<p>Not Found: ".$sql;
					echo "<br>".$bldg.' -- '.$floor;
					echo "<pre>";
					echo $key;
					print_r($value);
					echo "</pre>";
					//die();

				}
			}
		}

		fclose($myfile);

		die();

		return true;
	}


	public function actionPut() {

		// 	header('Content-Type: application/json');
		// 	echo json_encode($_POST);
		// 	die();

		foreach($_POST['info'] as $key=>$value) {
			if ($value == '-') {
				$_POST['info'][$key] = '';
			}
		}

		$arr['post'] = json_encode($_POST);

		$this->doLogEntry();
		$this->checkToken();
		$remote = $this->checkRemote($_SERVER['REMOTE_ADDR']);

		/* TODO remove this when going live */
    	header("Access-Control-Allow-Origin: *");

    	$model = $this->findModel($_POST['id']);

		$model->accessible			= addslashes($_POST['info']['accessible']);
		/// $model->bldg_abbre			= addslashes($_POST['info']['bldgAbbr']);
		/// $model->bldg_name			= addslashes($_POST['info']['bldgName']);
		/// $model->bldg_code			= ltrim(addslashes($_POST['info']['buildingId']),'0');
		/// $model->floor				= ltrim(addslashes($_POST['info']['floorId']),'0');
		$model->room_name			= addslashes($_POST['info']['label']);
		$model->latitude			= addslashes($_POST['info']['latitude']);
		$model->longitude			= addslashes($_POST['info']['longitude']);

		$model->room_no				= addslashes($_POST['info']['roomNo']);
		$model->new_room_no			= addslashes($_POST['info']['newRoomNo']);

		$model->gk_display			= addslashes($_POST['info']['gkDisplay']);

		$model->gk_category			= addslashes($_POST['info']['category']);
		$model->gk_fontsize			= addslashes($_POST['info']['fontSize']);
		$model->gk_partialpath		= addslashes($_POST['info']['partialPath']);
		$model->gk_showoncreation	= addslashes($_POST['info']['showOnCreation']);
		$model->gk_showtooltip		= addslashes($_POST['info']['showToolTip']);
		$model->gk_tooltiptitle		= addslashes($_POST['info']['tooltipTitle']);
		$model->gk_tooltipbody		= addslashes($_POST['info']['tooltipBody']);
		$model->gk_type				= addslashes($_POST['info']['type']);

		$model->gk_bldg_id		= addslashes($_POST['info']['buildingId']);
		$model->gk_floor_id		= addslashes($_POST['info']['floorId']);

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

		$posts = json_encode($_REQUEST, true);

		/* TODO remove this when going live */
    	header("Access-Control-Allow-Origin: *");

		$sql = " select * from facilities ";

		if ($_GET['recordId'] != '') {

			$recordId = addslashes($_GET['recordId']);
			$sql .= " where id = '$recordId' ";

		} else {

			$sql .= " where department not in ('INACTIVE','UNUSABLE')
				and department not like '%inactive%'
				and major_category not like '%inactive%'
				and functional_category not like '%inactive%'
				and gk_display != 'N'
				and gk_bldg_id != ''
				and gk_floor_id != ''
				and room_name != ''
				and room_name not like '%inactive%'
				and room_name not like '%storage%'
				";

			if ($_GET['floor'] != '') {
				$sql .= " and gk_floor_id = '".addslashes($_GET['floor'])."' ";
			}

			if ($_GET['select'] == 'floor') {
				$sql .= " and gk_display = 'Y' ";
			}

			if ($_GET['building'] != '') {
				$bldg = addslashes($_GET['building']);
				$sql .= " AND bldg_abbre = '$bldg' ";
			}

			if ($_GET['bldg'] != '') {
				$bldg = addslashes($_GET['bldg']);
				$sql .= " AND (gk_bldg_id = '$bldg' or bldg_abbre = '$bldg') ";
			}

			if ($_GET['webapp']=='display') {
				$sql .= " AND gk_display != 'N' ";
			}

			if ($_GET['webapp']!='manage') {
				$sql .= " AND gk_display != 'N' ";
			}

			$sql .= " group by bldg_abbre, floor, room_no, gk_department, department, room_name, gk_sculpture_name ";
			//$sql .= " group by bldg_abbre, floor, gk_department, department, room_name, gk_sculpture_name ";
			//$sql .= " group by bldg_abbre, floor, room_name ";
			$sql .= " order by bldg_abbre asc, room_name asc, floor asc, new_room_no asc, department asc ";

			if ($_GET['limit'] > '0') {
				$limit = addslashes($_GET['limit']);
				$sql .= " limit $limit ";
			}

		}

		//echo $sql;
		//die();

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
					$value[$key2] = str_replace("'", '', $value2);
					$value2 = mb_convert_encoding($value2, 'UTF-8', 'UTF-8');
					$value[$key2] = str_replace("\\\\", "\\", $value[$key2]);
				}

				//$value['floor'] = preg_replace('/[^0-9,.]/', '', trim($value['floor']));

				if (trim($value['floor']) == '') {
					$value['floor'] = '1st';
				}

				if (trim($value['bldg_name']) == 'HIGGINS') {
					$value['bldg_name'] = 'Higgins Hall';
				}

				$value['bldg_name']	= ucwords(strtolower(trim($value['bldg_name'])));
				$value['room_name']	= ucwords(strtolower(trim($value['room_name'])));
				$value['floor']		= strtolower(trim($value['floor']));

				$out['features'][$i]['type'] = 'Feature';

				$out['features'][$i]['properties']['buildingId']		= trim($value['gk_bldg_id']);
				$out['features'][$i]['properties']['floorId']			= trim($value['gk_floor_id']);
				$out['features'][$i]['properties']['LEVEL_ID']			= trim($value['gk_floor_id']);
				//$out['features'][$i]['properties']['floorId']			= '0001';

				if (trim($value['bldg_abbre']) == 'SG') {
					$out['features'][$i]['properties']['buildingId']	= '0001';
					$out['features'][$i]['properties']['LEVEL_ID']		= '0001';
					$out['features'][$i]['properties']['floorId']		= '0001';
					//unset($out['features'][$i]['properties']['buildingId']);
					//unset($out['features'][$i]['properties']['floorId']);
				}

				$out['features'][$i]['properties']['label']				= trim($value['room_name']);

//				$out['features'][$i]['properties']['category']			= trim($value['gk_category'])=='' ? 'Label' : trim($value['gk_category']);
				$out['features'][$i]['properties']['category']			= 'Information';

				$out['features'][$i]['properties']['fontSize']			= trim($value['gk_fontsize'])<'2' ? intval(24) : intval(trim($value['gk_fontsize']));
				//$out['features'][$i]['properties']['showOnCreation']	= trim($value['gk_showoncreation'])=='' ? true : trim($value['gk_showoncreation']);
				$out['features'][$i]['properties']['showOnCreation']	= false;
				$out['features'][$i]['properties']['showToolTip']		= trim($value['gk_showtooltip'])=='' ? true : trim($value['gk_showtooltip']);
				$out['features'][$i]['properties']['tooltipTitle']		= trim($value['gk_tooltiptitle'])=='' ? 'tt title' : trim($value['gk_tooltiptitle']);
				$out['features'][$i]['properties']['tooltipBody']		= trim($value['gk_tooltipbody'])=='' ? 'tt body' : trim($value['gk_tooltipbody']);

				$out['features'][$i]['properties']['location']			= 'URL';

				//$out['features'][$i]['properties']['type']			= trim($value['gk_type'])=='' ? 'IconWithText' : trim($value['gk_type']);
				$out['features'][$i]['properties']['type']				= 'IconWithText';
				//$out['features'][$i]['properties']['type']			= 'Icon';

				//$host = addslashes($_GET['host']).'/';

				$out['features'][$i]['properties']['partialPath']		= 'css/icons/ic_admin_info_v2.png';

				if (trim($value['room_name']) == 'Sculpture') {
					//$out['features'][$i]['properties']['partialPath'] = 'css/icons/ic_admin_camera.png';
					$out['features'][$i]['properties']['partialPath'] = 'css/icons/ic_artwork.png';
				}

				if (trim($value['space_type']) == '7701') {
					//$value['room_name'] = 'Restroom';
					$out['features'][$i]['properties']['partialPath'] = 'css/icons/ic_admin_restroom_all.png';
				}

				$out['features'][$i]['geometry']['type']				= 'Point';

				if (trim($value['latitude']) != '') {
					$value['latitude'] = floatval(substr(trim($value['latitude']),0,9) . rand(10000, 99999));
				} else {
					$value['latitude'] = floatval('-73.96' . rand(1000, 9999));
				}

				if (trim($value['longitude']) != '') {
					$value['longitude'] = floatval(substr(trim($value['longitude']),0,9) . rand(10000, 99999));
				} else {
					$value['longitude'] = floatval('40.69' . rand(1000, 9999));
				}

				$out['features'][$i]['geometry']['coordinates'][0]		= trim($value['longitude'])=='' ? '-73.964854' : trim($value['longitude']);
				$out['features'][$i]['geometry']['coordinates'][1]		= trim($value['latitude'])=='' ? '40.690357' : trim($value['latitude']);

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
				$out['features'][$i]['user_properties']['floorNo']			= trim($value['floor']);
				$out['features'][$i]['user_properties']['roomNo']			= trim($value['room_no'])==''?'1':trim($value['room_no']);
				$out['features'][$i]['user_properties']['newRoomNo']		= trim($value['new_room_no']);
				$out['features'][$i]['user_properties']['gkDisplay']		= trim($value['gk_display']);

				if (trim($value['gk_department']) != '') {
					$out['features'][$i]['user_properties']['gkDepartment']		= trim($value['gk_department']);
					//$out['features'][$i]['properties']['label']					= trim($value['gk_department']);
				}

				if (trim($value['gk_sculpture_name']) != '') {
					$out['features'][$i]['user_properties']['gkArtist']			= trim($value['gk_sculpture_artist']);
					$out['features'][$i]['user_properties']['gkArtName']		= trim($value['gk_sculpture_name']);
					$out['features'][$i]['user_properties']['gkArtDate']		= trim($value['gk_sculpture_date']);
				}

				//$out['features'][$i]['user_properties']['count']			= $i . ' ' . $rowCount;
				$out['features'][$i]['user_properties']['itemId']			= $i;
				//$out['features'][$i]['user_properties']['sql']			= $this->trim_all($sql);

				//$out['features'][$i]['user_properties']['params']	= $posts;

				$i++;
				if ($i > 10) {
				//	break;
				}

			}

				$out['features'][$i]['type'] = 'Feature';

				$out['features'][$i]['properties']['POINT_ID']		= $i;
				$out['features'][$i]['properties']['CATEGORY']		= $i;
				$out['features'][$i]['properties']['floorId']		= '0001';
				$out['features'][$i]['properties']['buildingId']	= '0001';
				$out['features'][$i]['properties']['label']			= $i;
				$out['features'][$i]['properties']['type']			= 'Icon';

				$out['features'][$i]['geometry']['type']				= 'Point';
				$out['features'][$i]['geometry']['coordinates'][0]		= '-73.964854';
				$out['features'][$i]['geometry']['coordinates'][1]		= '40.690357';

				$out['features'][$i]['user_properties']['itemId']	= $i;

		} else {
			$out['success'] = false;
			$out['message'] = 'no matches';
			$out['sql'] = $this->trim_all($sql);
		}

		header('Content-Type: application/json');
		echo json_encode($out);
		die();
    }

    private function trim_all( $str , $what = NULL , $with = ' ' ) {
		if( $what === NULL ) {
			//  Character      Decimal      Use
			//  "\0"            0           Null Character
			//  "\t"            9           Tab
			//  "\n"           10           New line
			//  "\x0B"         11           Vertical Tab
			//  "\r"           13           New Line in Mac
			//  " "            32           Space

			$what   = "\\x00-\\x20";    //all white-spaces and control chars
		}

		return trim( preg_replace( "/[".$what."]+/" , $with , $str ) , $what );
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

    	die();

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
