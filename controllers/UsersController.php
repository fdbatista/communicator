<?php

namespace app\controllers;

use app\models\ChangePasswordForm;
use app\models\CreateUserForm;
use app\models\entities\RoleUser;
use app\models\entities\User;
use app\models\search\UserSearch;
use app\utils\AuthUtil;
use app\utils\EncryptUtil;
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
            $this->encryptModel($user);
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

        if ($model->load(Yii::$app->request->post())) {
            $this->encryptModel($model);

            if ($model->save()) {
                return $this->redirect(['index']);
            }
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
            return $this->decryptModel($model);
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    private function decryptModel(User $model){
        $model->user_name = EncryptUtil::decrypt($model->user_name);
        $model->full_name = EncryptUtil::decrypt($model->full_name);
        $model->email = EncryptUtil::decrypt($model->email);

        if ($model->mobile_number) {
            $model->mobile_number = EncryptUtil::decrypt($model->mobile_number);
        }

        return $model;
    }

    private function encryptModel(User &$model){
        $model->user_name = EncryptUtil::encrypt($model->user_name);
        $model->full_name = EncryptUtil::encrypt($model->full_name);
        $model->email = EncryptUtil::encrypt($model->email);

        if ($model->mobile_number) {
            $model->mobile_number = EncryptUtil::encrypt($model->mobile_number);
        }
    }

    public function actionChangePassword()
    {
        $model = new ChangePasswordForm();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $userModel = $this->findModel(AuthUtil::getMyId());
            //$userModel->password = Yii::$app->security->generatePasswordHash($model->new_password);
            $userModel->updateAttributes([
                'password' => Yii::$app->security->generatePasswordHash($model->new_password),
            ]);

            Yii::$app->session->setFlash('success', 'La contraseña ha sido actualizada');

            return $this->redirect(['/']);
        }

        return $this->render('change-password', [
            'model' => $model,
        ]);
    }

}
