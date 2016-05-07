<?php

namespace frontend\controllers;

use Yii;
use frontend\models\Student;
use frontend\models\StudentSearch;
use frontend\models\User;
use frontend\models\UserSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * StudentController implements the CRUD actions for Student model.
 */
class StudentController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Displays a single Student model.
     * @param string $id
     * @return mixed
     */
    public function actionIndex()
    {
        if(Yii::$app->user->identity)
        { 
            $studid = Yii::$app->user->identity->username;
            if(Student::findOne($studid) !== null)
            {
                return $this->render('index', [
                    'model' => $this->findModel($studid),
                ]);
            }else
            {
                throw new NotFoundHttpException('The requested page does not exist.');
            }
        }else
        {
            throw new NotFoundHttpException('The requested page does not exist.');
        }

    }

    /**
     * Updates an existing Student model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate()
    {
        if(Yii::$app->user->identity)
        { 
            $studid = Yii::$app->user->identity->username;
            if(Student::findOne($studid) !== null)
            {
                $model = $this->findModel($studid);
                if ($model->load(Yii::$app->request->post()) && $model->save()) {
                    return $this->redirect(['index']);
                    // return $this->redirect(['view', 'id' => $model->studid]);
                } else {
                    return $this->render('update', [
                        'model' => $model,
                    ]);
                }
            }else
            {
                throw new NotFoundHttpException('The requested page does not exist.');
            }
        }else
        {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /**
     * Updates an existing User model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUp()
    {
        if(Yii::$app->user->identity)
        { 
            $username = Yii::$app->user->identity->id;
            if(User::findOne($username) !== null)
            {
                $model = $this->findUser($username);
                if ($model->load(Yii::$app->request->post()) && $model->save()) {
                    return $this->redirect(['index']);
                } else {
                    return $this->render('up', [
                        'model' => $model,
                    ]);
                }
            }else
            {
                throw new NotFoundHttpException('The requested page does not exist.');
            }
        }else
        {
            throw new NotFoundHttpException('The requested page does not exist.');
        }

    }

    /**
     * Finds the Student model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Student the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findUser($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /**
     * Finds the Student model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Student the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Student::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
