<?php
namespace common\models;

use Yii;
use yii\base\Model;

/**
 * Login form
 */
use common\models\LoginForm;
   
class PasswordForm extends Model{
    public $oldpass;
    public $newpass;
    public $repeatnewpass;
    private $_user;
   
    public function rules(){
        return [
            [['oldpass','newpass','repeatnewpass'],'required'],
            ['oldpass','findPasswords'],
            ['repeatnewpass','compare','compareAttribute'=>'newpass'],
        ];
    }
   
    public function findPasswords($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = User::findByUsername(Yii::$app->user->identity->username);
            if (!$user->validatePassword($this->oldpass)) {
                $this->addError($attribute, 'Old password is incorrect.');
            }
        }
    }
  
    public function attributeLabels(){
        return [
            'oldpass'=>'Old Password',
            'newpass'=>'New Password',
            'repeatnewpass'=>'Repeat New Password',
        ];
    }
}