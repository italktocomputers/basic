<?php

namespace app\models;

use yii\db\ActiveRecord;

class Member extends ActiveRecord {
    public function attributeLabels() {
        return [
            'member_id' => 'member_id',
            'member_email' => 'member_email',
            'role_id' => 'role_id',
            'company_id' => 'company_id',
        ];
    }

    public function rules() {
        return [
            [['member_email', 'role_id', 'company_id'], 'required'],
        ];
    }

    static function findByIndex($email) {
        return Member::find()
            ->where(['member_email' => $email])
            ->one();
    }

    static function findByCompany($company) {
        return Member::find()
            ->select('member_email, company_name, role_name')
            ->innerJoin('company', 'member.company_id = company.company_id')
            ->innerJoin('role', 'member.role_id = role.role_id')
            ->where(['company_name' => $company])->asArray()->all();
    }
}