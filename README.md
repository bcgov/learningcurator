# Learning Curator

Learning Curator Pathways feature informal learning by theme or community. Here you’ll find recommendations for resources to watch, read, listen to, and courses that will help you reach your goals. Pathways are created by BC Public Service learning curators. 

An emerging project from the Learning Centre for the BC Public Service Agency.

## Features

There are topics which have pathways. Pathways have steps; steps have activities; activies are categorized and tagged. A signed in user can follow pathways and claim activites, tracking their own progress via activity rings.

Area > Topic > Pathway > Step > Activity 

## Usage
Follow pathways and complete the activities; informal, self-directed learning but guided by a curated structure that makes sense and is timely.

## Requirements

CakePHP 4.03
MySQL/MariaDB

- mysql source config/curator-schema-plus-starter.sql
- update fullBaseUrl value in config/app_local.php
- update database access values in config/app_local.php
- cp config/tocopy/Azure.php vendor/thenetworg/oauth2-azure/src/Provider/Azure.php
- cp config/tocopy/AzureMapper.php vendor/cakedc/auth/src/Social/Mapper/Azure.php
- cp config/tocopy/ProfileTrait.php vendor/cakedc/users/src/Controller/Traits/ProfileTrait.php
- cp config/tocopy/SimpleCrudTrait.php vendor/cakedc/users/src/Controller/Traits/SimpleCrudTrait.php
- cp config/tocopy/UsersTable.php vendor/cakedc/users/src/Model/Table/UsersTable.php
- cp config/tocopy/UserEntities.php vendor/cakedc/users/src/Model/Entity/User.php
- cp config/tocopy/SocialBehavior.php vendor/cakedc/users/src/Model/Behavior/SocialBehavior.php

## Project Status

Under active development.

## Goals/Roadmap

- World-class interface for Curator collaborators to create and manage pathways

## Getting Help or Reporting an Issue

## How to Contribute

Be part of the BC Gov organization here on Github, and join the group on [MS Teams](https://teams.microsoft.com/l/team/19%3a806e7ba6694e4bb1865bd3263084f80f%40thread.tacv2/conversations?groupId=08283480-3b33-45cd-ab68-0c9d6ede80e0&tenantId=6fdb5200-3d0d-4a8a-b036-d3685e359adc) 

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
