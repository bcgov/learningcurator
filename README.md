# Learning Curator

Curated content from disparate sources, organized into various learning pathways; these pathways are made up of steps, which have objectives; each step has various activities categorized by Read, Watch, Listen, and Participate. A step might include two in-person courses, an eLearning course, two books, three videos, and a podcast.

An emerging project from the Learning Centre for the BC Public Service Agency.

Initially this application will be used as a vehicle to contribute to the Corporate Leadership Development Framework.

## Features

There are categories of pathways. Pathways have steps; steps have activities; activies are categorized and tagged. A signed in user can identify which compentencies they would like to develop, follow pathways and claim activites.

## Usage
Follow pathways and complete the activities; get a certificate of completion.

## Requirements

CakePHP 4.03
MySQL/MariaDB

## Installation

* Clone the repository
* cd into learning-agent folder
* run composer install
* cp config/IdirAuthenticator.php vendor/cakephp/authentication/src/Authenticator/
* cp config/IdirIdentifier.php vendor/cakephp/authentication/src/Identifier/
* "somehow" obtain the starter database (ask Allan) and copy it into db #TODO figure this out!
* cp config/app_local.example.php to app_local.php
* edit config/app_local.php to point to MySQL database
* point server (Apache?) to learning-curator/webroot folder
* if setting up locally, set a server variable of REMOTE_USER
On Apache: 

        SetEnv REMOTE_USER ahaggett

Where "ahaggett" is the IDIR value assigned to user ID 1

## Project Status

Under active development.

## Goals/Roadmap
* Currently using ZenHub to track our various backlogs
* #TODO find a way to keep this section up-to-date rather than just pointing at zenhub 

## Getting Help or Reporting an Issue

## How to Contribute

Be part of the BC Gov organization here on Github, and join the group on (https://teams.microsoft.com/l/team/19%3a806e7ba6694e4bb1865bd3263084f80f%40thread.tacv2/conversations?groupId=08283480-3b33-45cd-ab68-0c9d6ede80e0&tenantId=6fdb5200-3d0d-4a8a-b036-d3685e359adc)[MS Teams] 

## License
Apache 2.0

Copyright 2019 Province of British Columbia

Licensed under the Apache License, Version 2.0 (the "License");
you may not use this file except in compliance with the License.
You may obtain a copy of the License at 

http://www.apache.org/licenses/LICENSE-2.0

Unless required by applicable law or agreed to in writing, software
distributed under the License is distributed on an "AS IS" BASIS,
WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
See the License for the specific language governing permissions and
limitations under the License.
