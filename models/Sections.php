<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "provost.sections".
 *
 * @property string $crn
 * @property string $semester
 * @property string $school
 * @property string $subject
 * @property string $coursenum
 * @property string $section
 * @property string $title
 * @property string $instructor_last
 * @property string $time
 * @property int $credits_min
 * @property int $credits_max
 * @property string $room
 * @property string $crosslist
 * @property string $status
 */
class Sections extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'provost.sections';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['crn'], 'required'],
            [['credits_min', 'credits_max'], 'integer'],
            [['crn', 'semester', 'subject', 'coursenum'], 'string', 'max' => 6],
            [['school'], 'string', 'max' => 4],
            [['section'], 'string', 'max' => 3],
            [['title', 'instructor_last'], 'string', 'max' => 40],
            [['time'], 'string', 'max' => 150],
            [['room'], 'string', 'max' => 60],
            [['crosslist'], 'string', 'max' => 80],
            [['status'], 'string', 'max' => 2],
            [['crn'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'crn' => 'Crn',
            'semester' => 'Semester',
            'school' => 'School',
            'subject' => 'Subject',
            'coursenum' => 'Coursenum',
            'section' => 'Section',
            'title' => 'Title',
            'instructor_last' => 'Instructor Last',
            'time' => 'Time',
            'credits_min' => 'Credits Min',
            'credits_max' => 'Credits Max',
            'room' => 'Room',
            'crosslist' => 'Crosslist',
            'status' => 'Status',
        ];
    }
}
