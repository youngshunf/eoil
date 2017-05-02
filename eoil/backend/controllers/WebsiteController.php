<?php

namespace backend\controllers;

use Yii;
use common\models\HomePhoto;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\models\ImageUploader;
use common\models\Siteinfo;
use yii\filters\AccessControl;
use common\models\Message;

/**
 * WebsiteController implements the CRUD actions for HomePhoto model.
 */
class WebsiteController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => [],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all HomePhoto models.
     * @return mixed
     */
    public function actionIndex()
    {
       return $this->redirect(['website/siteinfo']);
    }

    /**
     * Displays a single HomePhoto model.
     * @param integer $id
     * @return mixed
     */
    public function actionViewPhoto($id)
    {
        return $this->render('view-photo', [
            'model' => $this->findModel($id),
        ]);
    }
    
    public function actionViewSiteinfo($id)
    {
        $model=Siteinfo::findOne($id);
        return $this->render('view-siteinfo', [
            'model' =>$model,
        ]);
    }

    /**
     * Creates a new HomePhoto model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreateMessage()
    {
        $model = new Message();
        $model->setScenario('create');
        if ($model->load(Yii::$app->request->post()) ) {
            $model->type=Message::AGENT;
            $model->from_user=yii::$app->user->identity->user_guid;
            $model->created_at=time();
            if($model->save())
            return $this->redirect(['message']);
        } else {
            return $this->render('create-message', [
                'model' => $model,
            ]);
        }
    }
    
    public function actionUpdateMessage($id)
    {
        $model =Message::findOne($id);
        $model->setScenario('create');
        if ($model->load(Yii::$app->request->post()) ) {
            if($model->save())
                return $this->redirect(['message']);
        } else {
            return $this->render('update-message', [
                'model' => $model,
            ]);
        }
    }
    
    public function actionDeleteMessage($id){
        Message::findOne($id)->delete();
        yii::$app->getSession()->setFlash('success','删除成功!');
        return $this->redirect(yii::$app->request->referrer);
    }
    
    public function actionCreateSiteinfo()
    {
        $model = new Siteinfo();
    
        if ($model->load(Yii::$app->request->post()) ) {
            $model->content=@$_POST['info-content'];
            $model->created_at=time();
            if($model->save())
                return $this->redirect(['view-siteinfo', 'id' => $model->id]);
        } else {
            $this->layout="@backend/views/layouts/website_layout.php";
            return $this->render('create-siteinfo', [
                'model' => $model,
            ]);
        }
    }
    
    public function actionUpdateSiteinfo($id)
    {
        $model = Siteinfo::findOne($id);
 
          if ($model->load(Yii::$app->request->post()) ) {
                $model->content=@$_POST['info-content'];
                $model->updated_at=time();
                if($model->save())
                    return $this->redirect(['view-siteinfo', 'id' => $model->id]);
            } else {
                return $this->render('update-siteinfo', [
                    'model' => $model,
                ]);
            }
        
    }
    
    

    /**
     * Updates an existing HomePhoto model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdatePhoto($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) ) {
            $photo=ImageUploader::uploadHomePhoto('photo');
            if($photo){
                $model->path=$photo['path'];
                $model->photo=$photo['photo'];
            }
            $model->desc=@$_POST['desc'];
            $model->updated_at=time();
            if($model->save())
            return $this->redirect(['view-photo', 'id' => $model->id]);
        } else {
            return $this->render('update-photo', [
                'model' => $model,
            ]);
        }
    }

 
    public function actionSiteinfo(){
        $id=2;
        $model=Siteinfo::findOne($id);
        return $this->render('view-siteinfo',['model'=>$model]);
    }
    
    public function actionContact(){
        $id=2;
       $model=Siteinfo::findOne($id);
        return $this->render('view-siteinfo',['model'=>$model]);
    }
    
    public function actionAgent(){
        $id=3;
        $model=Siteinfo::findOne($id);
        return $this->render('view-siteinfo',['model'=>$model]);
    }
   
    public function actionDeletePhoto($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }
    
    public function actionMessage(){
        $dataProvider=new ActiveDataProvider([
            'query'=>Message::find()->andWhere(['type'=>Message::AGENT])->orderBy('created_at desc')
        ]);
        
        return $this->render('message',['dataProvider'=>$dataProvider]);
    }

    /**
     * Finds the HomePhoto model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return HomePhoto the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = HomePhoto::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
