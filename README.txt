Andrew Karnani
Drew Kessler
Lindsay Poirier
Daniel Souza 

Google Code Project Page
http://code.google.com/p/wsd-final-project/
Checkout SVN:
svn checkout http://wsd-final-project.googlecode.com/svn/trunk/ wsd-final-project-read-only 

For general details about who did what, consult the Final_Project_Presentation.pdf

For specifics, check the SVN Changelog:
http://code.google.com/p/wsd-final-project/source/list

Required Server Technology:
 MYSQL
 PHP

Requirements for setup:
 1. Import database/all.sql to a MYSQL Server
  a. Optionally (but highly recommended), import final_data.sql
 2. Update dbcon.php to reflect the correct database information
 3. Using your favorite job scheduler (CRON), schedule the following scripts to be run in the following order:
    1. scripts/collect_articles.php
    2. scripts/keywords/keywords.php
    3. scripts/cluster_users.php

How to use:
 1. Follow setup instructions.
 2. Navigate to web/final_project.php

Complete Folder/File Breakdown:
database - contains structure and data for the database
 all.sql - contains database structure
 final_data.sql - sql to insert data into database
 sample_data.sql - sql to insert sample data into database (not production level)
scripts - contains php scripts to do various functions of our system
 keywords - contains php scripts to generate keywords for articles
  frequency.php - function that returns the frequency of words given a url
  keywords.php - generates keywords in the db for the most recent x articles updating frequencies along the way
  keywords-update.php - updates keywords for articles after the fact (nightly for example) does not update frequencies (b/c they have already been seen).
 cluster_users.php - updates user clusters in the database
 collect_articles.php - 
 dump.csv - sample click data
 get_sample_data.php - inserts the sample data into the database
 jaccard_similarity.php - function that determines the jaccard distance between two arrays
web
 CAS-1.2.1 - contains files necessary for CAS authentication
 CAS_RPI.php - script to login users using CAS
 CAS_RPI_logout.php - CAS logout script
 click.php - script to log a user click in the database
 final_project.css - main page style sheet
 final_project.php - the main web page
dbcon.php - database connection script, need to update
Final_Project_Presentation.pdf - Presentation file of the project
