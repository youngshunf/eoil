<?php

namespace api\controllers;

use Yii;
use common\models\News;
use common\models\SearchNews;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\data\ActiveDataProvider;
use common\models\NewsCate;
use common\models\User;
use common\models\UserRelation;
use yii\db\Exception;
use common\models\Order;
use common\models\GoodsCate;

/**
 * NewsController implements the CRUD actions for News model.
 */
class NewsController extends Controller
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
                        'roles' => ['?'],
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
     * 新闻资讯
     * @return mixed
     */
    public function actionIndex()
    {
        $cateid=1;
        if(isset($_GET['cateid'])){
            $cateid=$_GET['cateid'];
        }
        $cate=NewsCate::findOne($cateid);
        $model=News::find()->andWhere(['is_recommend'=>1,'cateid'=>$cateid])->orderBy('created_at desc')->limit(8)->all();
        $dataProvider = new ActiveDataProvider([
            'query'=>News::find()->andWhere(['cateid'=>1])->orderBy('created_at desc'),
            'pagination'=>[
                'pagesize'=>10
            ]
        ]);
        $this->layout="@api/views/layouts/news_layout.php";
        return $this->render('index', [
             'model'=>$model,
            'dataProvider' => $dataProvider,
            'cate'=>$cate
        ]);
    }
    
    /**
     * 新闻资讯
     * @return mixed
     */
    public function actionNews($cateid)
    {
       
        $searchModel = new SearchNews();
        $searchModel->cateid=$cateid;
        $cate=NewsCate::findOne(['cateid'=>$cateid]);
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
       $this->layout="@backend/views/layouts/news_layout.php";
        return $this->render('news', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'cate'=>$cate
        ]);
    }

    /**
     * Displays a single News model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $model=$this->findModel($id);
        $model->count_view+=1;
        $model->save();       
        $title=$model->title;
        $relativeNews=News::find()->andWhere(['cateid'=>1])->limit(10)->orderBy('created_at desc ')->all();
        $this->layout="@api/views/layouts/news_layout.php";
        return $this->render('view', [
            'model' => $model,
            'relativeNews'=>$relativeNews,  
        ]);
    }
    
    
    public function checkRelation($user_guid){
        $recUser=User::findOne(['user_guid'=>$user_guid]);
        if(!empty($recUser) && $recUser->is_agent==0){
            $parentUserRelation=UserRelation::findOne(['user_guid'=>$recUser->user_guid]);
            $recUser=null;
            if(!empty($parentUserRelation)){
                $recUser=User::findOne(['user_guid'=>$parentUserRelation->parent_user]);
            }
        }
        if(!empty($recUser) && $recUser->is_agent==1 && $user_guid !=yii::$app->user->identity->user_guid ){
            $user=User::findOne(['user_guid'=>yii::$app->user->identity->user_guid]);
            if(!empty($user)&&$user->is_agent==0){
                $order=Order::findOne(['user_guid'=>$user->user_guid,'is_pay'=>1]);
                $uRelation=UserRelation::findOne(['user_guid'=>$user->user_guid]);
                if(!empty($order)&&!empty($uRelation)){
                    return $recUser;
                }
                
                $trans=yii::$app->db->beginTransaction();
                try{
                    UserRelation::deleteAll(['user_guid'=>$user->user_guid]);
                    $user->parent_agent_name=$recUser->name;
                    $user->parent_agent_card=$recUser->card_number;
                    $user->updated_at=time();
                    if(!$user->save()) throw new Exception('更新用户表失败!');
                     
                    $userRelationNew=new UserRelation();
                    $userRelationNew->user_guid=$user->user_guid;
                    $userRelationNew->parent_user=$recUser->user_guid;
                    $userRelationNew->created_at=time();
                    if(!$userRelationNew->save()) throw new Exception('更新用户关系表失败!');
                     
                    $trans->commit();
                }catch (Exception $e){
                    $trans->rollBack();
                }
    
            }
             
        }
        return $recUser;
    }
    
    public function actionViewCate($id)
    {
        $model=NewsCate::findOne($id);
        $this->layout="@backend/views/layouts/news_layout.php";
        return $this->render('view-cate', [
            'model' => $model,
        ]);
    }

        
    
    /**
     * Finds the News model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return News the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = News::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
