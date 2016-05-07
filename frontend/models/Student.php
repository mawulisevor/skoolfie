<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "student".
 *
 * @property string $studid
 * @property string $lname
 * @property string $mname
 * @property string $oname
 * @property string $progid
 * @property integer $currentlevel
 * @property integer $admissionlevel
 * @property string $sex
 * @property string $phone
 * @property string $email
 * @property string $pobox
 * @property string $admdate
 * @property string $birthdate
 * @property string $gradgroup
 * @property integer $semsdone
 * @property double $totalgp
 * @property integer $totalcredit
 * @property double $cgpa
 * @property string $certclass
 * @property string $picture
 *
 * @property Admdt $admdt
 * @property Admresult[] $admresults
 * @property Enroll[] $enrolls
 * @property Acprog $prog
 */
class Student extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'student';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['studid', 'lname', 'currentlevel', 'admissionlevel', 'sex', 'admdate', 'gradgroup'], 'required'],
            [['currentlevel', 'admissionlevel', 'semsdone', 'totalcredit'], 'integer'],
            [['admdate', 'birthdate'], 'safe'],
            [['totalgp', 'cgpa'], 'number'],
            [['studid'], 'string', 'max' => 20],
            [['lname', 'mname'], 'string', 'max' => 70],
            [['oname', 'picture'], 'string', 'max' => 100],
            [['progid', 'phone', 'gradgroup'], 'string', 'max' => 15],
            [['sex'], 'string', 'max' => 1],
            [['email'], 'string', 'max' => 255],
            [['pobox'], 'string', 'max' => 300],
            [['certclass'], 'string', 'max' => 45],
            [['studid'], 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'studid' => 'Index No',
            'lname' => 'Lastname / Surname',
            'mname' => 'Middle Name',
            'oname' => 'First Name',
            'progid' => 'Program Code',
            'currentlevel' => 'Current Level',
            'admissionlevel' => 'Admitted to Level',
            'sex' => 'Sex',
            'phone' => 'Phone',
            'email' => 'Email',
            'pobox' => 'P.O. Box',
            'admdate' => 'Admission Date',
            'birthdate' => 'Birthdate',
            'gradgroup' => 'Graduation Group',
            'semsdone' => 'Semesters Done',
            'totalgp' => 'Total GP',
            'totalcredit' => 'Total Credit',
            'cgpa' => 'CGPA',
            'certclass' => 'Graduation Class',
            'picture' => 'Picture',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAdmdt()
    {
        return $this->hasOne(Admdt::className(), ['INDEX_NO' => 'studid']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAdmresults()
    {
        return $this->hasMany(Admresult::className(), ['studid' => 'studid']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEnrolls()
    {
        return $this->hasMany(Enroll::className(), ['studid' => 'studid']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProg()
    {
        return $this->hasOne(Acprog::className(), ['progid' => 'progid']);
    }

    /**
     * @inheritdoc
     * @return StudentQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new StudentQuery(get_called_class());
    }
}
