<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "facilities".
 *
 * @property int $id
 * @property string $bldg_code
 * @property string $owned_leased
 * @property string $bldg_name
 * @property string $bldg_abbre
 * @property string $floor
 * @property string $room_no
 * @property string $new_room_no
 * @property string $line
 * @property string $status
 * @property string $station_count
 * @property string $sf
 * @property string $sf_fte
 * @property string $space_type
 * @property string $room_name
 * @property string $donor_space
 * @property string $av
 * @property string $ceiling_hgt
 * @property string $department
 * @property string $space
 * @property string $time
 * @property string $proration
 * @property string $calcuated_sf
 * @property string $function_code
 * @property string $major_category
 * @property string $functional_category
 * @property string $functional_title
 * @property string $on_off_campus
 */
class Facilities extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'facilities';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            //[['bldg_code', 'owned_leased', 'bldg_name', 'bldg_abbre', 'floor', 'room_no', 'new_room_no', 'line', 'status', 'station_count', 'sf', 'sf_fte', 'space_type', 'room_name', 'donor_space', 'av', 'ceiling_hgt', 'department', 'space', 'time', 'proration', 'calcuated_sf', 'function_code', 'major_category', 'functional_category', 'functional_title', 'on_off_campus'], 'required'],

            [['bldg_code', 'owned_leased', 'bldg_name', 'bldg_abbre', 'floor', 'room_no', 'new_room_no', 'line', 'status', 'station_count', 'sf', 'sf_fte', 'space_type', 'room_name', 'donor_space', 'av', 'ceiling_hgt', 'department', 'space', 'time', 'proration', 'calcuated_sf', 'function_code', 'major_category', 'functional_category', 'functional_title', 'on_off_campus', 'latitude', 'longitude', 'accessible'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'bldg_code' => 'Bldg Code',
            'owned_leased' => 'Owned Leased',
            'bldg_name' => 'Bldg Name',
            'bldg_abbre' => 'Bldg Abbre',
            'floor' => 'Floor',
            'room_no' => 'Room No',
            'new_room_no' => 'New Room No',
            'line' => 'Line',
            'status' => 'Status',
            'station_count' => 'Station Count',
            'sf' => 'Sf',
            'sf_fte' => 'Sf Fte',
            'space_type' => 'Space Type',
            'room_name' => 'Room Name',
            'donor_space' => 'Donor Space',
            'av' => 'Av',
            'ceiling_hgt' => 'Ceiling Hgt',
            'department' => 'Department',
            'space' => 'Space',
            'time' => 'Time',
            'proration' => 'Proration',
            'calcuated_sf' => 'Calcuated Sf',
            'function_code' => 'Function Code',
            'major_category' => 'Major Category',
            'functional_category' => 'Functional Category',
            'functional_title' => 'Functional Title',
            'on_off_campus' => 'On Off Campus',
            'latitude' => 'Latitude',
            'longitude' => 'Longitude',
            'accessible' => 'Accessible',

        ];
    }
}
