# LifeTrack Technical Exam
 
### Description

The Lifetrack Study Tracker is a single page application which calculates the forecasted costs for each month with a given growth month-on-month parameter, number of studies per day, and the number of months to forecast. Instead of separating the repository for the frontend and the backend, just for this exercise, I bundled them together in the same repository for easier downloading.

### Problem
##### Input parameters
  - Current Number of study per day
  - Number of Study Growth per month in %
  - Number of months to forecast

##### Calculation of costs:

##### RAM
```math
RAM costs: 1000 studies = 500MB; 1GB of RAM is 0.00553 / hour
1GB RAM = 1000 x 2 studies = 0.00553 / hour
1 study = $0.000002765 / hour or $0.00006636 / day or $ 0.0019908 / 30-day month or $ 0.00205716 / 31-day month
```

##### Storage
```math
Storage costs: 1 study = 10 MB; 1GB of storage is 0.10 USD / month
1000 MB / 10 MB per study = 100 studies per 1GB of storage
1 study = $ 0.0001 USD / month
```

### Tech Stack Used

- Frontend
  - ReactJS (Javascript)
  - SCSS (CSS)
  - HTML
  - Material UI
  - react-chartjs-2
- Backend
  - Laravel / Lumen (PHP)
  - Swagger (for documentation)

### How to run

#### Prerequisites
1. npm - https://www.npmjs.com/get-npm
3. PHP - https://www.php.net/manual/en/install.php
4. Git - https://git-scm.com/download/linux
5. Composer - https://getcomposer.org/download/

#### Installation

To simplify the installation, let's just and serve the files locally instead of serving through a web server like nginx / apache.

##### Frontend
1. git clone git@github.com:KaizerBienes/lifetrack-kbienes-exam.git
2. in a terminal, open the lifetrack-react directory, `cd ./lifetrack-kbienes-exam/lifetrack-react`
3. to install the dependencies, trigger `npm install`
4. to serve the react app, run `npm start`
5. open the browser and then go to `http://localhost:3000` to view the page

##### Backend
5. in a different terminal, open the lifetrack-laravel directory `cd ./lifetrack-kbienes-exam/lifetrack-laravel`
6. to install laravel dependencies, run `composer install`
7. to serve the laravel app, run `php -S localhost:8001 -t public`

##### Optional (Swagger API Documentation)
8. to generate the swagger documentation, in `./lifetrack-laravel`, trigger `php artisan swagger-lume:generate `
7. serve the laravel app, run `php -S localhost:8001 -t public`
9. view the swagger documentation via `http://localhost:8001/api/documentation`

### Further Enhancements / Suggestions due to lack of time
1. Tests on both the frontend and the backend
2. Implement Material UI on all of the components
3. Introduce debounce to limit the calls to the backend
4. Spawn a web server for deployment
5. Specify specific frontend webserver for CORS handling on the backend

### Output
<img src="https://drive.google.com/thumbnail?id=1yFjn5KLHSK9iXjAzDByWRTN3kBZCVFtj&sz=w600-h600" />
