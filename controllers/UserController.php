<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\models;

class UserController extends Controller {
    public function actionIndex() {
        $company = Yii::$app->request->get('company');
        $members = \app\models\Member::findByCompany($company);

        return $this->asJson([
            "users" => $members,
        ]);
    }
}