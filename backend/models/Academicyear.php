<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "academicyear".
 *
 * @property string $acyear
 * @property string $description
 * @property string $startdate
 * @property string $EndDate
 *
 * @property Enroll[] $enrolls
 */
class Academicyear extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'academicyear';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['acyear'], 'required'],
            [['startdate', 'enddate'], 'safe'],
            [['acyear'], 'string', 'max' => 20],
            [['description'], 'string', 'max' => 100]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'acyear' => 'Academic Year',
            'description' => 'Description',
            'startdate' => 'Start Date',
            'enddate' => 'End Date',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEnrolls()
    {
        return $this->hasMany(Enroll::className(), ['acyear' => 'acyear']);
    }

    /**
     * @inheritdoc
     * @return AcademicyearQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new AcademicyearQuery(get_called_class());
    }
}
