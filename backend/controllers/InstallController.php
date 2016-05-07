<?php

namespace backend\controllers;

use Yii;
use backend\models\User;
use backend\models\AdminUser;
use backend\models\UserSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * InstallController implements the CRUD actions for User model.
 */
class InstallController extends Controller
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
     * Creates new admin user.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        {
            $model = new AdminUser();
            if ($model->load(Yii::$app->request->post())) {
                if ($model->newadmin()) {
                        $this->redirect(\Yii::$app->urlManager->createURL("student/index"));
                }
            }
            return $this->render('new-admin', [
                'model' => $model,
            ]);
        }
    }

}
