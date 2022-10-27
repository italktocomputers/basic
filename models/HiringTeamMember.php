<?php

namespace app\models;

use yii\db\ActiveRecord;

class HiringTeamMember extends ActiveRecord {
    public function attributeLabels() {
        return [
            'hiring_team_id' => 'hiring_team_id',
            'member_id' => 'member_id',
        ];
    }

    public function rules() {
        return [
            [['hiring_team_id', 'member_id'], 'required'],
        ];
    }

    static function findByIndex($hiring_team_id, $member_id) {
        return HiringTeamMember::find()
            ->where(['hiring_team_id' => $hiring_team_id])
            ->where(['member_id' => $member_id])
            ->one();
    }
}