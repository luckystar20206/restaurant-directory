## Restaurant Directory

This project is a sample Laravel 5.7 + Vue web application built on Listing responsive theme of ColorLib, to list, sort and filter restaurants. Users can also favourite restaurants.

In this project, you are able to see a restaurant list with detailed information and sort the restaurant list based on the following order:
1. Restaurans are first sorted by whether they are favorited by user or not
1. Then their current states are included in the sorting mechanism. Open restaurants are shown first, then Order Ahead restaurants are coming and the last group is Closed restaurants.
1. There is also a dropdown list above restaurant list used for third sorting mechanism. It has the below options:
	* Best Match (default choice)
	* Newest
	* Rating Average
	* Distance
	* Popularity
	* Average Product Price
	* Delivery Costs
	* Minimum Costs
	* Top Restaurants

You can search restaurants by their name using the search box above restaurant list.

### Demo

[Live Demo](http://165.227.166.12:1999)

### Installation

This project is built on PHP 7.2.15.

`composer install`
<br>
`npm install`

### Database

No database is used in this project.

Restaurant data should be stored in `database\data\restaurants.json`. This file is being converted to a Laravel Collection in controller.

A sample file is included in the project.

Favorited restaurants are kept in cookies.

### Testing

A unit test is created under `tests\Unit\UnitTest.php` which works on PHPUnit. It checks 8 different functionality of the project. With addition of Laravel's default 2 tests, testing result is below:

`PHPUnit 7.5.5 by Sebastian Bergmann and contributors.`
<br>
`..........                                                        10 / 10 (100%)`
<br>
`Time: 245 ms, Memory: 14.00MB`
<br>
`OK (10 tests, 10 assertions)`

In order to run this test, run `.\vendor\bin\phpunit` command in project directory.