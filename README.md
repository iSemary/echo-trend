# echo-trend

-   [About](#about)
-   [Features](#features)
-   [Get Started](#get-started)
    -   [Postman Collection](#postman-collection)
    -   [Installation](#installation)

## About

Full-stack web application built with PHP Laravel on the backend and React on the frontend. It provides a personalized news feeds, and engaging features.

## Features

1. **User Authentication & Registration:**
    - Enable account creation and login for saving preferences.
2. **Article Search & Filtering:**
    - Implement keyword-based search and filters for date, category, and source.
3. **Personalized News Feed:**
    - Allow users to customize their feed with preferred sources, categories, and authors.
4. **Mobile-Responsive Design:**
    - Optimize the website for a seamless mobile viewing experience.

## Get Started

### Postman Collection

[Open With Postman](https://www.postman.com/isemary/workspace/echo-trend/overview)

### Installation

#### 1. Clone The Repository

    git clone https://github.com/iSemary/echo-trend.git

### Laravel Project

#### 2. Install Required Dependencies

    composer i

#### 3. Migrate Tables

    php artisan migrate
    php artisan module:migrate

#### 3. Migrate Tables

    php artisan passport:install

#### 4. Run application local

    php artisan serve


### React Project

#### 5. Navigate to react project 

    cd resources/js

#### 6. Install Dependencies 

    npm i

#### 7. Run Local

    npm start

#### 8. Watch SCSS Files

    sass --watch resources/js/src/assets/styles/style.scss:resources/js/src/assets/styles/style.css