<?php

namespace app\controllers;

use Yii;
use app\models;
use yii\web\Controller;

class JobController extends Controller {
    public function actionIndex() {
        $email = Yii::$app->request->get('email');
        $from = Yii::$app->request->get('from');
        $to = Yii::$app->request->get('to');
        $jobs = \app\models\Job::findByEmailAndRange($email, $from, $to);

        return $this->asJson([
            "count" => count($jobs),
            "jobs" => $jobs,
        ]);
    }
}