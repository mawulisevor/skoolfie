<?php
namespace frontend\models;

use common\models\User;
use frontend\models\Student;
use yii\base\Model;
use Yii;

/**
 * Signup form
 */
class SignupForm extends Model
{
    public $username;
    public $fname;
    public $lname;
    public $birthdate;
    public $email;
    public $phone;
    public $pobox;
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

            ['email', 'filter', 'filter' => 'trim'],
            ['email', 'required'],
            ['phone', 'required'],
            ['pobox', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['pobox', 'string', 'max' => 300],
            ['phone', 'string', 'max' => 15],
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
    public function signup()
    {
        if ($this->validate() && Student::findOne($this->username) !== null)
        {
            $student = Student::findOne($this->username);
            if (strtolower($student->email) === strtolower($this->email) &&
                    strtolower($student->fname) === strtolower($this->fname) &&
                    strtolower($student->lname) === strtolower($this->lname) &&
                    $student->birthdate === $this->birthdate &&
                    $student->phone === $this->phone
                )
            {
                $user = new User();
                $user->username = $this->username;
                $user->email = $this->email;
                $user->fname = $this->fname;
                $user->lname = $this->lname;
                $user->birthdate = $this->birthdate;
                $user->ugroup = $this->ugroup;
                $user->setPassword($this->password);
                $user->generateAuthKey();
                $student->pobox = $this->pobox;
                if ($user->save() && $student->save()) {
                    return $user;
                }   
            }
        }

        return null;
    }
}
