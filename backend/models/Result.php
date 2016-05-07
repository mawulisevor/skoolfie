<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "result".
 *
 * @property string $Name
 * @property string $Index_No
 * @property string $Title
 * @property string $Courseid
 * @property integer $CA
 * @property integer $Exam
 * @property integer $Total
 * @property integer $CR
 * @property string $GR
 * @property double $GP
 * @property integer $Level
 * @property integer $Year
 * @property integer $Semester
 */
class Result extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'result';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            /*[['Index_No', 'Ac_Level', 'Semester', 'Course_Code', 'Course_Title', 'CR'], 'required'],
            [['Ac_Level', 'Semester', 'CA', 'Exam', 'Total', 'CR'], 'integer'],
            [['GP'], 'number'],
            [['Name'], 'string', 'max' => 242],
            [['Index_No'], 'string', 'max' => 20],
            [['Course_Code'], 'string', 'max' => 10],
            [['Course_Title'], 'string', 'max' => 100],
            [['GR'], 'string', 'max' => 2] */
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'Name' => 'Name',
            'Index_No' => 'Index No',
            'Year' => 'Year',
            'Level' => 'Level',
            'Semester' => 'Semester',
            'Courseid' => 'Course Code',
            'Title' => 'Course  Title',
            'CA' => 'CA',
            'Exam' => 'Exam',
            'Total' => 'Total',
            'CR' => 'CR',
            'GR' => 'GR',
            'GP' => 'GP',
        ];
    }

    /**
     * @inheritdoc
     * @return GradebookQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ResultQuery(get_called_class());
    }
}
