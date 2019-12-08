
<?php include("config.php") ?>

<?php include(INCLUDE_PATH . "/logic/common_functions.php"); ?>
    <!DOCTYPE html>
    <html>
    <head>
        <meta charset="utf-8">
     - Home</title>
        <!-- Bootstrap CSS -->

        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/howler/2.1.2/howler.js"></script>
        <!-- Custome styles -->
        <link rel="stylesheet" href="assets/css/style.css">
        <link rel="stylesheet" href="assets/css/wickedcss.min.css">

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.2/animate.min.css">

        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.5.1/dist/leaflet.css"
              integrity="sha512-xwE/Az9zrjBIphAcBb3F6JVqxf46+CDLwfLMHloNu6KEQCAWi6HcDUbeOfBIptF7tcCzusKFjFw2yuvEpDL9wQ=="
              crossorigin=""/>
        <script src="https://unpkg.com/leaflet@1.5.1/dist/leaflet.js"
                integrity="sha512-GffPMF3RvMeYyc1LWMHtK8EbPv0iNZ8/oTtHPx9/cc2ILxQ+u905qIwdpULaqDkyBKgOaB57QTMg7ztg8Jm2Og=="
                crossorigin=""></script>
        <script src="assets/images/icons/leaflet-mapkey-icon-master/dist/L.Icon.Mapkey.js"></script>
        <link rel="stylesheet" href="assets/images/icons/leaflet-mapkey-icon-master/dist/MapkeyIcons.css" />
    </head>
    <style>
        .leaflet-buttons-control-button
        {
            max-width: 40px !important;
            padding-right: 10px !important;
        }

        #tablee {
            color: #333;
            font-family: Helvetica, Arial, sans-serif;
            width: 640px;
            border-collapse:
                    collapse; border-spacing: 0;
        }

        .tdd, #thh {
            border: 1px solid transparent; /* No more visible border */
            height: 30px;
            transition: all 0.3s;  /* Simple transition for hover effect */
        }

        #thh {
            background: #DFDFDF;  /* Darken header a bit */
            font-weight: bold;
            text-align: center;
        }

        .tdd {
            background: #FAFAFA;
            text-align: center;
        }

        #trr:nth-child(even) #tdd { background: #F1F1F1; }

        #trr:nth-child(odd) #tdd { background: #FEFEFE; }

        #trr #tdd:hover { background: #666; color: #FFF; }

</style>
<body>
<?php include(INCLUDE_PATH . "/layouts/navbar.php") ?>
<?php include(INCLUDE_PATH . "/layouts/messages.php") ?>
    <link data-react-helmet="true" rel="stylesheet" href="https://static.x-plarium.com/browser/canvas/pp/200/edge/client/common.css"/><link data-react-helmet="true" rel="apple-touch-icon" href="//cdn01.x-plarium.com/browser/content/portal/common/favicon/apple-icon-180x180.png" sizes="180x180"/>

<table class="table table-borderless" style="border: 0px black" >
    <tr >
        <td style="border: 0px;"></td>
        <td class=" roll-in-blurred-left flicker-1" style="border: 3px;max-width: 200px ">
            <p class="speech-bubble" style="font-size: 15px;padding: 10px"> ENIGMAP : Choisie l'enigme et essaye de trouver les objets pour la résoudre </p></td>
        <td style="border: 0px;"></td>
    </tr>
    <tr  >
        <td colspan="3" id="mapid" class="scale-in-center" style="border: 0px"></td>

    </tr>
    <tr>
        <table id="tablee">
            <tr id="trr">
                <th id="thh">Top Players</th>
                <th id="thh">Score</th>
                <th id="thh">Time</th>
            </tr>
            <tr id="trr">
                <td class="tdd" id="tdd11"></td>
                <td class="tdd" id="tdd12"></td>
                <td class="tdd" id="tdd13"></td>
            </tr>
            <tr id="trr">
                <td class="tdd" id="tdd21"></td>
                <td class="tdd" id="tdd22"></td>
                <td class="tdd" id="tdd23"></td>
            </tr>

        </table>
    </tr>
</table>




<div class="slide-out-top" id="zoomerOut" style=" overflow: hidden;"> <img src="assets/images/welcome.jpg"> </div>


    <script src="assets/js/map.js"></script>
<script>
    L.Control.Button = L.Control.extend({
        options: {
            position: 'bottomright',

        },
        initialize: function (options) {
            this._button = {};
            this.setButton(options);
        },

        onAdd: function (map) {
            this._map = map;
            var container = L.DomUtil.create('div', 'leaflet-control-button');

            this._container = container;

            this._update();
            return this._container;
        },

        onRemove: function (map) {
        },

        setButton: function (options) {
            var button = {
                'text': options.text,                 //string
                'iconUrl': options.iconUrl,           //string
                'onClick': options.onClick,           //callback function
                'hideText': !!options.hideText,         //forced bool
                'maxWidth': options.maxWidth || 70,     //number
                'doToggle': options.toggle,			//bool
                'toggleStatus': false					//bool
            };

            this._button = button;
            this._update();
        },

        getText: function () {
            return this._button.text;
        },

        getIconUrl: function () {
            return this._button.iconUrl;
        },

        destroy: function () {
            this._button = {};
            this._update();
        },

        toggle: function (e) {
            if(typeof e === 'boolean'){
                this._button.toggleStatus = e;
            }
            else{
                this._button.toggleStatus = !this._button.toggleStatus;
            }
            this._update();
        },

        _update: function () {
            if (!this._map) {
                return;
            }

            this._container.innerHTML = '';
            this._makeButton(this._button);

        },

        _makeButton: function (button) {
            var newButton = L.DomUtil.create('div', 'leaflet-buttons-control-button', this._container);
            if(button.toggleStatus)
                L.DomUtil.addClass(newButton,'leaflet-buttons-control-toggleon');

            var image = L.DomUtil.create('img', 'leaflet-buttons-control-img', newButton);
            image.setAttribute('src',button.iconUrl);

            if(button.text !== ''){

                L.DomUtil.create('br','',newButton);  //there must be a better way

                var span = L.DomUtil.create('span', 'leaflet-buttons-control-text', newButton);
                var text = document.createTextNode(button.text);  //is there an L.DomUtil for this?
                span.appendChild(text);
                if(button.hideText)
                    L.DomUtil.addClass(span,'leaflet-buttons-control-text-hide');
            }

            L.DomEvent
                .addListener(newButton, 'click', L.DomEvent.stop)
                .addListener(newButton, 'click', button.onClick,this)
                .addListener(newButton, 'click', this._clicked,this);
            L.DomEvent.disableClickPropagation(newButton);
            return newButton;

        },

        _clicked: function () {  //'this' refers to button
            if(this._button.doToggle){
                if(this._button.toggleStatus) {	//currently true, remove class
                    L.DomUtil.removeClass(this._container.childNodes[0],'leaflet-buttons-control-toggleon');
                }
                else{
                    L.DomUtil.addClass(this._container.childNodes[0],'leaflet-buttons-control-toggleon');
                }
                this.toggle();
            }
            return;
        }

    });
</script>
    <script>


        // "Some of the sounds in this project were created by David McKee (ViRiX)soundcloud.com/virix"
        var map = L.map('mapid').setView([31.505, 1.09], 7);
        L.tileLayer('https://api.tiles.mapbox.com/v4/{id}/{z}/{x}/{y}.png?access_token={accessToken}', {
            attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, <a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
            maxZoom: 18,
            id: 'mapbox.streets',
            accessToken: 'pk.eyJ1IjoiaXphZ2FuYW1pIiwiYSI6ImNrMzFoaGR2MjA4aGQzbHMydDFldnd4bmQifQ.LLsXS-A7H9SmXUjLQ0vfhg'
        }).addTo(map);
       /* document.getElementById('mapid').style.cursor = 'help';*/





        var markersarray=new Array();

        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {

            if (this.readyState == 4 && this.status == 200) {
                var myObj = JSON.parse(this.responseText);
                console.log(myObj.slice(0,-2))
                /*var LeafIcon = L.Icon.extend({
                    options: {
                        iconSize:     [38, 95],
                        shadowSize:   [50, 64],
                        iconAnchor:   [22, 94],
                        shadowAnchor: [4, 62],
                        popupAnchor:  [-3, -76]
                    }
                });
                var greenIcon = new LeafIcon({
                    iconUrl: 'http://leafletjs.com/examples/custom-icons/leaf-green.png',
                    shadowUrl: 'http://leafletjs.com/examples/custom-icons/leaf-shadow.png'
                })*/
                function fill()
                {
                    document.getElementById('tdd11').innerText=myObj[myObj.length-1].username;
                    document.getElementById('tdd12').innerText=myObj[myObj.length-1].score;
                    document.getElementById('tdd13').innerText=myObj[myObj.length-1].time;
                    document.getElementById('tdd21').innerText=myObj[myObj.length-2].username;
                    document.getElementById('tdd22').innerText=myObj[myObj.length-2].score;
                    document.getElementById('tdd23').innerText=myObj[myObj.length-2].time;
                }
                fill();

                var sound = new Howl({
                    src: [ 'assets/audio/FullScores/Orchestral Scores/Ove Melaa - Times.mp3'],
                    autoplay: true,
                    loop: true,
                    volume: 0.5,
                    onend: function() {

                    }
                });
                sound.play();

                //code ajouté


                var seconds = 0;
                function incrementSeconds() {
                    seconds += 1;
                }
                var cancel = setInterval(incrementSeconds, 1000);
                var customOptions =
                    {
                        'maxWidth': '400',
                        'width': '200',
                        'className' : 'popup3',
                    };


                //Quest les 4 enigmes :

                var enig_Quest=L.icon({
                                    iconUrl: './assets/images/icons/Quest/flags.png',

                                    iconSize:     [100, 100], // size of the icon
                                    iconAnchor:   [myObj[13].longitude, myObj[13].latitude], // point of the icon which will correspond to marker's location
                                    className: 'blinking'
                                    
                                });
                var Quest1 =L.marker([myObj[13].longitude, myObj[13].latitude], {icon: enig_Quest});

                var QuestIcon2 =L.icon({
                    iconUrl: './assets/images/icons/enigme3/tesla.png',

                    iconSize:     [90, 100], // size of the icon
                    iconAnchor:   [myObj[14].longitude, myObj[14].latitude], // point of the icon which will correspond to marker's location,
                    className: 'blinking'
                });
                var Quest2 = L.marker([myObj[14].longitude, myObj[14].latitude], {icon: enig_Quest});
                var Quest3 = L.marker([myObj[15].longitude, myObj[15].latitude], {icon: enig_Quest});
                var Quest4 = L.marker([myObj[16].longitude, myObj[16].latitude], {icon: enig_Quest});

                var QuestsArray = [Quest1,Quest3,Quest4];

                var Quests = new L.FeatureGroup();


                var j;
                for(j=13;j<16;j++)
                    {
                            if(myObj[j].minzoom == 10)
                                    {
                                        Quests.addLayer(QuestsArray[15-j]);
                                    }
                    }

                map.addLayer(Quests);
                map.addLayer(Quest2);

                var linkQuest1 = $('<a href="#" class="speciallink">'+myObj[14].hint+'</a>').click(function() {
                        document.getElementsByClassName("speech-bubble")[0].innerHTML='Enigme Afrique : Chercher le trésor ';
                        map.setView([20, 10], 7);
                        map.options.minZoom = 7;
                    })[0];
                Quest1.bindPopup(linkQuest1,customOptions).openPopup();

                var linkQuest2 = $('<a href="#" class="speciallink">'+myObj[15].hint+'</a>').click(function() {
                    document.getElementsByClassName("speech-bubble")[0].innerHTML='Enigme Amérique : tesla tour enigma';
                    map.setView([50,-100], 7);
                    map.options.minZoom = 7;

                })[0];
                Quest2.bindPopup(linkQuest2,customOptions).openPopup();

                var linkQuest3 = $('<a href="#" class="speciallink">'+myObj[14].hint+'</a>').click(function() {
                        document.getElementsByClassName("speech-bubble")[0].innerHTML='Enigme Asie : Chercher les bouquins pour ouvrir la porte';
                        map.setView([60, 63], 7);
                        map.options.minZoom = 7;
                    })[0];
                Quest3.bindPopup(linkQuest3,customOptions).openPopup();

                var linkQuest4 = $('<a href="#" class="speciallink">'+myObj[14].hint+'</a>').click(function() {
                        document.getElementsByClassName("speech-bubble")[0].innerHTML='Enigme Australie : Chercher les objets pour aller à Opéra House ';
                        map.setView([-20, 130], 7);
                        map.options.minZoom = 7;
                    })[0];
                Quest4.bindPopup(linkQuest4,customOptions).openPopup();

                //---------enigme1 sur l'afrique
                
                //les objets
                var enig1_puzzlePiece=L.icon({
                    iconUrl: './assets/images/icons/enigme1/Piecepuzzle.png',

                    iconSize:     [70, 70], // size of the icon
                    iconAnchor:   [myObj[0].longitude, myObj[0].latitude], // point of the icon which will correspond to marker's location
                    popupAnchor:  [10, -20] // point from which the popup should open relative to the iconAnchor
                });
                var MarkerEnigA0 =L.marker([myObj[0].longitude, myObj[0].latitude], {icon: enig1_puzzlePiece,draggable:true})
                markersarray.push(MarkerEnigA0);
                MarkerEnigA0.bindPopup("Déplace moi sur la carte").openPopup();
                //objet 01
                var enig1_puzzlePiece1=L.icon({
                    iconUrl: './assets/images/icons/enigme1/puzzle1.png',

                    iconSize:     [100, 100], // size of the icon
                    iconAnchor:   [myObj[1].longitude, myObj[1].latitude], // point of the icon which will correspond to marker's location
                    popupAnchor:  [10, -20] // point from which the popup should open relative to the iconAnchor
                });
                var MarkerEnigA01 =L.marker([myObj[1].longitude, myObj[1].latitude], {icon: enig1_puzzlePiece1})
                markersarray.push(MarkerEnigA01);
                MarkerEnigA01.bindPopup("Puzzle bloqué").openPopup();
                //objet2
                var enig1_puzzle=L.icon({
                    iconUrl: './assets/images/icons/enigme1/puzzle.png',

                    iconSize:     [100, 100], // size of the icon
                    iconAnchor:   [myObj[1].longitude, myObj[1].latitude], // point of the icon which will correspond to marker's location
                    popupAnchor:  [45, -20] // point from which the popup should open relative to the iconAnchor
                });
                var MarkerEnigA1 =L.marker([myObj[1].longitude, myObj[1].latitude], {icon: enig1_puzzle})
                markersarray.push(MarkerEnigA1);
                //objet3
                var enig1_QrCode=L.icon({
                    iconUrl: './assets/images/icons/enigme1/qr-code.png',

                    iconSize:     [50, 50], // size of the icon
                    iconAnchor:   [myObj[2].longitude, myObj[2].latitude], // point of the icon which will correspond to marker's location
                    popupAnchor:  [-10, -20] // point from which the popup should open relative to the iconAnchor
                });
                var MarkerEnigA2 =L.marker([myObj[2].longitude, myObj[2].latitude], {icon: enig1_QrCode});
                markersarray.push(MarkerEnigA2);
                //objet4
                var enig1_tele=L.icon({
                    iconUrl: './assets/images/icons/enigme1/security-code.png',

                    iconSize:     [90, 110], // size of the icon
                    iconAnchor:   [myObj[3].longitude, myObj[3].latitude], // point of the icon which will correspond to marker's location
                    popupAnchor:  [20, -20] // point from which the popup should open relative to the iconAnchor
                });
                var MarkerEnigA3 =L.marker([myObj[3].longitude, myObj[3].latitude], {icon: enig1_tele});
                markersarray.push(MarkerEnigA3);
                MarkerEnigA3.bindPopup("Télephone bloqué par un code Qr").openPopup();
                //objet5
                var enig1_house=L.icon({
                    iconUrl: './assets/images/icons/enigme1/house.png',

                    iconSize:     [120, 120], // size of the icon
                    iconAnchor:   [myObj[4].longitude, myObj[4].latitude], // point of the icon which will correspond to marker's location
                    popupAnchor:  [10, -20] // point from which the popup should open relative to the iconAnchor
                });
                var MarkerEnigA4 =L.marker([myObj[4].longitude, myObj[4].latitude], {icon: enig1_house});
                markersarray.push(MarkerEnigA4);
                MarkerEnigA4.bindPopup("La maison est bloquée par la clé").openPopup();
                //objet6
                var enig1_key=L.icon({
                    iconUrl: './assets/images/icons/enigme1/key.png',

                    iconSize:     [50, 50], // size of the icon
                    iconAnchor:   [myObj[5].longitude, myObj[5].latitude], // point of the icon which will correspond to marker's location
                    popupAnchor:  [-3, -20] // point from which the popup should open relative to the iconAnchor
                });
                var MarkerEnigA5 =L.marker([myObj[5].longitude, myObj[5].latitude], {icon: enig1_key,draggable:true});
                markersarray.push(MarkerEnigA5);
                MarkerEnigA5.bindPopup("Déplace moi sur la carte").openPopup();
                //objet7
                var enig1_binaryCode=L.icon({
                    iconUrl: './assets/images/icons/enigme1/binary-code.png',

                    iconSize:     [70, 70], // size of the icon
                    iconAnchor:   [myObj[6].longitude, myObj[6].latitude], // point of the icon which will correspond to marker's location
                    popupAnchor:  [-3, -10] // point from which the popup should open relative to the iconAnchor
                });
                var MarkerEnigA6 =L.marker([myObj[6].longitude, myObj[6].latitude], {icon: enig1_binaryCode});
                markersarray.push(MarkerEnigA6);
                //objet8
                var enig1_pc=L.icon({
                    iconUrl: './assets/images/icons/enigme1/pc.png',

                    iconSize:     [90, 90], // size of the icon
                    iconAnchor:   [myObj[7].longitude, myObj[7].latitude], // point of the icon which will correspond to marker's location
                    popupAnchor:  [-3, -5] // point from which the popup should open relative to the iconAnchor
                });
                var MarkerEnigA7 =L.marker([myObj[7].longitude, myObj[7].latitude], {icon: enig1_pc});
                markersarray.push(MarkerEnigA7);
                //objet9
                var enig1_pyramid=L.icon({
                    iconUrl: './assets/images/icons/enigme1/pyramid.png',

                    iconSize:     [80, 80], // size of the icon
                    iconAnchor:   [myObj[8].longitude, myObj[8].latitude], // point of the icon which will correspond to marker's location
                    popupAnchor:  [-20, -20] // point from which the popup should open relative to the iconAnchor
                });
                var MarkerEnigA8 =L.marker([myObj[8].longitude, myObj[8].latitude], {icon: enig1_pyramid});
                markersarray.push(MarkerEnigA8);
                MarkerEnigA8.bindPopup("Creuser pour récuperer la clé").openPopup();
                //objet10
                var enig1_shovel=L.icon({
                    iconUrl: './assets/images/icons/enigme1/shovel.png',

                    iconSize:     [80, 80], // size of the icon
                    iconAnchor:   [myObj[9].longitude, myObj[9].latitude], // point of the icon which will correspond to marker's location
                    popupAnchor:  [-3, -76] // point from which the popup should open relative to the iconAnchor
                });
                var MarkerEnigA9 =L.marker([myObj[9].longitude, myObj[9].latitude], {icon: enig1_shovel,draggable:true});
                markersarray.push(MarkerEnigA9);
                MarkerEnigA9.bindPopup("Déplace moi sur la carte").openPopup();
                //objet11
                var enig1_treasure=L.icon({
                    iconUrl: './assets/images/icons/enigme1/chest.png',

                    iconSize:     [80, 80], // size of the icon
                    iconAnchor:   [myObj[10].longitude, myObj[10].latitude], // point of the icon which will correspond to marker's location
                    popupAnchor:  [-3, -76] // point from which the popup should open relative to the iconAnchor
                });
                var MarkerEnigA10 =L.marker([myObj[10].longitude, myObj[10].latitude], {icon: enig1_treasure});
                markersarray.push(MarkerEnigA10);
                MarkerEnigA10.bindPopup("Trésor fermé").openPopup();
                //objet12
                var enig1_treasureKey=L.icon({
                    iconUrl: './assets/images/icons/enigme1/treasure-keys.png',

                    iconSize:     [80, 80], // size of the icon
                    iconAnchor:   [myObj[11].longitude, myObj[11].latitude], // point of the icon which will correspond to marker's location
                    popupAnchor:  [-3, -76] // point from which the popup should open relative to the iconAnchor
                });
                var MarkerEnigA11 =L.marker([myObj[11].longitude, myObj[11].latitude], {icon: enig1_treasureKey,draggable:true});
                markersarray.push(MarkerEnigA11);
                MarkerEnigA11.bindPopup("Déplace moi sur la carte").openPopup();
                //objet13
                var enig1_treasureOpened=L.icon({
                    iconUrl: './assets/images/icons/enigme1/treasure.png',

                    iconSize:     [80, 80], // size of the icon
                    iconAnchor:   [myObj[12].longitude, myObj[12].latitude], // point of the icon which will correspond to marker's location
                    popupAnchor:  [-3, -76] // point from which the popup should open relative to the iconAnchor
                });
                var MarkerEnigA12 =L.marker([myObj[12].longitude, myObj[12].latitude], {icon: enig1_treasureOpened});
                markersarray.push(MarkerEnigA12);


                
                //------Régler le zoom
                var Enigm1Group = new L.FeatureGroup();
                Enigm1Group.addLayer(MarkerEnigA0);
                Enigm1Group.addLayer(MarkerEnigA01);
                map.on('zoomend', function() {
                    if (map.getZoom() <7){
                            map.removeLayer(Enigm1Group);
                    }
                    else {
                            map.addLayer(Enigm1Group);
                        }
                });
            

                //enigme1

                MarkerEnigA0.on('dragend',function(x)
                {
                    if(MarkerEnigA0.getLatLng().lat<MarkerEnigA01.getLatLng().lat+0.5 && MarkerEnigA0.getLatLng().lat>MarkerEnigA01.getLatLng().lat-0.5 && MarkerEnigA0.getLatLng().lng<MarkerEnigA01.getLatLng().lng+0.5 && MarkerEnigA0.getLatLng().lng>MarkerEnigA01.getLatLng().lng-0.5)
                    {

                        map.removeLayer(MarkerEnigA0);
                        map.removeLayer(MarkerEnigA01);
                        map.addLayer(MarkerEnigA1)
                        cart = ' pièce de puzzle ajoutée ';
                        score += 70;
                        code='---';
                        indice='---';
                        document.getElementsByClassName('my-control')[0].innerHTML='Score: ' +score +'<br>'+'  time: '+ '<span id=seconds>'+ seconds+'</span>'+'<br>' +' cart: ' + cart +'<br>'+'code récupéré:  '+code+'<br>'+'indice:  '+indice;
                        var sound = new Howl({
                            src: [ 'assets/audio/Drums/Clunky Kit Samples/snare-big.wav'],
                            autoplay: true,
                            loop: false,
                            volume: 0.5,
                            onend: function() {

                            }
                        });
                        sound.play();


                        var linkObjt2 = $('<a href="#" class="speciallink">'+myObj[1].hint+'</a>').click(function() {
                            map.removeLayer(MarkerEnigA1);
                            cart = 'puzzle ajouté';
                            score += 110;
                            code='---';
                            indice='le puzzle reformé est un code Qr';
                            document.getElementsByClassName('my-control')[0].innerHTML='Score: ' +score +'<br>'+'  time: '+ '<span id=seconds>'+ seconds+'</span>'+'<br>' +' cart: ' + cart +'<br>'+'code récupéré:  '+code+'<br>'+'indice:  '+indice;
                            var sound = new Howl({
                                src: [ 'assets/audio/Drums/Clunky Kit Samples/snare-big.wav'],
                                autoplay: true,
                                loop: false,
                                volume: 0.5,
                                onend: function() {

                                }
                            });
                            sound.play();

                        })[0];
                        MarkerEnigA1.bindPopup(linkObjt2 ,customOptions).openPopup();
                        map.addLayer(MarkerEnigA2);
                        map.addLayer(MarkerEnigA3);

                    }
                });


                var linkObj3 = $('<a href="#" class="speciallink">'+myObj[2].hint+'</a>').click(function() {
                    map.removeLayer(MarkerEnigA2);
                    cart = 'code Qr ajouté';
                    score += 100;
                    code='Name: Titi / PassWord : 1234567';
                    indice='---';
                    document.getElementsByClassName('my-control')[0].innerHTML='Score: ' +score +'<br>'+'  time: '+ '<span id=seconds>'+ seconds+'</span>'+'<br>' +' cart: ' + cart +'<br>'+'code récupéré:  '+code+'<br>'+'indice:  '+indice;
                    var sound = new Howl({
                        src: [ 'assets/audio/Drums/Clunky Kit Samples/snare-big.wav'],
                        autoplay: true,
                        loop: false,
                        volume: 0.5,
                        onend: function() {

                        }
                    });
                    sound.play();

                })[0];
                MarkerEnigA2.bindPopup(linkObj3,customOptions).openPopup();


                var linkObj4 = $('<form  method="get" id="form1">'+'<label>Nom : </label>'+'<input type="text" id="nom" name="nom" required minlength="4" maxlength="5" size="20">'+'<br>'+'<label>Mot de passe :</label>'+'<input type="text" id="password" name="password" required minlength="7" maxlength="8" size="20">'+'<br>'+'<input type="submit" value="Ouvrir">'+'</form>').submit(function(e) {
                    var pass = document.getElementsByName("password")[0].value;
                    var nom = document.getElementsByName("nom")[0].value;
                    e.preventDefault();
                    if(pass=='1234567' && nom=='Titi')
                    {
                        map.removeLayer(MarkerEnigA3);
                        score += 240;
                        cart="Télephone ajouté";
                        code='---';
                        indice='localisation sur le Gabon';
                        document.getElementsByClassName('my-control')[0].innerHTML='Score: ' +score +'<br>'+'  time: '+ '<span id=seconds>'+ seconds+'</span>'+'<br>' +' cart: ' + cart +'<br>'+'code récupéré:  '+code+'<br>'+'indice:  '+indice;
                        var sound = new Howl({
                            src: [ 'assets/audio/Drums/Clunky Kit Samples/snare-big.wav'],
                            autoplay: true,
                            loop: false,
                            volume: 0.5,
                            onend: function() {

                            }
                        });
                        sound.play();
                        map.addLayer(MarkerEnigA4);
                        map.addLayer(MarkerEnigA5);
                    }
                })[0];
                MarkerEnigA3.bindPopup(linkObj4,customOptions).openPopup();


                MarkerEnigA5.on('dragend',function(x)
                {
                    if(MarkerEnigA5.getLatLng().lat<MarkerEnigA4.getLatLng().lat+0.9 && MarkerEnigA5.getLatLng().lat>MarkerEnigA4.getLatLng().lat-0.9 && MarkerEnigA5.getLatLng().lng<MarkerEnigA4.getLatLng().lng+0.9 && MarkerEnigA5.getLatLng().lng>MarkerEnigA4.getLatLng().lng-0.9)
                    {
                        map.removeLayer(MarkerEnigA5);
                        cart = 'Clé ajouté ';
                        score += 170;
                        code='---';
                        indice='---';
                        document.getElementsByClassName('my-control')[0].innerHTML='Score: ' +score +'<br>'+'  time: '+ '<span id=seconds>'+ seconds+'</span>'+'<br>' +' cart: ' + cart +'<br>'+'code récupéré:  '+code+'<br>'+'indice:  '+indice;
                        var sound = new Howl({
                            src: [ 'assets/audio/Drums/Clunky Kit Samples/snare-big.wav'],
                            autoplay: true,
                            loop: false,
                            volume: 0.5,
                            onend: function() {

                            }
                        });
                        sound.play();
                        var linkObj5 = $('<a href="#" class="speciallink">'+myObj[4].hint+'</a>').click(function() {
                            cart = 'Maison débloqué';
                            score += 370;
                            code='---';
                            indice='Cherche un code';
                            document.getElementsByClassName('my-control')[0].innerHTML='Score: ' +score +'<br>'+'  time: '+ '<span id=seconds>'+ seconds+'</span>'+'<br>' +' cart: ' + cart +'<br>'+'code récupéré:  '+code+'<br>'+'indice:  '+indice;
                            var sound = new Howl({
                                src: [ 'assets/audio/Drums/Clunky Kit Samples/snare-big.wav'],
                                autoplay: true,
                                loop: false,
                                volume: 0.5,
                                onend: function() {

                                }
                            });
                            sound.play();

                        })[0];
                        MarkerEnigA4.bindPopup(linkObj5,customOptions).openPopup();

                        map.addLayer(MarkerEnigA6);
                        map.addLayer(MarkerEnigA7);

                    }
                });


                var linkObj6 = $('<a href="#" class="speciallink">'+myObj[6].hint+'</a>').click(function() {
                    map.removeLayer(MarkerEnigA6);
                    cart = 'Code binaire ajouté';
                    score += 370;
                    code='01110';
                    indice='---';
                    document.getElementsByClassName('my-control')[0].innerHTML='Score: ' +score +'<br>'+'  time: '+ '<span id=seconds>'+ seconds+'</span>'+'<br>' +' cart: ' + cart +'<br>'+'code récupéré:  '+code+'<br>'+'indice:  '+indice;
                    var sound = new Howl({
                        src: [ 'assets/audio/Drums/Clunky Kit Samples/snare-big.wav'],
                        autoplay: true,
                        loop: false,
                        volume: 0.5,
                        onend: function() {

                        }
                    });
                    sound.play();

                })[0];
                MarkerEnigA6.bindPopup(linkObj6,customOptions).openPopup();


                var linkObj7 = $('<form  method="get" id="form1">'+'<label>Code binaire : </label>'+'<input type="text" id="code" name="code" required minlength="5" maxlength="6" size="20">'+'<br>'+'<input type="submit" value="Décoder">'+'</form>').submit(function(e) {
                    var code = document.getElementsByName("code")[0].value;
                    e.preventDefault();
                    if(code =='01110')
                    {
                        map.removeLayer(MarkerEnigA7);
                        score += 570;
                        cart ="Ordinateur ajouté";
                        code='---';
                        indice="Les pyramides d'Égypte";
                        document.getElementsByClassName('my-control')[0].innerHTML='Score: ' +score +'<br>'+'  time: '+ '<span id=seconds>'+ seconds+'</span>'+'<br>' +' cart: ' + cart +'<br>'+'code récupéré:  '+code+'<br>'+'indice:  '+indice;
                        var sound = new Howl({
                            src: [ 'assets/audio/Drums/Clunky Kit Samples/snare-big.wav'],
                            autoplay: true,
                            loop: false,
                            volume: 0.5,
                            onend: function() {

                            }
                        });
                        sound.play();

                        map.addLayer(MarkerEnigA8);
                        map.addLayer(MarkerEnigA9);
                    }
                })[0];
                MarkerEnigA7.bindPopup(linkObj7,customOptions).openPopup();



                MarkerEnigA9.on('dragend',function(x)
                {
                    if(MarkerEnigA9.getLatLng().lat<MarkerEnigA8.getLatLng().lat+0.3 && MarkerEnigA9.getLatLng().lat>MarkerEnigA8.getLatLng().lat-0.3 && MarkerEnigA9.getLatLng().lng<MarkerEnigA8.getLatLng().lng+0.3 && MarkerEnigA9.getLatLng().lng>MarkerEnigA8.getLatLng().lng-0.3)
                    {
                        map.removeLayer(MarkerEnigA9);
                        score += 170;
                        cart ="pelle ajoutée";
                        code='---';
                        indice="Clé retrouvée";
                        document.getElementsByClassName('my-control')[0].innerHTML='Score: ' +score +'<br>'+'  time: '+ '<span id=seconds>'+ seconds+'</span>'+'<br>' +' cart: ' + cart +'<br>'+'code récupéré:  '+code+'<br>'+'indice:  '+indice;
                        var sound = new Howl({
                            src: [ 'assets/audio/Drums/Clunky Kit Samples/snare-big.wav'],
                            autoplay: true,
                            loop: false,
                            volume: 0.5,
                            onend: function() {

                            }
                        });
                        sound.play();
                        map.addLayer(MarkerEnigA10);
                        map.addLayer(MarkerEnigA11);


                    }
                });

                MarkerEnigA11.on('dragend',function(x)
                {
                    if(MarkerEnigA11.getLatLng().lat<MarkerEnigA10.getLatLng().lat+0.3 && MarkerEnigA11.getLatLng().lat>MarkerEnigA10.getLatLng().lat-0.3 && MarkerEnigA11.getLatLng().lng<MarkerEnigA10.getLatLng().lng+0.3 && MarkerEnigA11.getLatLng().lng>MarkerEnigA10.getLatLng().lng-0.3)
                    {
                        map.removeLayer(MarkerEnigA10);
                        map.removeLayer(MarkerEnigA11);
                        score += 170;
                        cart ="Clé ajoutée";
                        code='---';
                        indice="---";
                        document.getElementsByClassName('my-control')[0].innerHTML='Score: ' +score +'<br>'+'  time: '+ '<span id=seconds>'+ seconds+'</span>'+'<br>' +' cart: ' + cart +'<br>'+'code récupéré:  '+code+'<br>'+'indice:  '+indice;
                        var sound = new Howl({
                            src: [ 'assets/audio/Drums/Clunky Kit Samples/snare-big.wav'],
                            autoplay: true,
                            loop: false,
                            volume: 0.5,
                            onend: function() {

                            }
                        });
                        sound.play();
                        map.addLayer(MarkerEnigA12);

                    }
                });

                var linkObj12 = $('<a href="#" class="speciallink">'+"Congrats"+'</a>').click(function() {
                    map.removeLayer(MarkerEnigA1);
                    map.removeLayer(MarkerEnigA01);
                    map.removeLayer(MarkerEnigA2);
                    map.removeLayer(MarkerEnigA3);
                    map.removeLayer(MarkerEnigA4);
                    map.removeLayer(MarkerEnigA5);
                    map.removeLayer(MarkerEnigA6);
                    map.removeLayer(MarkerEnigA7);
                    map.removeLayer(MarkerEnigA8);
                    map.removeLayer(MarkerEnigA9);
                    map.removeLayer(MarkerEnigA10);
                    map.removeLayer(MarkerEnigA11);
                    map.removeLayer(MarkerEnigA12);
                    map.removeLayer(Quest1)
                    Enigm1Group.clearLayers();

                    console.log('Supprimer les couches')
                    score += 1190;
                    cart="Enigme Afrique résolue";
                    code='---';
                    indice="---";
                    document.getElementsByClassName('my-control')[0].innerHTML='Score: ' +score +'<br>'+'  time: '+ '<span id=seconds>'+ seconds+'</span>'+'<br>' +' cart: ' + cart +'<br>'+'code récupéré:  '+code+'<br>'+'indice:  '+indice;
                    var sound = new Howl({
                        src: [ 'assets/audio/Drums/Clunky Kit Samples/snare-big.wav'],
                        autoplay: true,
                        loop: false,
                        volume: 0.5,
                        onend: function() {

                        }
                    });
                    sound.play();

                    document.getElementsByClassName("speech-bubble")[0].innerHTML='<p>Félicitations ! Enigme Afrique résolue </p>';
                    map.setView([20, 10], 2);
                    map.options.minZoom = 2;

                })[0];
                MarkerEnigA12.bindPopup(linkObj12).openPopup();


                //enigme 4  sur l'australie 

                //objet1
                var enig4_herbe=L.icon({
                        iconUrl: './assets/images/icons/enigme4/hay.png',

                        iconSize:     [70, 70], // size of the icon
                        iconAnchor:   [myObj[39].longitude, myObj[39].latitude], // point of the icon which will correspond to marker's location
                        popupAnchor:  [60, -150] // point from which the popup should open relative to the iconAnchor
                    });
                var MarkerEnigB1 =L.marker([myObj[39].longitude, myObj[39].latitude], {icon:enig4_herbe ,draggable:true});
                markersarray.push(MarkerEnigB1);

                MarkerEnigB1.bindPopup("Déplace moi sur la carte").openPopup();
                
                /// objet12
                var enig4_kangaroo1=L.icon({
                        iconUrl: './assets/images/icons/enigme4/kangaroo-1.png',

                        iconSize:     [80, 80], // size of the icon
                        iconAnchor:   [myObj[40].longitude, myObj[40].latitude], // point of the icon which will correspond to marker's location
                        popupAnchor:  [60, -150] // point from which the popup should open relative to the iconAnchor
                    });
                var MarkerEnigB12 =L.marker([myObj[40].longitude, myObj[40].latitude], {icon:enig4_kangaroo1});
                markersarray.push(MarkerEnigB12);

                MarkerEnigB12.bindPopup("le Kangaroo a faim").openPopup();
                
                //objet2
                var enig4_kangaroo2=L.icon({
                        iconUrl: './assets/images/icons/enigme4/kangaroo-2.png',

                        iconSize:     [80, 80], // size of the icon
                        iconAnchor:   [myObj[40].longitude, myObj[40].latitude], // point of the icon which will correspond to marker's location
                        popupAnchor:  [60, -150] // point from which the popup should open relative to the iconAnchor
                    });
                var MarkerEnigB2 =L.marker([myObj[40].longitude, myObj[40].latitude], {icon:enig4_kangaroo2});
                markersarray.push(MarkerEnigB2);

                MarkerEnigB2.bindPopup("Merci pour votre aide ! récompense").openPopup();
                
                //objet3
                var enig4_koala1=L.icon({
                        iconUrl: './assets/images/icons/enigme4/koala.png',

                        iconSize:     [80, 80], // size of the icon
                        iconAnchor:   [myObj[41].longitude, myObj[41].latitude], // point of the icon which will correspond to marker's location
                        popupAnchor:  [60, -150] // point from which the popup should open relative to the iconAnchor
                    });
                var MarkerEnigB3 =L.marker([myObj[42].longitude, myObj[41].latitude], {icon:enig4_koala1 ,draggable:true});
                markersarray.push(MarkerEnigB3);

                MarkerEnigB3.bindPopup("Le koala veut revenir à la forêt").openPopup();
                
                /// objet34
                var enig4_koala2=L.icon({
                        iconUrl: './assets/images/icons/enigme4/koala-1.png',

                        iconSize:     [70, 70], // size of the icon
                        iconAnchor:   [myObj[42].longitude, myObj[42].latitude], // point of the icon which will correspond to marker's location
                        popupAnchor:  [60, -150] // point from which the popup should open relative to the iconAnchor
                    });
                var MarkerEnigB34 =L.marker([myObj[42].longitude, myObj[42].latitude], {icon:enig4_koala2});
                markersarray.push(MarkerEnigB34);
                
                //objet4
                var enig4_foret=L.icon({
                        iconUrl: './assets/images/icons/enigme4/trees.png',

                        iconSize:     [110, 110], // size of the icon
                        iconAnchor:   [myObj[42].longitude, myObj[42].latitude], // point of the icon which will correspond to marker's location
                        popupAnchor:  [60, -150] // point from which the popup should open relative to the iconAnchor
                    });
                var MarkerEnigB4 =L.marker([myObj[42].longitude, myObj[42].latitude], {icon:enig4_foret });
                markersarray.push(MarkerEnigB4);

                MarkerEnigB4.bindPopup("Forêt").openPopup();
                
                //objet5
                var enig4_money1=L.icon({
                        iconUrl: './assets/images/icons/enigme4/money.png',

                        iconSize:     [70, 70], // size of the icon
                        iconAnchor:   [myObj[43].longitude, myObj[43].latitude], // point of the icon which will correspond to marker's location
                        popupAnchor:  [60, -150] // point from which the popup should open relative to the iconAnchor
                    });
                var MarkerEnigB5 =L.marker([myObj[43].longitude, myObj[43].latitude], {icon:enig4_money1 ,draggable:true});
                markersarray.push(MarkerEnigB5);

                MarkerEnigB5.bindPopup("Récompense").openPopup();
                
                //objet6
                var enig4_money2=L.icon({
                        iconUrl: './assets/images/icons/enigme4/dollar.png',

                        iconSize:     [60, 60], // size of the icon
                        iconAnchor:   [myObj[44].longitude, myObj[44].latitude], // point of the icon which will correspond to marker's location
                        popupAnchor:  [60, -150] // point from which the popup should open relative to the iconAnchor
                    });
                var MarkerEnigB6 =L.marker([myObj[44].longitude, myObj[44].latitude], {icon:enig4_money2 ,draggable:true});
                markersarray.push(MarkerEnigB6);

                MarkerEnigB6.bindPopup("Récompense").openPopup();

                //objet7
                var enig4_moneyBag=L.icon({
                        iconUrl: './assets/images/icons/enigme4/money-bag.png',

                        iconSize:     [70, 70], // size of the icon
                        iconAnchor:   [myObj[45].longitude, myObj[45].latitude], // point of the icon which will correspond to marker's location
                        popupAnchor:  [60, -150] // point from which the popup should open relative to the iconAnchor
                    });
                var MarkerEnigB7 =L.marker([myObj[45].longitude, myObj[45].latitude], {icon:enig4_moneyBag});
                markersarray.push(MarkerEnigB7);

                MarkerEnigB7.bindPopup("money bag bloqué on doit le remplir ").openPopup();

                //objet8
                var enig4_vendingMachine=L.icon({
                        iconUrl: './assets/images/icons/enigme4/vending-machine.png',

                        iconSize:     [120, 120], // size of the icon
                        iconAnchor:   [myObj[46].longitude, myObj[46].latitude], // point of the icon which will correspond to marker's location
                        popupAnchor:  [60, -150] // point from which the popup should open relative to the iconAnchor
                    });
                var MarkerEnigB8 =L.marker([myObj[46].longitude, myObj[46].latitude], {icon:enig4_vendingMachine});
                markersarray.push(MarkerEnigB8);

                MarkerEnigB8.bindPopup("machine des tickets").openPopup();
                
                //objet9
                var enig4_ticket=L.icon({
                        iconUrl: './assets/images/icons/enigme4/ticket.png',

                        iconSize:     [60, 60], // size of the icon
                        iconAnchor:   [myObj[47].longitude, myObj[47].latitude], // point of the icon which will correspond to marker's location
                        popupAnchor:  [60, -150] // point from which the popup should open relative to the iconAnchor
                    });
                var MarkerEnigB9 =L.marker([myObj[47].longitude, myObj[47].latitude], {icon:enig4_ticket, draggable:true });
                markersarray.push(MarkerEnigB9);

                MarkerEnigB9.bindPopup("Ticket").openPopup();
                
                //objet10
                var enig4_train=L.icon({
                        iconUrl: './assets/images/icons/enigme4/tramway.png',

                        iconSize:     [100, 170], // size of the icon
                        iconAnchor:   [myObj[48].longitude, myObj[48].latitude], // point of the icon which will correspond to marker's location
                        popupAnchor:  [60, -150] // point from which the popup should open relative to the iconAnchor
                    });
                var MarkerEnigB10 =L.marker([myObj[48].longitude, myObj[48].latitude], {icon:enig4_train });
                markersarray.push(MarkerEnigB10);

                MarkerEnigB10.bindPopup("train").openPopup();

                 //objet11
                var enig4_opera=L.icon({
                        iconUrl: './assets/images/icons/enigme4/sydney-opera-house.png',

                        iconSize:     [140, 140], // size of the icon
                        iconAnchor:   [myObj[49].longitude, myObj[49].latitude], // point of the icon which will correspond to marker's location
                        popupAnchor:  [60, -150] // point from which the popup should open relative to the iconAnchor
                    });
                var MarkerEnigB11 =L.marker([myObj[49].longitude, myObj[49].latitude], {icon:enig4_opera});
                markersarray.push(MarkerEnigB11);

                MarkerEnigB11.bindPopup("sydney opera house").openPopup();

                //------Régler le zoom enigme4
                var zoomEnig4=1
                if(zoomEnig4==1){
                    var Enigm4Group = new L.FeatureGroup();
                    Enigm1Group.addLayer(MarkerEnigB1);
                    Enigm1Group.addLayer(MarkerEnigB12);
                    map.on('zoomend', function() {
                        if (map.getZoom() <7){
                                map.removeLayer(Enigm4Group);
                        }
                        else {
                                map.addLayer(Enigm4Group);
                            }
                    });
                }
                

                //Event enigme4


                MarkerEnigB1.on('dragend',function(x){
                    if(MarkerEnigB12.getLatLng().lat<MarkerEnigB1.getLatLng().lat+0.5 && MarkerEnigB12.getLatLng().lat>MarkerEnigB1.getLatLng().lat-0.5 && MarkerEnigB12.getLatLng().lng<MarkerEnigB1.getLatLng().lng+0.5 && MarkerEnigB12.getLatLng().lng>MarkerEnigB1.getLatLng().lng-0.5)
                    {
                        map.removeLayer(MarkerEnigB1);
                        map.removeLayer(MarkerEnigB12);
                        map.addLayer(MarkerEnigB2);
                        score += 170;
                        cart ="herbes ajouté";
                        code='---';
                        indice="---";
                        document.getElementsByClassName('my-control')[0].innerHTML='Score: ' +score +'<br>'+'  time: '+ '<span id=seconds>'+ seconds+'</span>'+'<br>' +' cart: ' + cart +'<br>'+'code récupéré:  '+code+'<br>'+'indice:  '+indice;
                        var sound = new Howl({
                                src: [ 'assets/audio/Drums/Clunky Kit Samples/snare-big.wav'],
                                autoplay: true,
                                loop: false,
                                volume: 0.5,
                                onend: function() {

                                }
                            });
                            sound.play();

                        var link4Objt1 = $('<a href="#" class="speciallink">'+myObj[40].hint+'</a>').click(function() {
                        map.removeLayer(MarkerEnigA1);
                        cart = 'kangaroo ajouté';
                        score += 110;
                        code='---';
                        indice='récompense à chercher sur la map';
                        document.getElementsByClassName('my-control')[0].innerHTML='Score: ' +score +'<br>'+'  time: '+ '<span id=seconds>'+ seconds+'</span>'+'<br>' +' cart: ' + cart +'<br>'+'code récupéré:  '+code+'<br>'+'indice:  '+indice;
                        var sound = new Howl({
                            src: [ 'assets/audio/Drums/Clunky Kit Samples/snare-big.wav'],
                            autoplay: true,
                            loop: false,
                            volume: 0.5,
                            onend: function() {

                            }
                        });
                        sound.play();

                        map.removeLayer(MarkerEnigB2);
                        map.addLayer(MarkerEnigB5);
                        map.addLayer(MarkerEnigB7);

                     })[0];
                        MarkerEnigB2.bindPopup(link4Objt1 ,customOptions).openPopup();
                        
            
                    }
                });


                MarkerEnigB5.on('dragend',function(x){
                    if(MarkerEnigB7.getLatLng().lat<MarkerEnigB5.getLatLng().lat+0.5 && MarkerEnigB7.getLatLng().lat>MarkerEnigB5.getLatLng().lat-0.5 && MarkerEnigB7.getLatLng().lng<MarkerEnigB5.getLatLng().lng+0.5 && MarkerEnigB7.getLatLng().lng>MarkerEnigB5.getLatLng().lng-0.5)
                    {
                        
                        map.removeLayer(MarkerEnigB5);
                        score += 250;
                        cart ="argent ajouté";
                        code='---';
                        indice="---";
                        document.getElementsByClassName('my-control')[0].innerHTML='Score: ' +score +'<br>'+'  time: '+ '<span id=seconds>'+ seconds+'</span>'+'<br>' +' cart: ' + cart +'<br>'+'code récupéré:  '+code+'<br>'+'indice:  '+indice;
                        var sound = new Howl({
                                src: [ 'assets/audio/Drums/Clunky Kit Samples/snare-big.wav'],
                                autoplay: true,
                                loop: false,
                                volume: 0.5,
                                onend: function() {

                                }
                            });
                            sound.play();
                        MarkerEnigB7.bindPopup("On a besoin d'autre argent pour débloquer l'objet" ,customOptions).openPopup();
                        map.addLayer(MarkerEnigB3);
                        map.addLayer(MarkerEnigB4);

                    }
                });

                MarkerEnigB3.on('dragend',function(x){
                    if(MarkerEnigB4.getLatLng().lat<MarkerEnigB3.getLatLng().lat+0.3 && MarkerEnigB4.getLatLng().lat>MarkerEnigB3.getLatLng().lat-0.3 && MarkerEnigB4.getLatLng().lng<MarkerEnigB3.getLatLng().lng+0.3 && MarkerEnigB4.getLatLng().lng>MarkerEnigB3.getLatLng().lng-0.3)
                    {
                        
                        map.removeLayer(MarkerEnigB3);
                        map.removeLayer(MarkerEnigB4);
                        map.addLayer(MarkerEnigB34);
                        score += 350;
                        cart ="Koala ajouté";
                        code='---';
                        indice="---";
                        document.getElementsByClassName('my-control')[0].innerHTML='Score: ' +score +'<br>'+'  time: '+ '<span id=seconds>'+ seconds+'</span>'+'<br>' +' cart: ' + cart +'<br>'+'code récupéré:  '+code+'<br>'+'indice:  '+indice;
                        var sound = new Howl({
                                src: [ 'assets/audio/Drums/Clunky Kit Samples/snare-big.wav'],
                                autoplay: true,
                                loop: false,
                                volume: 0.5,
                                onend: function() {

                                }
                            });
                            sound.play();

                        var link4Objt2 = $('<a href="#" class="speciallink">'+myObj[41].hint+'</a>').click(function() {
                        map.removeLayer(MarkerEnigA1);
                        cart = 'koala ajouté';
                        score += 220;
                        code='---';
                        indice='récompense à chercher sur la map';
                        document.getElementsByClassName('my-control')[0].innerHTML='Score: ' +score +'<br>'+'  time: '+ '<span id=seconds>'+ seconds+'</span>'+'<br>' +' cart: ' + cart +'<br>'+'code récupéré:  '+code+'<br>'+'indice:  '+indice;
                        var sound = new Howl({
                            src: [ 'assets/audio/Drums/Clunky Kit Samples/snare-big.wav'],
                            autoplay: true,
                            loop: false,
                            volume: 0.5,
                            onend: function() {

                            }
                        });
                        sound.play();

                        map.removeLayer(MarkerEnigB34);
                        map.addLayer(MarkerEnigB6);


                     })[0];
                        MarkerEnigB34.bindPopup(link4Objt2 ,customOptions).openPopup();

                    }
                });

                MarkerEnigB6.on('dragend',function(x){
                    if(MarkerEnigB7.getLatLng().lat<MarkerEnigB6.getLatLng().lat+0.3 && MarkerEnigB7.getLatLng().lat>MarkerEnigB6.getLatLng().lat-0.3 && MarkerEnigB7.getLatLng().lng<MarkerEnigB6.getLatLng().lng+0.3 && MarkerEnigB7.getLatLng().lng>MarkerEnigB6.getLatLng().lng-0.3)
                    {
                        
                        map.removeLayer(MarkerEnigB6);
                        score += 270;
                        cart ="argent ajouté";
                        code='---';
                        indice="---";
                        document.getElementsByClassName('my-control')[0].innerHTML='Score: ' +score +'<br>'+'  time: '+ '<span id=seconds>'+ seconds+'</span>'+'<br>' +' cart: ' + cart +'<br>'+'code récupéré:  '+code+'<br>'+'indice:  '+indice;
                        var sound = new Howl({
                                src: [ 'assets/audio/Drums/Clunky Kit Samples/snare-big.wav'],
                                autoplay: true,
                                loop: false,
                                volume: 0.5,
                                onend: function() {

                                }
                            });
                            sound.play();

                        var link4Objt3 = $('<a href="#" class="speciallink">'+myObj[45].hint+'</a>').click(function() {
                        cart = 'money bag débloqué';
                        score += 220;
                        code='---';
                        indice='---';
                        document.getElementsByClassName('my-control')[0].innerHTML='Score: ' +score +'<br>'+'  time: '+ '<span id=seconds>'+ seconds+'</span>'+'<br>' +' cart: ' + cart +'<br>'+'code récupéré:  '+code+'<br>'+'indice:  '+indice;
                        var sound = new Howl({
                            src: [ 'assets/audio/Drums/Clunky Kit Samples/snare-big.wav'],
                            autoplay: true,
                            loop: false,
                            volume: 0.5,
                            onend: function() {

                            }
                        });
                        sound.play();

                        MarkerEnigB7.dragging.enable();
                        MarkerEnigB7.bindPopup("Déplace moi sur la carte").openPopup();

                     })[0];
                        MarkerEnigB7.bindPopup(link4Objt3 ,customOptions).openPopup();
                        map.addLayer(MarkerEnigB8);

                    }
                });

                MarkerEnigB7.on('dragend',function(x){
                    if(MarkerEnigB8.getLatLng().lat<MarkerEnigB7.getLatLng().lat+0.5 && MarkerEnigB8.getLatLng().lat>MarkerEnigB7.getLatLng().lat-0.5 && MarkerEnigB8.getLatLng().lng<MarkerEnigB7.getLatLng().lng+0.5 && MarkerEnigB8.getLatLng().lng>MarkerEnigB7.getLatLng().lng-0.5)
                    {
                        
                        map.removeLayer(MarkerEnigB7);
                        score += 350;
                        cart ="machine des tickets débloqué";
                        code='---';
                        indice="---";
                        document.getElementsByClassName('my-control')[0].innerHTML='Score: ' +score +'<br>'+'  time: '+ '<span id=seconds>'+ seconds+'</span>'+'<br>' +' cart: ' + cart +'<br>'+'code récupéré:  '+code+'<br>'+'indice:  '+indice;
                        var sound = new Howl({
                                src: [ 'assets/audio/Drums/Clunky Kit Samples/snare-big.wav'],
                                autoplay: true,
                                loop: false,
                                volume: 0.5,
                                onend: function() {

                                }
                            });
                            sound.play();

                        var link4Objt4 = $('<a href="#" class="speciallink">'+myObj[46].hint+'</a>').click(function() {
                        cart = ' machine ajoutée';
                        score += 280;
                        code='---';
                        indice='Chercher le ticket généré';
                        document.getElementsByClassName('my-control')[0].innerHTML='Score: ' +score +'<br>'+'  time: '+ '<span id=seconds>'+ seconds+'</span>'+'<br>' +' cart: ' + cart +'<br>'+'code récupéré:  '+code+'<br>'+'indice:  '+indice;
                        var sound = new Howl({
                            src: [ 'assets/audio/Drums/Clunky Kit Samples/snare-big.wav'],
                            autoplay: true,
                            loop: false,
                            volume: 0.5,
                            onend: function() {

                            }
                        });
                        sound.play();

                        map.removeLayer(MarkerEnigB8)
                        map.addLayer(MarkerEnigB9)
                        map.addLayer(MarkerEnigB10)

                     })[0];
                         MarkerEnigB8.bindPopup(link4Objt4 ,customOptions).openPopup();
                        

                    }
                });

                var link4Obj5 = $('<a href="#" class="speciallink">'+myObj[47].hint+'</a>').click(function() {
                    map.removeLayer(MarkerEnigB9);
                    cart = 'Ticket ajouté';
                    score += 370;
                    code='Train: TGV21/Classe:2/Nom:Titi/numéro: 1234567';
                    indice='---';
                    document.getElementsByClassName('my-control')[0].innerHTML='Score: ' +score +'<br>'+'  time: '+ '<span id=seconds>'+ seconds+'</span>'+'<br>' +' cart: ' + cart +'<br>'+'code récupéré:  '+code+'<br>'+'indice:  '+indice;
                    var sound = new Howl({
                        src: [ 'assets/audio/Drums/Clunky Kit Samples/snare-big.wav'],
                        autoplay: true,
                        loop: false,
                        volume: 0.5,
                        onend: function() {

                        }
                    });
                    sound.play();

                 })[0];
                    MarkerEnigB9.bindPopup(link4Obj5,customOptions).openPopup();

                var long=myObj[49].longitude-1
                var lat=myObj[49].latitude-1
                var MarkerEnigB10_1 =L.marker([long, lat], {icon:enig4_train });

                var link4Obj6 = $('<form  method="get" id="form1">'+'<label>Train : </label>'+'<input type="text" id="train" name="train" required minlength="5" maxlength="6" size="20">'+'<br>'+'<label>Classe : </label>'+'<input type="text" id="classe" name="classe" required minlength="1" maxlength="2" size="10">'+'<br>'+'<label>Nom : </label>'+'<input type="text" id="nom" name="nom" required minlength="4" maxlength="5" size="20">'+'<br>'+'<label>numéro : </label>'+'<input type="text" id="num" name="num" required minlength="7" maxlength="8" size="20">'+'<br>'+'<input type="submit" value="Ajouter">'+'</form>').submit(function(e) {
                            var train = document.getElementsByName("train")[0].value;
                            var classe = document.getElementsByName("classe")[0].value;
                            var nom = document.getElementsByName("nom")[0].value;
                            var num = document.getElementsByName("num")[0].value;
                            e.preventDefault();
                            if(train =='TGV21' && classe=='2' && nom=='Titi'&& num=='1234567')
                            {
                                map.removeLayer(MarkerEnigB10);
                                map.addLayer(MarkerEnigB11);
                                map.addLayer(MarkerEnigB10_1);

                                map.panTo([long, lat]);
                              
                                

                                
                                            
                            }
                        })[0];
                    MarkerEnigB10.bindPopup(link4Obj6,customOptions).openPopup();

                var link4Obj6 = $('<a href="#" class="speciallink">'+myObj[48].hint+'</a>').click(function() {
                    map.removeLayer(MarkerEnigB10_1);
                    cart = 'Train ajouté';
                    score += 500;
                    code='---';
                    indice='---';
                    document.getElementsByClassName('my-control')[0].innerHTML='Score: ' +score +'<br>'+'  time: '+ '<span id=seconds>'+ seconds+'</span>'+'<br>' +' cart: ' + cart +'<br>'+'code récupéré:  '+code+'<br>'+'indice:  '+indice;
                    var sound = new Howl({
                        src: [ 'assets/audio/Drums/Clunky Kit Samples/snare-big.wav'],
                        autoplay: true,
                        loop: false,
                        volume: 0.5,
                        onend: function() {

                        }
                    });
                    sound.play();

                 })[0];
                    MarkerEnigB10_1.bindPopup(link4Obj6,customOptions).openPopup();

                    var link4Obj7 = $('<a href="#" class="speciallink">'+myObj[49].hint+'</a>').click(function() {
                        map.removeLayer(MarkerEnigB11);
                        map.removeLayer(Enigm4Group);
                        Enigm4Group.clearLayers()
                        map.removeLayer(Quest4);
                        zoomEnig4=0;
                        score+=1070
                        cart='Enigme Australie résolue'
                        code='---';
                        indice='---';
                        document.getElementsByClassName('my-control')[0].innerHTML='Score: ' +score +'<br>'+'  time: '+ '<span id=seconds>'+ seconds+'</span>'+'<br>' +' cart: ' + cart +'<br>'+'code récupéré:  '+code+'<br>'+'indice:  '+indice;
                        var sound = new Howl({
                            src: [ 'assets/audio/Drums/Clunky Kit Samples/snare-big.wav'],
                            autoplay: true,
                            loop: false,
                            volume: 0.5,
                            onend: function() {

                            }
                        });
                        sound.play();
                        document.getElementsByClassName("speech-bubble")[0].innerHTML='<p>Félicitations ! Enigme Autralie résolue </p>';
                        map.setView([-20, 130], 2);
                        map.options.minZoom = 2;

                     })[0];
                        MarkerEnigB11.bindPopup(link4Obj7,customOptions).openPopup();

                    //

                // enigme2 sur Asie 
                /* Quest1:A Rude Awakening
                There are two doors you can't open; the one on the left leads to the alley and won't ever open,
                and the one on the right
                sub object1:door/on the map-> adds books
                sub object2:door/on the map
                will only open if you manage to collect all twenty of the Mike & Ike Hammer edible comic books
                in the game.
                sub object3:comic books/unlocked by another->adds box and code
                sub object 4:box
                sub object5:code-> finish quest one
                */
                var SubM1 = new L.FeatureGroup();

                 

                var Quest1Icon1 = L.icon({
                        iconUrl: './assets/images/icons/enigme2/opened-door-aperture.png',

                        iconSize:     [80, 80], // size of the icon
                        iconAnchor:   [myObj[19].longitude, myObj[19].latitude], // point of the icon which will correspond to marker's location
                        //popupAnchor:  [60, -150] // point from which the popup should open relative to the iconAnchor
                    });
                var Quest11 = L.marker([myObj[19].longitude, myObj[19].latitude], {icon: Quest1Icon1});
                var Quest1Icon11 = L.icon({
                        iconUrl: './assets/images/icons/enigme2/door2.png',

                        iconSize:     [80, 80], // size of the icon
                        iconAnchor:   [myObj[19].longitude, myObj[19].latitude], // point of the icon which will correspond to marker's location
                        //popupAnchor:  [60, -150] // point from which the popup should open relative to the iconAnchor
                    });
                var Quest111 = L.marker([myObj[19].longitude, myObj[19].latitude], {icon: Quest1Icon11});

                var Quest1Icon2 = L.icon({
                        iconUrl: './assets/images/icons/enigme2/door2.png',

                        iconSize:     [80, 80], // size of the icon
                        iconAnchor:   [myObj[20].longitude, myObj[20].latitude], // point of the icon which will correspond to marker's location
                        //popupAnchor:  [60, -150] // point from which the popup should open relative to the iconAnchor
                    });
                var Quest12 = L.marker([myObj[20].longitude, myObj[20].latitude], {icon: Quest1Icon2});
                var Quest1Icon22 = L.icon({
                        iconUrl: './assets/images/icons/enigme2/opened-door-aperture.png',

                        iconSize:     [80, 80], // size of the icon
                        iconAnchor:   [myObj[20].longitude, myObj[20].latitude], // point of the icon which will correspond to marker's location
                        //popupAnchor:  [60, -150] // point from which the popup should open relative to the iconAnchor
                    });
                var Quest122 = L.marker([myObj[20].longitude, myObj[20].latitude], {icon: Quest1Icon22});

                var Quest1Icon3 = L.icon({
                        iconUrl: './assets/images/icons/enigme2/comic-book.png',

                        iconSize:     [60, 60], // size of the icon
                        iconAnchor:   [myObj[21].longitude, myObj[21].latitude], // point of the icon which will correspond to marker's location
                        //popupAnchor:  [60, -150] // point from which the popup should open relative to the iconAnchor
                    });
                var Quest13 = L.marker([myObj[21].longitude, myObj[21].latitude], {icon: Quest1Icon3,draggable:true});

                var Quest1Icon4 = L.icon({
                        iconUrl: './assets/images/icons/enigme2/box.png',

                        iconSize:     [60, 60], // size of the icon
                        iconAnchor:   [myObj[22].longitude, myObj[22].latitude], // point of the icon which will correspond to marker's location
                        //popupAnchor:  [60, -150] // point from which the popup should open relative to the iconAnchor
                    });
                var Quest14 = L.marker([myObj[22].longitude, myObj[22].latitude], {icon: Quest1Icon4});

                var Quest1Icon5 = L.icon({
                        iconUrl: './assets/images/icons/enigme2/sheet.png',

                        iconSize:     [60, 60], // size of the icon
                        iconAnchor:   [myObj[23].longitude, myObj[23].latitude], // point of the icon which will correspond to marker's location
                        //popupAnchor:  [60, -150] // point from which the popup should open relative to the iconAnchor
                    });
                var Quest15 = L.marker([myObj[23].longitude, myObj[23].latitude], {icon: Quest1Icon5});



                //------Régler le zoom enigme3
                var zoomEnig3=1
                if(zoomEnig3==1){
                    var Enigm3Group = new L.FeatureGroup();
                    Enigm3Group.addLayer(Quest111);
                    Enigm3Group.addLayer(Quest12);
                    map.on('zoomend', function() {
                        if (map.getZoom() <7){
                                map.removeLayer(Enigm3Group);
                        }
                        else {
                                map.addLayer(Enigm3Group);
                            }
                    });
                }
                // enigme 3 event 
                var link101 = $('<a>'+myObj[19].hint+'</a>').click(function()
                    {
                        /*hint=find box and drag it*/
                        map.removeLayer(Quest111)
                        map.addLayer(Quest11)
                        /*SubM1.addLayer(Quest13)
                        map.addLayer(SubM1);*/
                        map.addLayer(Quest13)
                        score+=370
                        cart = 'Bouquin débloqué';
                        code='---';
                        indice='---';
                        document.getElementsByClassName('my-control')[0].innerHTML='Score: ' +score +'<br>'+'  time: '+ '<span id=seconds>'+ seconds+'</span>'+'<br>' +' cart: ' + cart +'<br>'+'code récupéré:  '+code+'<br>'+'indice:  '+indice;
                        var sound = new Howl({
                                src: [ 'assets/audio/Drums/Clunky Kit Samples/snare-big.wav'],
                                autoplay: true,
                                loop: false,
                                volume: 0.5,
                                onend: function() {

                                }
                                });
                                sound.play();



                    })[0];
                    Quest111.bindPopup(link101,customOptions).openPopup();

                    Quest13.bindPopup("Déplace moi vers la porte ouverte ").openPopup();
                    Quest13.on('dragend',function(x)
                        {
                            if(Quest13.getLatLng().lat<Quest11.getLatLng().lat+0.5 && Quest13.getLatLng().lat>Quest11.getLatLng().lat-0.5&& Quest13.getLatLng().lng<Quest11.getLatLng().lng+0.5 && Quest13.getLatLng().lng>Quest11.getLatLng().lng-0.5)
                                 {
                                    map.removeLayer(Quest13);
                                    map.removeLayer(Quest11);
                                    SubM1.addLayer(Quest14)
                                    map.addLayer(SubM1);
                                    score+=370
                                    cart = 'Bouquin Trouvé';
                                    code='---';
                                    indice='---';
                                    document.getElementsByClassName('my-control')[0].innerHTML='Score: ' +score +'<br>'+'  time: '+ '<span id=seconds>'+ seconds+'</span>'+'<br>' +' cart: ' + cart +'<br>'+'code récupéré:  '+code+'<br>'+'indice:  '+indice;
                                    var sound = new Howl({
                                        src: [ 'assets/audio/Drums/Clunky Kit Samples/snare-big.wav'],
                                        autoplay: true,
                                        loop: false,
                                        volume: 0.5,
                                        onend: function() {

                                        }
                                    });
                                    sound.play();

                                        }
                        });


                    var link114 = $('<a href="#" class="speciallink">'+myObj[22].hint+'</a>').click(function() {
                            map.removeLayer(Quest14)
                            score+=270
                            cart = 'PassWord=AZERTYUIOP or QWERTYUIOP';
                            code='---';
                            indice='---';
                            document.getElementsByClassName('my-control')[0].innerHTML='Score: ' +score +'<br>'+'  time: '+ '<span id=seconds>'+ seconds+'</span>'+'<br>' +' cart: ' + cart +'<br>'+'code récupéré:  '+code+'<br>'+'indice:  '+indice;
                            var sound = new Howl({
                                src: [ 'assets/audio/Drums/Clunky Kit Samples/snare-big.wav'],
                                autoplay: true,
                                loop: false,
                                volume: 0.5,
                                onend: function() {

                                }
                            });
                            sound.play();
                            

                            })[0];

                    Quest14.bindPopup(link114,customOptions).openPopup();

                    var link112 = $('<form  method="get" id="form2">'+'<label>Code : </label>'+'<input type="text" id="password2" name="password2" required minlength="10" maxlength="11" size="20">'+'<br>'+'<input type="submit" value="Ouvrir">'+'</form>').submit(function(e) {
                            var pass2 = document.getElementsByName("password2")[0].value;
                            e.preventDefault();
                            if(pass2=='QWERTYUIOP'){
                                map.removeLayer(Quest12)
                                map.addLayer(Quest122)
                                score+=270
                                cart = 'Box ajoutée ';
                                code='---';
                                indice='---';
                                document.getElementsByClassName('my-control')[0].innerHTML='Score: ' +score +'<br>'+'  time: '+ '<span id=seconds>'+ seconds+'</span>'+'<br>' +' cart: ' + cart +'<br>'+'code récupéré:  '+code+'<br>'+'indice:  '+indice;
                                var sound = new Howl({
                                    src: [ 'assets/audio/Drums/Clunky Kit Samples/snare-big.wav'],
                                    autoplay: true,
                                    loop: false,
                                    volume: 0.5,
                                    onend: function() {

                                    }
                                });
                                sound.play(); 
                                }
                            
                            })[0];

                    Quest12.bindPopup(link112,customOptions).openPopup();

                    var link113 = $('<a>'+myObj[20].hint+'</a>').click(function() {
                                map.removeLayer(Quest122)
                                score+=1520
                                cart = 'Enigme Asie résolue';
                                code='---';
                                indice='---';
                                document.getElementsByClassName('my-control')[0].innerHTML='Score: ' +score +'<br>'+'  time: '+ '<span id=seconds>'+ seconds+'</span>'+'<br>' +' cart: ' + cart +'<br>'+'code récupéré:  '+code+'<br>'+'indice:  '+indice;
                                document.getElementsByClassName("speech-bubble")[0].innerHTML='<p>Félicitations ! Enigme Asie résolue </p>';

                                var sound = new Howl({
                                    src: [ 'assets/audio/Drums/Clunky Kit Samples/snare-big.wav'],
                                    autoplay: true,
                                    loop: false,
                                    volume: 0.5,
                                    onend: function() {

                                    }
                                });
                                sound.play();

                                map.removeLayer(Quest3)
                                zoomEnig3=0;
                                map.setView([60, 63], 2);
                                map.options.minZoom = 2;
                            
                            
                            })[0];

                    Quest122.bindPopup(link113,customOptions).openPopup();
                //


                var score=0;
                var cart= 'empty';
                var code='---';
                var indice='---';


                L.Control.MyControl = L.Control.extend({
                    onAdd: function(map) {
                        var el = L.DomUtil.create('div', 'leaflet-bar my-control');
                        el.style.backgroundColor='black';
                        el.style.width='350px';
                        el.style.height='109px';
                        el.style.paddingBottom='25px';
                        el.id="controlleaf";
                        el.innerHTML = 'Score: ' +score +'<br>'+'  time: '+ '<span id=seconds>'+ seconds+'</span>'+'<br>' +' cart: ' + cart +'<br>'+'code récupéré:  '+code+'<br>'+'indice:  '+indice;



                        return el;
                    },
                    onRemove: function(map) {
                        // Nothing to do here
                    }
                });

                var myButtonOptions = {
                    'text': '',  // string
                    'iconUrl': 'assets/images/exit.png',  // string
                    'onClick': my_button_onClick,  // callback function
                    'hideText': true,  // bool
                    'maxWidth': 0,  // number
                    'doToggle': false,  // bool
                    'toggleStatus': false  // bool
                }

                var myButton = new L.Control.Button(myButtonOptions).addTo(map);
                function my_button_onClick()
                {

                    $.post("updatescore.php",
                        {player: '<?php echo $_SESSION['user']['username'] ?>', score: score, time: seconds}
                        , function(data) {
                            alert("you've scored: "+ score);
                            window.location.href="<?php echo BASE_URL . 'index.php' ?>";

                        });
                }
                //console.log($("butquit").click)



                L.control.myControl = function(opts) {
                    return new L.Control.MyControl(opts);
                }

                L.control.myControl({
                    position: 'topright',
                    background : '#0587f5 !important'

                }).addTo(map);

                var scorebar= document.getElementsByClassName('my-control');











            // enigme2 sur l'amerique


            var SubM2 = new L.FeatureGroup();
            /*There isn't a lot you can do about the mines over here except avoid them. The red proximity mines you see on the ground, like directly on your left as you enter the atrium,
             have a red light on top and will beep loudly if you get close. If you ignore the beeping and get closer, they blow up and take you with them.

            Avoid the mines altogether by looking for them and walking wide around them. Because they do give out that beep-beep before they blow, sometimes you
            can run past them before you get got, but be sure you have a clear path before you start running or they'll get you in mid-stride.
            (As far as I've been able to discover, it's not possible to get close enough to start them ticking and then run away while they blow up without
             harming you. If you run away, they calm down; if they blow, so do you.)
            hint Quest2: Start looking for a mine detector
            object1:mine detector/draggable
            object 2,3,4,not 5,6,7,8,9,10 : mines/explosives
            object 5: mine that would explode but you ll have to look for a healthcare center
            object 11:Healthcare center/unlocked by mine 5
            object 12: mine detector 2
            object 13:tesla tour unlocked
            The first level includes reception, security, administration, conference rooms, maintenance, and restrooms. There are also
            elevators (blocked) and the Titan reactor level 1 entrance (blocked). Here's a simple map:

            object 14: map/clickable -> unlock tesla secret
            object 15: tesla secret -> draggable to quest 2 to finish*/


            var Quest2Tesla = L.icon({
                iconUrl: './assets/images/icons/enigme3/tesla.png',

                iconSize:     [90, 110], // size of the icon
                iconAnchor:   [myObj[50].longitude, myObj[50].latitude], // point of the icon which will correspond to marker's location
                popupAnchor:  [10, -10] // point from which the popup should open relative to the iconAnchor
            });
            var Quest2T = L.marker([myObj[50].longitude, myObj[50].latitude], {icon: Quest2Tesla});

            var Quest2Icon1 = L.icon({
                iconUrl: './assets/images/icons/enigme3/metal-detector.png',

                iconSize:     [60, 60], // size of the icon
                iconAnchor:   [myObj[24].longitude, myObj[24].latitude], // point of the icon which will correspond to marker's location
                popupAnchor:  [10, -10]
            });
            var Quest21 = L.marker([myObj[24].longitude, myObj[24].latitude], {icon: Quest2Icon1,draggable:true});


            var Quest2Icon2 = L.icon({
                iconUrl: './assets/images/icons/enigme3/bomb.png',

                iconSize:     [50, 50], // size of the icon
                iconAnchor:   [myObj[25].longitude, myObj[25].latitude], // point of the icon which will correspond to marker's location
            });
            var Quest22 = L.marker([myObj[25].longitude, myObj[25].latitude], {icon: Quest2Icon2});

            var Quest2Icon3 = L.icon({
                iconUrl: './assets/images/icons/enigme3/bomb1.png',

                iconSize:     [50, 50], // size of the icon
                iconAnchor:   [myObj[26].longitude, myObj[26].latitude], // point of the icon which will correspond to marker's location
            });
            var Quest23 = L.marker([myObj[26].longitude, myObj[26].latitude], {icon: Quest2Icon3});

            var Quest2Icon4 = L.icon({
                iconUrl: './assets/images/icons/enigme3/bomb2.png',

                iconSize:     [50, 50], // size of the icon
                iconAnchor:   [myObj[27].longitude, myObj[27].latitude], // point of the icon which will correspond to marker's location
            });
            var Quest24 = L.marker([myObj[27].longitude, myObj[27].latitude], {icon: Quest2Icon4});

            var Quest2Icon5 = L.icon({
                iconUrl: './assets/images/icons/enigme3/bomb3.png',

                iconSize:     [50, 50], // size of the icon
                iconAnchor:   [myObj[28].longitude, myObj[28].latitude], // point of the icon which will correspond to marker's location
            });
            var Quest25 = L.marker([myObj[28].longitude, myObj[28].latitude], {icon: Quest2Icon5});

            var Quest2Icon6 = L.icon({
                iconUrl: './assets/images/icons/enigme3/dynamite.png',

                iconSize:     [50, 50], // size of the icon
                iconAnchor:   [myObj[29].longitude, myObj[29].latitude], // point of the icon which will correspond to marker's location
            });
            var Quest26 = L.marker([myObj[29].longitude, myObj[29].latitude], {icon: Quest2Icon6});

            var Quest2Icon7 = L.icon({
                iconUrl: './assets/images/icons/enigme3/bomb.png',

                iconSize:     [50, 50], // size of the icon
                iconAnchor:   [myObj[30].longitude, myObj[30].latitude], // point of the icon which will correspond to marker's location
            });
            var Quest27 = L.marker([myObj[30].longitude, myObj[30].latitude], {icon: Quest2Icon7});

            var Quest2Icon8 = L.icon({
                iconUrl: './assets/images/icons/enigme3/bomb4.png',

                iconSize:     [50, 50], // size of the icon
                iconAnchor:   [myObj[31].longitude, myObj[31].latitude], // point of the icon which will correspond to marker's location
            });
            var Quest28 = L.marker([myObj[31].longitude, myObj[31].latitude], {icon: Quest2Icon8});

            var Quest2Icon9 = L.icon({
                iconUrl: './assets/images/icons/enigme3/bomb.png',

                iconSize:     [50, 50], // size of the icon
                iconAnchor:   [myObj[32].longitude, myObj[32].latitude], // point of the icon which will correspond to marker's location
            });
            var Quest29 = L.marker([myObj[32].longitude, myObj[32].latitude], {icon: Quest2Icon9});

            var Quest2Icon10 = L.icon({
                iconUrl: './assets/images/icons/enigme3/bomb.png',

                iconSize:     [50, 50], // size of the icon
                iconAnchor:   [myObj[33].longitude, myObj[33].latitude], // point of the icon which will correspond to marker's location
            });
            var Quest210 = L.marker([myObj[33].longitude, myObj[33].latitude], {icon: Quest2Icon10});

            var Quest2Icon11 = L.icon({
                iconUrl: './assets/images/icons/enigme3/hospital.png',

                iconSize:     [100, 100], // size of the icon
                iconAnchor:   [myObj[34].longitude, myObj[34].latitude], // point of the icon which will correspond to marker's location
            });
            var Quest211 = L.marker([myObj[34].longitude, myObj[34].latitude], {icon: Quest2Icon11});

            var Quest2Icon12 =  L.icon({
                iconUrl: './assets/images/icons/enigme3/metal-detector.png',

                iconSize:     [60, 60], // size of the icon
                iconAnchor:   [myObj[35].longitude, myObj[35].latitude], // point of the icon which will correspond to marker's location
            });
            var Quest212 = L.marker([myObj[35].longitude, myObj[35].latitude], {icon: Quest2Icon12});

            var Quest2Icon13 =L.icon({
                    iconUrl: './assets/images/icons/enigme3/metal-detector.png',

                    iconSize:     [60, 60], // size of the icon
                    iconAnchor:   [myObj[36].longitude, myObj[36].latitude], // point of the icon which will correspond to marker's location
                });

            var Quest213 = L.marker([myObj[36].longitude, myObj[36].latitude], {icon: Quest2Icon13,draggable:true});

            var Quest2Icon14 = L.icon({
                iconUrl: './assets/images/icons/enigme3/teslaopen.png',

                iconSize:     [30, 50], // size of the icon
                iconAnchor:   [myObj[37].longitude, myObj[37].latitude], // point of the icon which will correspond to marker's location
            });
            var Quest214 = L.marker([myObj[37].longitude, myObj[37].latitude], {icon: Quest2Icon14});

            var Quest2Icon15 = L.icon({
                iconUrl: './assets/images/icons/enigme3/folder.png',

                iconSize:     [30, 50], // size of the icon
                iconAnchor:   [myObj[38].longitude, myObj[38].latitude], // point of the icon which will correspond to marker's location
            });
            var Quest215 = L.marker([myObj[38].longitude, myObj[38].latitude], {icon: Quest2Icon15,draggable:true});

            //------Régler le zoom
               
            var ArrayStartQuest2=[Quest21,Quest22,Quest23,Quest24,Quest25,Quest26,Quest27,Quest28,Quest29,Quest210];
            for(i=0;i<10;i++)
            {
                if(myObj[i].minzoom == 7)
                {
                    SubM2.addLayer(ArrayStartQuest2[i]);
                }
            }

            //map.addLayer(SubM2);
            map.on('zoomend', function() {
                    if (map.getZoom() <7){
                            map.removeLayer(SubM2);
                            map.removeLayer(Quest2T);
                    }
                    else {
                            map.addLayer(SubM2);
                            map.addLayer(Quest2T);
                        }
                });

            Quest21.bindPopup("Déplace moi sur les mines pour les retirer").openPopup();

                for(let m=1; m<ArrayStartQuest2.length; m++)
                {
                Quest21.on('dragend',function(x)
                {


                    console.log(ArrayStartQuest2[5].getLatLng().lat);
                    if(Quest21.getLatLng().lat<ArrayStartQuest2[m].getLatLng().lat+0.5 && Quest21.getLatLng().lat>ArrayStartQuest2[m].getLatLng().lat-0.5 && Quest21.getLatLng().lng<ArrayStartQuest2[m].getLatLng().lng+0.5 && Quest21.getLatLng().lng>ArrayStartQuest2[m].getLatLng().lng-0.5)
                    {

                        if(m==5)
                        {
                            console.log("here");
                            document.getElementsByClassName("speech-bubble").innerHTML='Explosion !';
                            map.removeLayer(ArrayStartQuest2[m]);
                            map.removeLayer(Quest21);
                            SubM2.addLayer(Quest211);
                            map.addLayer(SubM2);
                            cart = 'Mine explosée';
                            score += 170;
                            code='---';
                            indice='Chercher l\'hôpital';
                            document.getElementsByClassName('my-control')[0].innerHTML='Score: ' +score +'<br>'+'  time: '+ '<span id=seconds>'+ seconds+'</span>'+'<br>' +' cart: ' + cart +'<br>'+'code récupéré:  '+code+'<br>'+'indice:  '+indice;
                            var sound = new Howl({
                                        src: [ 'assets/audio/Drums/Clunky Kit Samples/snare-big.wav'],
                                        autoplay: true,
                                        loop: false,
                                        volume: 0.5,
                                        onend: function() {

                                        }
                                    });
                            sound.play();



                            var link1211 = $('<a href="#" class="speciallink">'+myObj[35].hint+'</a>').click(function() {
                                document.getElementsByClassName("speech-bubble")[0].innerHTML='détecteur de mine généré ,Trouve le ';
                                SubM2.addLayer(Quest213);
                                map.addLayer(SubM2);
                                var link1212 = $('<p  class="speciallink">'+"Tu peux continuer à jouer"+'</p>');
                                Quest211.unbindPopup();
                                /*Quest212.bindPopup(link1212,customOptions).openPopup();
                               */


                            })[0];

                            Quest211.bindPopup(link1211,customOptions).openPopup();


                        }
                        if(m==ArrayStartQuest2.length-1)
                        {

                            map.removeLayer(ArrayStartQuest2[ArrayStartQuest2.length-1]);

                        }
                        else
                        {
                            map.removeLayer(ArrayStartQuest2[m]);
                            cart = 'Mine détectée et retirée';
                            score += 170;
                            code='---';
                            indice='---';
                            document.getElementsByClassName('my-control')[0].innerHTML='Score: ' +score +'<br>'+'  time: '+ '<span id=seconds>'+ seconds+'</span>'+'<br>' +' cart: ' + cart +'<br>'+'code récupéré:  '+code+'<br>'+'indice:  '+indice;
                            var sound = new Howl({
                                src: [ 'assets/audio/Drums/Clunky Kit Samples/snare-big.wav'],
                                autoplay: true,
                                loop: false,
                                volume: 0.5,
                                onend: function() {

                                }
                            });
                            sound.play();
                        }


                    }
                }




            )};

                for(let m=1; m<ArrayStartQuest2.length; m++)
                {
                    Quest213.on('dragend',function(x)
                        {



                            if(Quest213.getLatLng().lat<ArrayStartQuest2[m].getLatLng().lat+0.5 && Quest213.getLatLng().lat>ArrayStartQuest2[m].getLatLng().lat-0.5 && Quest213.getLatLng().lng<ArrayStartQuest2[m].getLatLng().lng+0.5 && Quest213.getLatLng().lng>ArrayStartQuest2[m].getLatLng().lng-0.5)
                            {

                                if(m==5)
                                {
                                    console.log("here");
                                    document.getElementsByClassName("speech-bubble").innerHTML='Explosion!';
                                    map.removeLayer(ArrayStartQuest2[m]);
                                    map.removeLayer(Quest21);
                                    SubM2.addLayer(Quest211);
                                    map.addLayer(SubM2);
                                    cart = 'Mine explosée';
                                    score += 170;
                                    code='---';
                                    indice='Chercher l\'hôpital';
                                    document.getElementsByClassName('my-control')[0].innerHTML='Score: ' +score +'<br>'+'  time: '+ '<span id=seconds>'+ seconds+'</span>'+'<br>' +' cart: ' + cart +'<br>'+'code récupéré:  '+code+'<br>'+'indice:  '+indice;
                                    var sound = new Howl({
                                                src: [ 'assets/audio/Drums/Clunky Kit Samples/snare-big.wav'],
                                                autoplay: true,
                                                loop: false,
                                                volume: 0.5,
                                                onend: function() {

                                                }
                                            });
                                    sound.play();



                                    var link1211 = $('<a href="#" class="speciallink">'+myObj[35].hint+'</a>').click(function() {
                                        document.getElementsByClassName("speech-bubble")[0].innerHTML='new mine detector generated,find it and when finished take the mine detector to the tesla tour.';
                                        SubM2.addLayer(Quest213);
                                        map.addLayer(SubM2);
                                        var link1212 = $('<p  class="speciallink">'+"You are as healthy as a horse"+'</p>');
                                        Quest211.unbindPopup();
                                        /*Quest212.bindPopup(link1212,customOptions).openPopup();
                                       */


                                    })[0];

                                    Quest211.bindPopup(link1211,customOptions).openPopup();


                                }
                                if(m==ArrayStartQuest2.length-1)
                                {

                                    map.removeLayer(ArrayStartQuest2[ArrayStartQuest2.length-1]);
                                    map.addLayer(Quests)

                                }
                                console.log('Here0');

                                if(m!=ArrayStartQuest2.length-1 && m!=5)
                                {

                                    map.removeLayer(ArrayStartQuest2[m]);
                                    cart = 'Mine détectée et retirée';
                                    score += 170;
                                    code='---';
                                    indice='---';
                                    document.getElementsByClassName('my-control')[0].innerHTML='Score: ' +score +'<br>'+'  time: '+ '<span id=seconds>'+ seconds+'</span>'+'<br>' +' cart: ' + cart +'<br>'+'code récupéré:  '+code+'<br>'+'indice:  '+indice;
                                    var sound = new Howl({
                                        src: [ 'assets/audio/Drums/Clunky Kit Samples/snare-big.wav'],
                                        autoplay: true,
                                        loop: false,
                                        volume: 0.5,
                                        onend: function() {

                                        }
                                    });
                                    sound.play();
                                }


                            }

                            if(Quest213.getLatLng().lat<Quest2T.getLatLng().lat+0.5 && Quest213.getLatLng().lat>Quest2T.getLatLng().lat-0.5 && Quest213.getLatLng().lng<Quest2T.getLatLng().lng+0.5 && Quest213.getLatLng().lng>Quest2T.getLatLng().lng-0.5)
                            {
                                console.log('Here');
                                map.removeLayer(Quest212);
                                map.removeLayer(Quest213);
                                cart = 'le secret est débloque';
                                score += 170;
                                code='---';
                                indice='Chercher le secret';
                                document.getElementsByClassName('my-control')[0].innerHTML='Score: ' +score +'<br>'+'  time: '+ '<span id=seconds>'+ seconds+'</span>'+'<br>' +' cart: ' + cart +'<br>'+'code récupéré:  '+code+'<br>'+'indice:  '+indice;
                                var sound = new Howl({
                                            src: [ 'assets/audio/Drums/Clunky Kit Samples/snare-big.wav'],
                                            autoplay: true,
                                            loop: false,
                                            volume: 0.5,
                                            onend: function() {

                                            }
                                        });
                                sound.play();
                                document.getElementsByClassName("speech-bubble")[0].innerHTML =' Bravo ! Il faut que tu cherches le secret du Tesla il est caché sur la map';
                                Quest214.addTo(map).on('click', function()
                                {
                                    map.removeLayer(Quest214);
                                    SubM2.addLayer(Quest215);
                                    map.addLayer(SubM2);
                                    cart = 'le Top secret débloqué ';
                                    score += 570;
                                    code='---';
                                    indice='Chercher le Top secret et glisse le vers la tesla';
                                    document.getElementsByClassName('my-control')[0].innerHTML='Score: ' +score +'<br>'+'  time: '+ '<span id=seconds>'+ seconds+'</span>'+'<br>' +' cart: ' + cart +'<br>'+'code récupéré:  '+code+'<br>'+'indice:  '+indice;
                                    var sound = new Howl({
                                                src: [ 'assets/audio/Drums/Clunky Kit Samples/snare-big.wav'],
                                                autoplay: true,
                                                loop: false,
                                                volume: 0.5,
                                                onend: function() {

                                                }
                                            });
                                    sound.play();

                                });

                            }
                        }

                    )};
                /*var link1213 = $('<a href="#" class="speciallink">'+myObj[36].hint+'</a>').click(function()
                {
                    document.getElementsByClassName("speech-bubble")[0].innerHTML='new mine detector found';

                });
                Quest213.bindPopup(link1213,customOptions).openPopup();*/

            Quest215.on('dragend',function(x)
            {
                if(Quest215.getLatLng().lat<Quest2T.getLatLng().lat+0.9 && Quest215.getLatLng().lat>Quest2T.getLatLng().lat-0.9 && Quest215.getLatLng().lng<Quest2T.getLatLng().lng+0.9 && Quest215.getLatLng().lng>Quest2T.getLatLng().lng-0.9)
                {

                    map.removeLayer(Quest215);
                    map.removeLayer(SubM2);

                    var linkFinQuest2 = $('<a href="#" class="speciallink">'+myObj[50].hint+'</a>').click(function() {
                    map.removeLayer(Quest2T);
                    map.removeLayer(SubM2);
                    cart = 'Congrats! Enigme Tesla résolue ';
                    score += 1070;
                    code='---';
                    indice='---';
                    document.getElementsByClassName('my-control')[0].innerHTML='Score: ' +score +'<br>'+'  time: '+ '<span id=seconds>'+ seconds+'</span>'+'<br>' +' cart: ' + cart +'<br>'+'code récupéré:  '+code+'<br>'+'indice:  '+indice;
                    var sound = new Howl({
                        src: [ 'assets/audio/Drums/Clunky Kit Samples/snare-big.wav'],
                        autoplay: true,
                        loop: false,
                        volume: 0.5,
                        onend: function() {

                        }
                    });
                    sound.play();
                    map.removeLayer(Quest2);
                    map.setView([50,-100], 2);
                    map.options.minZoom = 2;

                 })[0];
                    Quest2T.bindPopup(linkFinQuest2,customOptions).openPopup();
                    

                }

                    });

            




map.setView([10, 15], 3);

                document.getElementById("controlleaf").style.backgroundColor = "#00aabb";













            /* var i;
             for(i=0;i<myObj.length;i++)
             {
                 if(myObj[i].minzoom == 10)
                 {
                     Marker1group10.addLayer(markersarray[i]);
                 }
                 else if(myObj[i].minzoom == 7)
                 {
                     Marker1group7.addLayer(markersarray[i]);
                 }
                 else
                 {
                     Marker1group5.addLayer(markersarray[i]);
                 }
             }
*/




             /*map.on('zoomend', function() {
                 if (map.getZoom() <5){
                     map.removeLayer(SubM1);
                     map.removeLayer(SubM2);
                     map.addLayer(Quests);
                 }

                 else {
                     map.addLayer(SubM1);
                     map.addLayer(SubM2);
                     map.removeLayer(Quests);
                 }
             });*/

            }
        };
        xmlhttp.open("GET", "ajax.php", true);
        xmlhttp.send();



    </script>


<?php include(INCLUDE_PATH . "/layouts/footer.php") ?>