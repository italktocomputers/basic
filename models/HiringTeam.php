<?php

namespace app\models;

use yii\db\ActiveRecord;

class HiringTeam extends ActiveRecord {
    public function attributeLabels() {
        return [
            'hiring_team_id' => 'hiring_team_id',
        ];
    }

    static function findByIndex($hiring_team_id) {
        return HiringTeam::find()
            ->where(['hiring_team_id' => $hiring_team_id])
            ->one();
    }
}