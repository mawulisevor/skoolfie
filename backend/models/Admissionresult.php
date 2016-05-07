<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "admissionresult".
 *
 * @property integer $id
 * @property string $studid
 * @property string $cert
 * @property string $institution
 * @property string $certno
 * @property string $indexno
 * @property string $certclass
 * @property string $subject
 * @property string $grade
 *
 * @property Student $stud
 */
class Admissionresult extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public $file;
    public static function tableName()
    {
        return 'admissionresult';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['studid', 'cert', 'institution', 'subject', 'grade'], 'required'],
            [['studid'], 'string', 'max' => 20],
            [['cert'], 'string', 'max' => 45],
            [['institution', 'certno', 'indexno', 'certclass', 'subject'], 'string', 'max' => 100],
            [['grade'], 'string', 'max' => 10],
            [['file'], 'file','skipOnEmpty'=>true,'extensions'=>'csv','mimeTypes'=>'text/comma-separated-values, text/csv, text/plain,application/csv,application/excel,application/vnd.ms-excel, application/vnd.msexcel, text/anytext, application/octet-stream,application/txt',],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'studid' => 'Student ID',
            'cert' => 'Cert',
            'institution' => 'Awarding Institution',
            'certno' => 'Cert No.',
            'indexno' => 'Indexno',
            'certclass' => 'Class Awarded',
            'subject' => 'Subject',
            'grade' => 'Grade',
            'file' => 'Upload Admission Results CSV File',
        ];
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
     * @return AdmissionresultQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new AdmissionresultQuery(get_called_class());
    }
}
