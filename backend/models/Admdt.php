<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "admdt".
 *
 * @property string $INDEX_NO
 * @property string $NAME
 * @property string $ENTRANCE_CERT
 * @property string $AWARDING_INSTITUTION
 * @property string $CERTIFICATE_NO
 * @property string $QUALIFICATION_INDEX_NO
 * @property string $CLASS
 * @property string $ENGLISH_LANGUAGE
 * @property string $MATHEMATICS
 * @property string $INTEGRATED_SCIENCE
 * @property string $SOCIAL_STUDIES
 * @property string $PHYSICS
 * @property string $CHEMISTRY
 * @property string $BIOLOGY
 * @property string $ELECTIVE_MATHEMATICS
 * @property string $GENERAL_AGRICULTURE
 * @property string $CROP_HUSBANDRY
 * @property string $ANIMAL_HUSBANDRY
 *
 * @property Student $iNDEXNO
 */
class Admdt extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public $file;
    public static function tableName()
    {
        return 'admdt';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['INDEX_NO', 'NAME'], 'required'],
            [['INDEX_NO'], 'string', 'max' => 20],
            [['NAME'], 'string', 'max' => 200],
            [['ENTRANCE_CERT'], 'string', 'max' => 45],
            [['AWARDING_INSTITUTION', 'CERTIFICATE_NO', 'QUALIFICATION_INDEX_NO', 'CLASS'], 'string', 'max' => 100],
            [['ENGLISH_LANGUAGE', 'MATHEMATICS', 'INTEGRATED_SCIENCE', 'SOCIAL_STUDIES', 'PHYSICS', 'CHEMISTRY', 'BIOLOGY', 'ELECTIVE_MATHEMATICS', 'GENERAL_AGRICULTURE', 'CROP_HUSBANDRY', 'ANIMAL_HUSBANDRY'], 'string', 'max' => 10],
            [['file'], 'file','skipOnEmpty'=>true,'extensions'=>'csv','mimeTypes'=>'text/comma-separated-values, text/csv, text/plain,application/csv,application/excel,application/vnd.ms-excel, application/vnd.msexcel, text/anytext, application/octet-stream,application/txt',],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'INDEX_NO' => 'INDEX NO',
            'NAME' => 'NAME',
            'ENTRANCE_CERT' => 'ENTRANCE CERT',
            'AWARDING_INSTITUTION' => 'AWARDING INSTITUTION',
            'CERTIFICATE_NO' => 'CERTIFICATE NO',
            'QUALIFICATION_INDEX_NO' => 'QUALIFICATION INDEX NO',
            'CLASS' => 'CLASS',
            'ENGLISH_LANGUAGE' => 'ENGLISH LANGUAGE',
            'MATHEMATICS' => 'MATHEMATICS',
            'INTEGRATED_SCIENCE' => 'INTEGRATED SCIENCE',
            'SOCIAL_STUDIES' => 'SOCIAL STUDIES',
            'PHYSICS' => 'PHYSICS',
            'CHEMISTRY' => 'CHEMISTRY',
            'BIOLOGY' => 'BIOLOGY',
            'ELECTIVE_MATHEMATICS' => 'ELECTIVE MATHEMATICS',
            'GENERAL_AGRICULTURE' => 'GENERAL AGRICULTURE',
            'CROP_HUSBANDRY' => 'CROP HUSBANDRY',
            'ANIMAL_HUSBANDRY' => 'ANIMAL HUSBANDRY',
            'file' => 'Upload Admission Results CSV File',            
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getINDEXNO()
    {
        return $this->hasOne(Student::className(), ['studid' => 'INDEX_NO']);
    }

    /**
     * @inheritdoc
     * @return AdmdtQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new AdmdtQuery(get_called_class());
    }
}
