<?php

namespace backend\models;

use Yii;
use yii\UploadedFile;

/**
 * This is the model class for table "institution".
 *
 * @property integer $id
 * @property string $inst_shortname
 * @property string $inst_name
 * @property string $inst_location
 * @property string $inst_post_address
 * @property string $inst_email
 * @property string $inst_est_date
 * @property string $logo
 */
class Institution extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public $imageFile;
    public $file;
    public static function tableName()
    {
        return 'institution';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['inst_shortname', 'inst_name', 'inst_location', 'inst_post_address', 'inst_email', 'inst_est_date'], 'required'],
            [['inst_est_date'], 'safe'],
            [['inst_shortname'], 'string', 'max' => 10],
            [['inst_name', 'inst_location'], 'string', 'max' => 250],
            [['inst_post_address', 'inst_email', 'logo'], 'string', 'max' => 100],
            [['imageFile'], 'file','skipOnEmpty'=>true,'extensions'=>'png,jpg,jpeg','mimeTypes'=> 'image/jpeg, image/png',],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'inst_shortname' => 'Institution Short Name',
            'inst_name' => 'Institution Name',
            'inst_location' => 'Location',
            'inst_post_address' => 'Postal Address',
            'inst_email' => 'Email',
            'inst_est_date' => 'Date Established',
            'logo' => 'Logo',
            'imageFile' => 'Institution Logo',
        ];
    }

    /**
     * @inheritdoc
     * @return InstitutionQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new InstitutionQuery(get_called_class());
    }
}
