# SBFSpot Charts

SBFSpot Charts is an independent web application built using the [Laravel 5.8 framework](https://www.laravel.com).  It uses [SBFSpot](https://sbfspot.codeplex.com/) for reading data from the SMA inverter
over bluetooth on a [Raspberry Pi](https://www.raspberrypi.org), and the [Google Charts API](https://developers.google.com/chart/) for visualisations. 

## Features
* Supports multi inverter plants
* Daily charts graph generation per inverter every 5 minutes across the day as well as total generation for the day
* Monthly charts graph generation per inverter per day, and daily average for the month
* Yearly charts graph generation per inverter per year, and monthly average across the year

## Todo List:
* Potentially use a lighter weight framework for backend given the simplicity of the app.
* Add charting of exported vs used values
  * Note: I don't have access to inverters that record grid exports separately, if anyone wants this, I'll need some sample data to experiment with, or welcoming PR's.

## System Requirements
Being based on Laravel, this has the same requirements as that. See their requirements.

## Installation

1. Establish a working copy of [SBFSpot](https://sbfspot.codeplex.com/documentation)
2. Set up a database and cron job to store the data from SBFSpot.
  * This has been tested using a MySQL database setup, but should theoretically also work with SQLite
3. Clone the repository to your server with `git clone https://CJ_au@bitbucket.org/CJ_au/solar-tracking.git`.
4. Copy `.env.example` to `.env` and configure with your database connection details as used by SBFSpot.  
5. Set up a virtualhost pointing to the application's `public` directory.
6. Install required composer dependencies with `composer install`.
7. Open the site in a browser.

## Credits
* [SBFSpot](https://sbfspot.codeplex.com/) for reading data from the SMA inverter
* [Laravel 5.8 framework](https://www.laravel.com) for backend/API
* [TailwindCSS](https://tailwindcss.com) for majority of CSS
* [VueJS](https://vuejs.org/) for interactive components