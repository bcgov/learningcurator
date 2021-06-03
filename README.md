# Learning Curator

Content from many different sources curated into loosely structured learning pathways. These pathways have objectives which are divided up into steps. Each step has various activities (which are simply links out to a resource), some of which are required, while others are supplemental. A step might include two in-person courses, an eLearning course, two books, three videos, and a podcast. Users can track which activities they've consumed, and as they do so, their progress is displayed as colorful progress rings.

An emerging project from the Learning Centre for the BC Public Service Agency.

## Features

There are categories of pathways. Pathways have steps; steps have activities; activies are categorized and tagged. A signed in user can follow pathways and claim activites, tracking their own progress via activity rings.

## Usage
Follow pathways and complete the activities; informal, self-directed learning but guided by a structure that makes sense and is timely and curated.

## Requirements

CakePHP 4.03
MySQL/MariaDB

- mysql source config/curator-schema-plus-starter.sql
- cp config/tocopy/Azure.php vendor/thenetworg/oauth2-azure/src/Provider/Azure.php (overwrite existing)
- cp config/tocopy/AzureMapper.php vendor/cakedc/auth/Social/Mapper/Azure.php (new file)
- cp config/tocopy/ProfileTrait.php vendor/cakedc/users/src/Controller/Traits/ProfileTrait.php (overwrite existing)

## Project Status

Under active development.

## Goals/Roadmap

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
