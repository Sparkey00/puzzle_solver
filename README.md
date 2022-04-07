# Sudoku solver

This app solves sudoku. I'm sure you've already figured that out :D
It can validate you sudoku, point out problems and determine whether it has one or multiple solutions.
It is based on Laravel framework. With a side of JQuery.

## Running App

In order to run the app you need to have PHP 7.4 or higher.
After that open a terminal and navigate to sudoku/public directory.
```
cd sudoku/public/
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



