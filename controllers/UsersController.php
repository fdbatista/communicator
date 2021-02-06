<?php

namespace app\controllers;

use app\models\ChangePasswordForm;
use app\models\CreateUserForm;
use app\models\entities\RoleUser;
use app\models\entities\User;
use app\models\search\UserSearch;
use app\utils\AuthUtil;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;

class UsersController extends BaseController
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' => function () {
                            return AuthUtil::iAmAdmin();
                        }
                    ],
                    [
                        'actions' => ['change-password'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    public function actionCreate()
    {
        $model = new CreateUserForm();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $attributes = $model->getAttributes(['user_name', 'full_name', 'mobile_number', 'email']);

            $user = new User($attributes);
            $user->auth_token = Yii::$app->security->generateRandomString(16);
            $user->password = Yii::$app->security->generatePasswordHash($model->password);
            $user->save();

            $roleUser = new RoleUser([
                'role_id' => 2,
                'user_id' => $user->id,
            ]);
            $roleUser->save();

            return $this->redirect(['index']);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    protected function findModel($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionChangePassword()
    {
        $model = new ChangePasswordForm();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $userModel = $this->findModel(AuthUtil::getMyId());
            $userModel->password = Yii::$app->security->generatePasswordHash($model->new_password);
            $userModel->save();
            Yii::$app->session->setFlash('success', 'La contraseña ha sido actualizada');

            return $this->redirect(['/']);
        }

        return $this->render('change-password', [
            'model' => $model,
        ]);
    }

}
