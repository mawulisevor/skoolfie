<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "enroll".
 *
 * @property string $studid
 * @property string $courseid
 * @property integer $ca
 * @property integer $exams
 * @property string $acyear
 * @property integer $classroom
 * @property integer $resit
 * @property Academicyear $acyear
 * @property Course $course
 * @property Student $stud
 */
class Enroll extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public $file;
    public static function tableName()
    {
        return 'enroll';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['studid', 'courseid', 'classroom'], 'required'],
            [['ca', 'exams', 'classroom','resit'], 'integer'],
            [['studid', 'acyear'], 'string', 'max' => 20],
            [['courseid'], 'string', 'max' => 10],
            [['file'], 'file','skipOnEmpty'=>true,'extensions'=>'csv','mimeTypes'=>'text/comma-separated-values',],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'studid' => 'Student ID',
            'courseid' => 'Course ID',
            'ca' => 'CA',
            'resit' =>'Resit',
            'exams' => 'Exams',
            'acyear' => 'Academic Year',
            'classroom' => 'Classroom',
            'file' => 'Upload Course/Subject Results CSV File',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAcyear0()
    {
        return $this->hasOne(Academicyear::className(), ['acyear' => 'acyear']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCourse()
    {
        return $this->hasOne(Course::className(), ['courseid' => 'courseid']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStud()
    {
        return $this->hasOne(Student::className(), ['studid' => 'studid']);
    }

    /**
     * @inheritdoc
     * @return EnrollQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new EnrollQuery(get_called_class());
    }
}
