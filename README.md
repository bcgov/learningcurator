# Learning Curator

Learning Curator Pathways feature informal learning by theme or community. Here you’ll find recommendations for resources to watch, read, listen to, and courses that will help you reach your goals. Pathways are created by BC Public Service learning curators. 

## Introduction to Learning Curation 

Lists of links to other resources have long been a part of online courses. Sometimes these lists were at the module-level, sometimes at the whole-course level. The best ones would give a brief description of each item, but sometimes they didn’t. They served a purpose that learning curation still does today—it saved learners the trouble of wading through a sea of content to find what’s relevant to their learning needs. 

Now, instructional designers are increasingly using content curation as a best practice for learning and training. There’s an impressive array of content online and offline. It’s not possible—or necessary—to create it all ourselves. The BC Public Service is taking existing material and putting our own spin on it to give our learners added value. The added value part is key—rather than just presenting a nice collection of resources with no commentary other than “hey, this all fits in this topic,” there’s a careful approach that shows your audience how the items will help them achieve their desired outcomes. 

## Features

* Topics align with the [Corporate Learning Framework](https://learningcentre.gww.gov.bc.ca/learninghub/what-is-corp-learning-framework/).
* There are topics which have pathways. Pathways have steps; steps have activities which are links to great resources.
* A signed in user can follow pathways and can see a progress bar grow as they launch activites.
* We regularly audit activities, but learners can also report problem activities through a simple form.

## Code Requirements/Installation

* Learning Curator utilizes CakePHP 4+ and employs MariaDB as its database technology.
* It is a "classical" MVC architecture that queries the database on each page load and dynamically composes the pages via PHP.
* Vanilla Javascript is used to apply dynamic features calling a single user API to get user pathway follows and activity launches.

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
- cp config/tocopy/User.php vendor/cakedc/users/src/Model/Entity/User.php

## Project Status

Under active development.

## Goals/Roadmap

- World-class interface for Curator collaborators to create and manage pathways.
- Split off the user tracking API into its own app and start generating static HTML pathways.

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

[![Lifecycle:Maturing](https://img.shields.io/badge/Lifecycle-Maturing-007EC6)](<Redirect-URL>)
