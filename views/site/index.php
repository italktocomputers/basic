<?php

/** @var yii\web\View $this */

$this->title = 'DataPeople API';
?>

<h1>Endpoints</h1>

<h2>/job</h2>
<h3>Fetches jobs</h3>

<p>Input</p>

<table border="1">
    <tr>
        <td>email</td>
        <td>Hiring team member's email address</td>
    </tr>
    <tr>
        <td>from</td>
        <td>Date to start search from</td>
    </tr>
    <tr>
        <td>to</td>
        <td>Date to end search from</td>
    </tr>
</table>

<p>Response</p>

<code>
    {
        "count": number,
        "jobs":[
            {
                "job_id": number,
                "job_title": string,
                "member_email": string,
                "job_creation_date": date,
                "job_description": string
            }
        ]
    }
</code>

<p>Example</p>

<code>/job?email=Jabari_Abbott84@yahoo.com&from=2020-10-1&to=2023-11-30</code>

<h2>/user</h2>
<h3>Fetches users</h3>

<p>Input</p>

<table border="1">
    <tr>
        <td>company</td>
        <td>Company name user is from</td>
    </tr>
</table>

<p>Response</p>

<code>
    {
        "users":[
            {
                "member_email": string,
                "company_name": string,
                "role_name": string
            }
        ]
    }
</code>

<p>Example</p>

<code>/user?company=Hickle LLC</code>