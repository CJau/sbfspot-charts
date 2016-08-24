# Solar Tracking

Solar Tracking is a web application built using the [Laravel framework](http://www.laravel.com).  It uses [SBFSpot](https://sbfspot.codeplex.com/) for reading data from the SMA inverter
over bluetooth on a [Raspberry Pi](http://www.raspberrypi.org), and the [Google Charts API](https://developers.google.com/chart/) for visualisations. 

## System Requirements

Being based on Laravel, this has the same requirements as that. See their requirements.

## Installation

1. Establish a working copy of [SBFSpot](https://sbfspot.codeplex.com/documentation)
2. Set up a database and cron job to store the data from SBFSpot. 
3. Clone the repository to your server with `git clone https://CJ_au@bitbucket.org/CJ_au/solar-tracking.git`.
4. Copy `.env.example` to `.env` and configure with your database connection details as used by SBFSpot.
5. Set up a virtualhost pointing to the application's `public` directory.
6. Install required composer dependencies with `composer install`.
7. Open the site in a browser.