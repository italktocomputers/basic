<?php

namespace app\commands;

use Yii;
use yii\console\Controller;
use yii\console\ExitCode;
use app\models;

/**
 * This command imports data from the specified file.
 */

class ImportController extends Controller {
    protected $fp = null;

    public function actionIndex($file) {
        if (!isset($file)) {
            echo "File not specified!\n";
            return ExitCode::IOERR;
        }

        if (!file_exists($file)) {
            echo "File not found!\n";
            return ExitCode::IOERR;
        }

        if (!$this->fp = fopen($file, "r")) {
            echo "Cannot open file for reading!";
            return ExitCode::IOERR;
        }

        $this->start_ingest();
    }

    protected function start_ingest() {
        $lineNumber = 1;

        echo "Starting ingest at " . date('l jS \of F Y h:i:s A') . "\n";

        // loop through each line of file
        while(!feof($this->fp)) {
            $jsonl = fgets($this->fp);

            // from json string to associative array
            if (!$arr = json_decode($jsonl, true)) {
                continue;
            }

            $company = $this->companyIngest($arr);
            $hiringTeam = $this->hiringTeamIngest();

            // each hiring_team property is an array which has an email and role property
            foreach ($arr['hiring_team'] as $row) {
                $role = \app\models\Role::findByIndex($row['role']);
                $member = $this->memberIngest($row, $company, $role);
                if ($member) {
                    $this->hiringTeamMemberIngest($hiringTeam, $member);
                }
            }

            $this->jobIngest($arr, $hiringTeam, $company);

            echo "$lineNumber lines imported!\n";

            $lineNumber++;
        }

        echo "Ending ingest at " . date('l jS \of F Y h:i:s A') . "\n";

        return ExitCode::OK;
    }

    protected function companyIngest($data) {
        echo "Ingesting company...\n";

        $company = \app\models\Company::findByIndex($data['company_name']);

        if (!isset($company->company_name)) {
            // company not found so add this one
            $company = new \app\models\Company();
            $company->attributes = array(
                "company_name" => $data['company_name']
            );
            if ($company->validate()) {
                $company->save();
            }
            else {
                echo "Cannot import company...\n";
                print_r($company->errors);
            }
        }

        return $company;
    }

    protected function hiringTeamIngest() {
        echo "Ingesting hiring team...\n";

        $hiringTeam = new \app\models\HiringTeam();
        $hiringTeam->save();
        return $hiringTeam;
    }

    protected function memberIngest($data, $company, $role) {
        echo "Ingesting member...\n";

        if (!isset($data['email'])) {
            echo "Email not found!  Skipping...\n";
            return false;
        }

        $member = \app\models\Member::findByIndex($data['email']);

        if (!$member) {
            // member not found, so add this one
            $member = new \app\models\Member();
            $member->attributes = array(
                "member_email" => $data['email'],
                "role_id" => $role->getAttribute('role_id'),
                "company_id" => $company->getAttribute('company_id'),
            );
            if ($member->validate()) {
                $member->save();
            }
            else {
                echo "Cannot import member...\n";
                print_r($member->errors);
            }
        }

        return $member;
    }

    protected function hiringTeamMemberIngest($hiringTeam, $member) {
        echo "Ingesting hiring team member...\n";

        $hiringTeamMember = \app\models\HiringTeamMember::findByIndex(
            $hiringTeam->getAttribute('hiring_team_id'),
            $member->getAttribute('member_id')
        );

        if (!$hiringTeamMember) {
            // member not found, so add this one
            $hiringTeamMember = new \app\models\HiringTeamMember();
            $hiringTeamMember->attributes = array(
                "hiring_team_id" => $hiringTeam->getAttribute('hiring_team_id'),
                "member_id" => $member->getAttribute('member_id'),
            );
            if ($hiringTeamMember->validate()) {
                $hiringTeamMember->save();
            }
            else {
                echo "Cannot import hiring team...\n";
                print_r($hiringTeamMember->errors);
            }
        }

        return $hiringTeamMember;
    }

    protected function JobIngest($data, $hiringTeam, $company) {
        echo "Ingesting job...\n";

        $job = \app\models\Job::findByIndex($data['title']);

        if (!isset($job->title)) {
            $job = new \app\models\Job();
            $job->attributes = array(
                "job_title" => $data['title'],
                "company_id" => $company->getAttribute('company_id'),
                "hiring_team_id" => $hiringTeam->getAttribute('hiring_team_id'),
                "job_description" => $data['description'],
                "job_creation_date" => date(\DateTime::ATOM, strtotime($data['creation_date']))

            );
            if ($job->validate()) {
                $job->save();
            }
            else {
                echo "Cannot import job...\n";
                print_r($job->errors);
            }
        }

        return $job;
    }
}
