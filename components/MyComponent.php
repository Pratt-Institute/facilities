<?php

namespace app\components;

use Yii;
use yii\base\Component;
use yii\base\InvalidConfigException;

class MyComponent extends Component
{

	public function fetchBuildings($hall) {

		$arr['Information Science']			=  '0001';
		$arr['Pratt Library']				=  '0002';
		$arr['DeKalb Hall']					=  '0003';
		$arr['Higgins Hall']				=  '0004';
		$arr['North Hall']					=  '0005';
		$arr['Memorial Hall']				=  '0006'; /// ???
		$arr['Student Union']				=  '0007';
		$arr['Main Building']				=  '0008';
		$arr['East Hall']					=  '0009';
		$arr['South Hall']					=  '0010';
		$arr['Jones Hall']					=  '0011'; /// ???
		$arr['Thrift Hall']					=  '0012';
		$arr['Pantas Hall']					=  '0013'; /// ???
		$arr['Willoughby Hall']				=  '0014';
		$arr['Chemistry Building']			=  '0015';
		$arr['Machinery Building']			=  '0016';
		$arr['Engineering Building']		=  '0017';
		$arr['Design Center']				=  '0018'; /// ???
		$arr['Pratt Studios']				=  '0018'; /// ???
		$arr['Steuben Hall']				=  '0018'; /// ???
		$arr['Film Video']					=  '0019';
		$arr['Activity Resource']			=  '0021';
		$arr['Activities Resource']			=  '0021';
		$arr['Stabile Hall']				=  '0022'; /// ???
		$arr['Cannoneer Court']				=  '0023'; /// ???
		$arr['Myrtle Hall']					=  '0024';

		return $arr[$hall];

	}

	public function fetchBuildingsByCode($hall) {

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
		$arr['CANN']		=  '0023'; /// ???
		$arr['MH']		=  '0024';

		//return $arr[$this->hall];
		//return $arr[$hall];

		if (!$arr[$hall]) {
			$exp = explode(' ',$hall);
			return $exp[0];
		}

		return $arr[$hall];
	}

	public function fetchCoords($buildingId) {

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
		$arr['w18'] = '40.740609, -73.995922';						///'W18'
		$arr['0018'] = '40.690250396728516,-73.96299743652344';		///'PS'
		$arr['0010'] = '40.691054,-73.964238';						///'SH'
		$arr['0022'] = '40.69165802001953,-73.96163940429688';		///'SBL'
		$arr['0018'] = '40.690377,-73.962631';						///'STEU'
		$arr['0007'] = '40.691599,-73.963907';						///'SU'
		$arr['0012'] = '40.69010925292969,-73.96412658691406';		///'TH'
		$arr['0014'] = '40.692935943603516,-73.9635009765625';		///'WILL'
		$arr['100g'] = '40.694507, -73.964380';						///'100G'

		return $arr[$buildingId];
	}
}

?>