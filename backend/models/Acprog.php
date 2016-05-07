<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "acprog".
 *
 * @property string $progid
 * @property string $progname
 * @property string $awardedby
 *
 * @property Student[] $students
 */
class Acprog extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'acprog';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['progid', 'progname', 'awardedby'], 'required'],
            [['progid'], 'string', 'max' => 15],
            [['progname', 'awardedby'], 'string', 'max' => 100]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'progid' => 'Program ID',
            'progname' => 'Program Name',
            'awardedby' => 'Awarded By',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStudents()
    {
        return $this->hasMany(Student::className(), ['progid' => 'progid']);
    }

    /**
     * @inheritdoc
     * @return AcprogQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new AcprogQuery(get_called_class());
    }
}
