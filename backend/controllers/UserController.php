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
 * UserController implements the CRUD actions for User model.
 */
class UserController extends Controller
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
     * Lists all User models.
     * @return mixed
     */
    public function actionIndex()
    {
        if(Yii::$app->user->can('site-admin'))
        {
            $searchModel = new UserSearch();
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

            return $this->render('index', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
            ]);
        }else
        {
            $this->redirect(\Yii::$app->urlManager->createURL("site/index"));
        }  
        
    }

    /**
     * Displays a single User model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        if(Yii::$app->user->can('site-admin'))
        {
            return $this->render('view', [
                'model' => $this->findModel($id),
            ]);
        }else
        {
            $this->redirect(\Yii::$app->urlManager->createURL("site/index"));
        }
    }


    /**
     * Creates new admin user.
     *
     * @return mixed
     */
    public function actionCreate()
    {
        if(Yii::$app->user->can('site-admin'))
        {
            $model = new AdminUser();
            if ($model->load(Yii::$app->request->post())) {
                // if ($user = $model->newadmin()) {
                if ($model->newadmin()) {
                        $this->redirect(\Yii::$app->urlManager->createURL("user/index"));
                }
            }
            return $this->render('new-admin', [
                'model' => $model,
            ]);
        }
    }


    /**
     * Updates an existing User model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
         if(Yii::$app->user->can('site-admin'))
        {
            $model = $this->findModel($id);
            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                return $this->render('update', [
                    'model' => $model,
                ]);
            }
        }else
        {
            $this->redirect(\Yii::$app->urlManager->createURL("site/index"));
        }
    }

    /**
     * Deletes an existing User model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
         if(Yii::$app->user->can('site-admin'))
        {
            $this->findModel($id)->delete();
            return $this->redirect(['index']);
        }else
        {
            $this->redirect(\Yii::$app->urlManager->createURL("site/index"));
        }
    }

        /**
     * Displays distinct graduation groups from User model if you are a site-admin
     * @return mixed
     */
    
    public function actionUsergp()
    {
        if(Yii::$app->user->can('site-admin'))
        {
            $searchModel = new UserSearch();
            $dataProvider = $searchModel->ugroupsearch(Yii::$app->request->queryParams);

            return $this->render('usergp', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
            ]);
        }else 
        {
            $this->redirect(\Yii::$app->urlManager->createURL("site/index"));
        }   
    }

    public function actionRmv($id)
    {
        if(Yii::$app->user->can('site-admin'))
        {
                $deleteGroup = Yii::$app -> db -> createCommand(
                    'DELETE FROM `user` WHERE `ugroup`=:id')
                    ->bindValue(':id', $id)
                    ->execute();
                return $this->redirect(['index']);
        }else 
        {
            throw new ForbiddenHttpException("No records found");
        }
    }

    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
