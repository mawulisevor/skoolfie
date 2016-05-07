<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "gradebook".
 *
 * @property string $Name
 * @property string $Index_No
 * @property string $Year
 * @property integer $Ac_Level
 * @property integer $Semester
 * @property string $Course_Code
 * @property string $Course_Title
 * @property integer $CA
 * @property integer $Exam
 * @property integer $Total
 * @property integer $CR
 * @property string $GR
 * @property double $GP
 */
class Gradebook extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'gradebook';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['Index_No', 'Ac_Level', 'Semester', 'Course_Code', 'Course_Title', 'CR'], 'required'],
            [['Ac_Level', 'Semester', 'CA', 'Exam', 'Total', 'CR'], 'integer'],
            [['GP'], 'number'],
            [['Name'], 'string', 'max' => 242],
            [['Index_No', 'Year'], 'string', 'max' => 20],
            [['Course_Code'], 'string', 'max' => 10],
            [['Course_Title'], 'string', 'max' => 100],
            [['GR'], 'string', 'max' => 2]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'Name' => 'Name',
            'Index_No' => 'Index  No',
            'Year' => 'Year',
            'Ac_Level' => 'Ac  Level',
            'Semester' => 'Semester',
            'Course_Code' => 'Course  Code',
            'Course_Title' => 'Course  Title',
            'CA' => 'Ca',
            'Exam' => 'Exam',
            'Total' => 'Total',
            'CR' => 'Cr',
            'GR' => 'Gr',
            'GP' => 'Gp',
        ];
    }

    /**
     * @inheritdoc
     * @return GradebookQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new GradebookQuery(get_called_class());
    }
}
