# Dog Api Scraper App

## Description

An app to scrape data from the https://dog.ceo/dog-api/ Dog Pictures API and add it to a database.

Designed to be used with the NMR Top-dog App.

## Compatibility and dependencies

To be used with Vagrant VM.

Requires Autoloading from Composer Dependency Manager for PHP https://getcomposer.org/ 

## Installation

* Clone git repo on local machine. 
* Setup database to receive info:
  * Create a database called 'top_dog'
  * In the 'top_dog' database - import the .sql files in the 'db' directory to your database.
  
## Usage

*As of April 2019 running this scraper will grab around 20,000 rows of data, and may take up to 30 seconds to run.*

* Using terminal, SSH into your Vagrant machine using ```vagrant ssh```
* ```cd``` to the location of the top dog project using your Vagrant command line
* inside the top dog folder, navigate to ```src/scraper```
* run the scraper using ```php run.php```

## Contributing

Please open an issue for any bugs or improvements.