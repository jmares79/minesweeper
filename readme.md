# Minesweeper

This project is based on the code challenge provided as a test for a remote Sr PHP dev position.
It consists of a REST API crated with the [Laravel framework](https://laravel.com/)

## Objective

Develop the classic game of Minesweeper (in bold acomplished items at the time of writing this README)
  * __Design and implement  a documented RESTful API for the game (think of a mobile app for your API)__
  * Implement an API client library for the API designed above. Ideally, in a different language, of your preference, to the one used for the API
  * __When a cell with no adjacent mines is revealed, all adjacent squares will be revealed (and repeat)__
  * __Ability to 'flag' a cell with a question mark or red flag__
  * Detect when game is over
  * __Persistence__
  * Time tracking
  * Ability to start a new game and preserve/resume the old ones
  * __Ability to select the game parameters: number of rows, columns, and mines__
  * Ability to support multiple users/accounts

## Structure of the project

The main structure is obviously based in the one provided by Laravel, using the internal development server provided by PHP and powered by MySQL DBMS.

### Main classes

- > GameController: It controls the creation, saving, resuming and retrieving of all or any game.
- > GridController: Performs the algorithm for checking and marking a cell within the grid.
- > UserController: Will control the managing of users for games (TO DO)
- > Game: Model/Entity for managing a game
- > Grid: Model/Entity for managing a grid
- > Mark: Model/Entity for managing a mark
- > GameService: Holds the logic for creating a game, a grid (for the new game created), setting mines on grid and all neccesary checking.
- > GridService: Holds the logic for checking a certain cell within it, and calculate all cells when no mine is present on first check (Item 3 of objective list)

### Interfaces

- GameCreatorInterface
- GridCalculatorInterface

Created for flexible creation, mine setting on the grid (GameCreatorInterface) and cell revealing pattern (GridCalculatorInterface).
Implementing these interfaces will allow future developers to easily change the way the creation and mine setting is handled, supporting SOLID principles in that way.


### Installation

1. Clone the repo from this repository
2. Execute `composer install` for vendor dependencies, once the repo was succesfully cloned.
2. Copy `.env.example`to `.env` and manage your database credentials accordingly.
2. Create a database called __minesweeper__ (or any name you like) in MySQL, as stated in `.env`.
3. Execute `php artisan migrate` for the physical creation of the Schema and Models.
4. Execute `php artisan serve` for the development server or set a custom web server as desired.

### Usage

As this is an API, use a REST Client (I use [Postman](https://www.getpostman.com/)), and in the URL enter:

`https:\\<local.server.domain>:<port>\api\<route>` where <route> is in `api.php`
