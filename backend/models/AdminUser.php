<?php
namespace backend\models;

use common\models\User;
use yii\base\Model;
use Yii;

/**
 * Signup form
 */
class AdminUser extends Model
{
    public $username;
    public $fname;
    public $lname;
    public $birthdate;
    public $email;
    public $status;
    public $role;
    public $ugroup;
    public $password;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['username', 'filter', 'filter' => 'trim'],
            ['username', 'required'],
            ['fname', 'required'],
            ['lname', 'required'],
            ['birthdate', 'required'],
            ['ugroup', 'required'],
            ['username', 'unique', 'targetClass' => '\common\models\User', 'message' => 'This username is already registered.'],
            ['username', 'string', 'min' => 2, 'max' => 20],
            [['role', 'status',], 'integer'],
            ['email', 'filter', 'filter' => 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => '\common\models\User', 'message' => 'This email address is already registered.'],
            ['password', 'required'],
            ['password', 'string', 'min' => 6],
        ];
    }

    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function newadmin()
    {
        if ($this->validate())
        {
            $user = new User();
            $user->username = $this->username;
            $user->email = $this->email;
            $user->fname = $this->fname;
            $user->lname = $this->lname;
            $user->birthdate = $this->birthdate;
            $user->ugroup = $this->ugroup;
            $user->status = $this->status;
            $user->role = $this->role;
            $user->setPassword($this->password);
            $user->generateAuthKey();
            if ($user->save()) {
                // return $user;
                return true;
            }
        }
        return null;
    }
}
