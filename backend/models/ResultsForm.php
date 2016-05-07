<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "gradebook".
 * @property string $Year
 * @property integer $Level
 * @property integer $Semester
 */
class ResultsForm extends Model
{
    public $Year;
    public $Level;
    public $Semester;
    public function rules()
    {
        return [
            [['Year', 'Level','Semester'], ’required’],
            [['Level', 'Semester'], 'number'],
    ];
    }
}