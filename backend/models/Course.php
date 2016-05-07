<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "course".
 *
 * @property string $courseid
 * @property string $coursename
 * @property integer $coursecredit
 * @property integer $aclevel
 * @property integer $semester
 * @property integer $deptid
 * @property string $progid
 *
 * @property Acprog $prog
 * @property Department $dept
 * @property Enroll[] $enrolls
 * @property Student[] $studs
 * @property Teach[] $teaches
 */
class Course extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public $file;
    public static function tableName()
    {
        return 'course';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['courseid', 'coursename', 'coursecredit', 'aclevel', 'semester', 'progid'], 'required'],
            [['coursecredit', 'aclevel', 'semester', 'deptid'], 'integer'],
            [['courseid'], 'string', 'max' => 10],
            [['coursename'], 'string', 'max' => 100],
            [['progid'], 'string', 'max' => 15],
            [['file'], 'file','skipOnEmpty'=>true,'extensions'=>'csv','mimeTypes'=>'text/comma-separated-values',],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'courseid' => 'Course ID',
            'coursename' => 'Course Name',
            'coursecredit' => 'Course Credit',
            'aclevel' => 'AcLevel',
            'semester' => 'Semester',
            'deptid' => 'Department ID',
            'progid' => 'Program ID',
            'file' => 'Upload Courses CSV File',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProg()
    {
        return $this->hasOne(Acprog::className(), ['progid' => 'progid']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDept()
    {
        return $this->hasOne(Department::className(), ['deptid' => 'deptid']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEnrolls()
    {
        return $this->hasMany(Enroll::className(), ['courseid' => 'courseid']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStuds()
    {
        return $this->hasMany(Student::className(), ['studid' => 'studid'])->viaTable('enroll', ['courseid' => 'courseid']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTeaches()
    {
        return $this->hasMany(Teach::className(), ['courseid' => 'courseid']);
    }

    /**
     * @inheritdoc
     * @return CourseQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new CourseQuery(get_called_class());
    }
}
