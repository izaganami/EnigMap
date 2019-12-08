# EnigMap

A map enigma containing different quests in every continent based on leaflet library.

## Getting Started

Clone this repository in your local server. (htdocs folder if using XAMPP)

### Prerequisites

Make sur to have mySQL running well in order to create the database, run your command console and type

```
cd C:\XAMPP\mysql\bin 
```
If xampp is installed somewhere else change the path.

```
mysql.exe -u "your username" -p "your password"
```

Assuming everything works fine and your server (apache in our case) is running just make sure it runs on port 80. 
If that's not the case you can access config.php and change 
```
define('BASE_URL', 'http://localhost/Enigmap/'); 
```
to:
```
define('BASE_URL', 'http://localhost:Your Port/Enigmap/');
```
### Installing

In your data base system create a database named "mapgame".
Now open "mapgame.sql" file with a text editor and copy what's writen inside and paste it into your sql query line.

You should get a success message like:
```
Query took 0.7652 seconds.
```

Browse through the database to check its integrity or run some basic queries to view the rows.



## Deployment

Now that the database is set and the website is well deployed on your local server, all that is left is 
to browse an url like: 

```
http://localhost/Enigmap/
```
make sure to specify the port if it is different than 80

## Built With

* [Leaflet](https://leafletjs.com/) - API for web mapping
* [Howler](https://howlerjs.com/) - Audio Library for Js
* [Bootstrap](https://getbootstrap.com/docs/3.3/) - Custom Styles



## Authors

* **Jallouf Younes** - *Initial work* - [Izaganami](https://github.com/izaganami)
* **Barmani Amina** - *Initial work* - [BarAmina](https://github.com/BarAmina)



## Acknowledgments

* Inspired by this library to generate custom markers: [mapshakers](https://github.com/mapshakers/leaflet-mapkey-icon)


