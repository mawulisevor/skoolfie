<?php
namespace backend\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use common\models\LoginForm;
use common\models\PasswordForm;
use common\models\User;
use yii\filters\VerbFilter;
use yii\web\ForbiddenHttpException;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
    // public $layout = 'index';
    public function behaviors()
    {
        return [
            'access'=>[
                'class'=>AccessControl::className(), 'only'=>['index','login'],
                'rules'=>[
                    [
                        'actions'=>['login','index'],
                        'allow'=>true,
                    ],
                    [
                        'actions'=>['logout'],
                        'allow'=>true,
                        'roles'=>['@'],
                        'matchCallback'=> function($rule,$action){
                            //return Yii::$app->user->identity->isAdmin;
                            User::isAdmin(Yii::$app->user->identity->username);
                        }
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionLogin()
    {
        if (!\Yii::$app->user->isGuest) {
            //return $this->goHome();
            $this->redirect(\Yii::$app->urlManager->createURL("student/index"));
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->loginAdmin()) {
            //return $this->goBack();
            $this->redirect(\Yii::$app->urlManager->createURL("student/index"));
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    } 

    /**
     * Changes password.
     */
    public function actionChangePassword(){
        if(Yii::$app->user->identity)
        {
            $model = new PasswordForm();
            if($model->load(Yii::$app->request->post())){
                if($model->validate()){
                    try{
                        $modeluser = User::find()->where([
                            'username'=>Yii::$app->user->identity->username
                        ])->one();
                       $modeluser->password_hash = Yii::$app->security->generatePasswordHash($_POST['PasswordForm']['newpass']);
                        $thepassword = $_POST['PasswordForm']['newpass'];
                        if($modeluser->save()){
                            Yii::$app->getSession()->setFlash(
                                'success','Password changed'
                            );
                            //return $this->redirect(['index']);
                            $this->redirect(\Yii::$app->urlManager->createURL("gradebook/index"));
                        }else{
                            Yii::$app->getSession()->setFlash(
                                'error','Password not changed: '.$thepassword
                            );
                            return $this->redirect(['index']);
                        }
                    }catch(Exception $e){
                        Yii::$app->getSession()->setFlash(
                            'error',"{$e->getMessage()}"
                        );
                        return $this->render('changepassword',[
                            'model'=>$model
                        ]);
                    }
                }else{
                    return $this->render('changepassword',[
                        'model'=>$model
                    ]);
                }
            }else{
                return $this->render('changepassword',[
                    'model'=>$model
                ]);
            }
        }
    } 
   }
