# downloadAll
Reads a file of urls and downloads the contents to a specified directory

## Write permissions

Make sure you set the output directory to have permissions to write by the user running the script

## Setup and Run	

- Clone the repo to a directory.
- Setup the /output directory with the proper write permissions.
- Edit the urls.txt file.
- Run the file. You can use terminal/bash by navigating to the directory of index.php and run `php index.php`.

## urls.txt format

- One URL per-line.
- The urls need to be full urls including the file extension. For example: https://www.somedomain.com/images/fileName.jpg
- You can view sampleUrls.txt for an example.

### TODOs
- Add better error reporting.
- Better file handling based on the file ext.
- Fix memory leaks when using a huge urls.txt file.
- Cleaner user interface.