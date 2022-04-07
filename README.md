# Sudoku solver

This app solves sudoku. I'm sure you've already figured that out :D
It can validate you sudoku, point out problems and determine whether it has one or multiple solutions.
It is based on Laravel framework. With a side of JQuery.

## Running App

This application assumes that you have installed PHP 7.4 or newer, Composer and most common php packages.
In case you're not sure, you can run those commands:
#### PHP 7.4
```
sudo apt-get update
sudo apt -y install software-properties-common
sudo add-apt-repository ppa:ondrej/php
sudo apt-get update
sudo apt -y install php7.4
```

####Dependencies
```
sudo apt-get install -y php7.4-cli php7.4-json php7.4-common php7.4-mysql php7.4-zip php7.4-gd php7.4-mbstring php7.4-curl php7.4-xml php7.4-bcmath
```
####Composer
```
sudo apt-get install composer
```
Once it is done - go to the project root and install packages for framework:
```
cd puzzle_solver/

composer install
```
After that open a terminal and navigate to sudoku/public directory.
```
cd public/
```
And start a PHP server:
```
php -S localhost:8000
```
And navigating to [http://localhost:8000](http://localhost:8000) in your browser.

## Files

In order to get a valid response, your file must be formatted as follows:

Format on the sudoku puzzle file:

1. File has nine lines
2. Each line consists of nine characters
3. A character is either a number between 1-9 or "." for empty square
4. Only files with .txt format are accepted

### Testing App

You can run tests for this program by executing command from the root directory

```
php artisan test
```



