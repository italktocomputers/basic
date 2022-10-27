<?php

namespace app\models;

use yii\db\ActiveRecord;

class Job extends ActiveRecord {
    public function attributeLabels() {
        return [
            'job_id' => 'job_id',
            'job_title' => 'job_title',
            'job_description' => 'job_description',
            'job_creation_date' => 'job_creation_date',
            'hiring_team_id' => 'hiring_team_id',
            'company_id' => 'company_id',
        ];
    }

    public function rules() {
        return [
            [['job_title', 'job_description', 'job_creation_date', 'hiring_team_id', 'company_id'], 'required'],
        ];
    }

    static function findByIndex($title) {
        return Job::find()
            ->where(['job_title' => $title])
            ->one();
    }

    static function findByEmailAndRange($email, $from, $to) {
        return Job::find()
            ->select('job_id, job_title, company_name, member_email, job_creation_date, job_description')
            ->innerJoin('hiring_team_member', 'job.hiring_team_id = hiring_team_member.hiring_team_id')
            ->innerJoin('member', 'hiring_team_member.member_id = member.member_id')
            ->innerJoin('company', 'job.company_id = company.company_id')
            ->where(['member_email' => $email])
            ->andWhere(['between', 'job_creation_date', $from, $to])->asArray()->all();
    }
}