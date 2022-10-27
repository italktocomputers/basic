<?php

namespace app\models;

use yii\db\ActiveRecord;

class Company extends ActiveRecord {
    public function attributeLabels() {
        return [
            'company_id' => 'company_id',
            'company_name' => 'company_name',
        ];
    }

    public function rules() {
        return [
            [['company_name'], 'required'],
        ];
    }

    static function findByIndex($name) {
        return Company::find()
            ->where(['company_name' => $name])
            ->one();
    }
}