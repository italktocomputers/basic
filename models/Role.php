<?php

namespace app\models;

use yii\db\ActiveRecord;

class Role extends ActiveRecord {
    public function attributeLabels() {
        return [
            'role_id' => 'role_id',
            'role_name' => 'role_name',
        ];
    }

    public function rules() {
        return [
            [['role_name'], 'required'],
        ];
    }

    static function findByIndex($name) {
        return Role::find()
            ->where(['role_name' => $name])
            ->one();
    }
}