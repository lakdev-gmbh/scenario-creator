<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Erasmus-Projekt:: EU-Szenarien</title>

    <style>
        .seite {
            background-color: #E6E6FA;
            margin-left: -8px;
            margin-right: -8px;
            margin-bottom: -8px;
            font-family: Verdana, Arial, Helvetica, sans-serif;
        }

        h2 {
            color: navy;
            text-decoration: underline;
            margin-top: 40px;
            border: black 4px solid;
            border-style: solid none none none;
            padding-top: 30px;
        }

        .image {
            display: flex;
            justify-content: center;
            margin: 25px;
        }

        #titel {
            margin-top: -8px;
            text-align: center;
            color: navy;
            text-decoration: underline;
            text-decoration-color: yellow;
        }

        .beschreibung {
            border: black 3px solid;
            border-radius: 10px;
            padding-top: 15px;
            padding-bottom: 15px;
            width: 1000px;
            text-align: center;
            background-color: white;
        }

        .beschreibungmitte {
            display: flex;
            justify-content: center;
        }

        h3 {
            text-decoration: underline;
        }

        h4 {
            text-decoration: underline;
            margin-bottom: 15px;
        }

        .antworten label {
            display: block;
        }

        input[type = checkbox] {
            margin-left: 5px;
        }

        .antworten {
            display: inline;
        }

        .infotextBody {
            border: navy 2px solid;
            border-radius: 20px;
            padding-right: 10px;
            padding-left: 10px;
            text-align: center;
            background-color: white;
        }

        .aufgabengruppen {
            margin-right: 200px;
            margin-left: 200px;
            text-align: center;
        }

        .frage {
            margin-bottom: 5px;
        }

        .button {
            position: relative;
            margin-top: 2px;
            margin-left: 10px;
            border-radius: 5px;
            background-color: #BDBDBD;
            border-color: #000000;
            border-width: 1px;
            font-size: 16px;
            color: #FFFFFF;
            padding: 10px;
            width: 100px;
            text-align: center;
            transition-duration: 0.4s;
            text-decoration: none;
            overflow: hidden;
            cursor: pointer;
        }

        .button:after {
            content: "";
            background: #f1f1f1;
            display: block;
            position: absolute;
            padding-top: 300%;
            padding-left: 350%;
            margin-left: -20px !important;
            margin-top: -120%;
            opacity: 0;
            transition: all 0.8s
        }

        .button:active:after {
            padding: 0;
            margin: 0;
            opacity: 1;
            transition: 0s
        }

    </style>

</head>
<body>
<div class='seite'>
    <h1 id="titel">Der Titel des Scenario</h1>
    <div class='beschreibungmitte'>
        <p id="description" class='beschreibung'>Beschreibung des Scenarios</p>
    </div>
    <div class='image'><img id="scenariobild"/></div>
    <div id="aufgabengruppenContainer" class="aufgabengruppen">
    </div>
    <p>&nbsp;</p>
</div>
<script>

    // Auslesen der Datenbank
    var path = "https://scenario.laknet.de/";
    // var requestURL = path + 'scenario';
    // var request = new XMLHttpRequest();
    // request.open("get", requestURL);
    // request.responseType = 'json';
    // request.send();
    // request.onload = function() {

    // Speichere das Szenario in jsonResult
    var jsonResult = {{ \Illuminate\Support\Js::from($scenario) }};
    if (Object.keys(jsonResult).length < 2) {
        jsonResult = jsonResult[Object.keys(jsonResult)[0]];
    }

    // Allgemeine Angaben zum Scenario
    document.getElementById("titel").innerHTML = jsonResult['title'];
    document.getElementById("description").innerHTML = jsonResult['description'];
    document.getElementById('scenariobild').src = path + jsonResult['image'];

    // Aufgabengruppen (taskgroups)
    var aufgabengruppen = document.getElementById('aufgabengruppenContainer');

    // Aufgabengruppen erstellen
    for (var i = 0; i < jsonResult['task_groups'].length; i++) {

        // Aufgabengruppe json
        var aufgabengruppeJson = jsonResult['task_groups'][i];

        // Aufgabengruppe erstellen
        var aufgabengruppe = document.createElement('div');
        aufgabengruppe.setAttribute('id', 'aufgabengruppe' + i);
        aufgabengruppen.appendChild(aufgabengruppe);

        // Aufgabengruppe Titel erstellen
        var aufgabengruppeTitle = document.createElement('h2');
        aufgabengruppeTitle.innerHTML = aufgabengruppeJson['title'];
        aufgabengruppe.appendChild(aufgabengruppeTitle)

        // Infotexte Container
        var infotextContainer = document.createElement('div');
        infotextContainer.setAttribute('class', 'infotexte');
        aufgabengruppe.appendChild(infotextContainer);

        // Aufgaben Container
        var aufgabenContainer = document.createElement('div');
        aufgabenContainer.setAttribute('class', 'aufgaben')
        aufgabengruppe.appendChild(aufgabenContainer);

        // Infotexte json
        var infotexteJson = aufgabengruppeJson['info_texts'];

        // Aufgaben json
        var aufgabenJson = aufgabengruppeJson['tasks'];

        // Infotexte erstellen
        for (var j = 0; j < aufgabengruppeJson['info_texts'].length; j++) {

            // Infotext json
            var infotextJson = infotexteJson[j];

            // Infotext
            var infotext = document.createElement('div');
            infotextContainer.appendChild(infotext);

            // Infotext Titel erstellen
            var infotextTitle = document.createElement('h3');
            infotextTitle.setAttribute('class', 'infotextTitle');
            infotextTitle.innerHTML = infotextJson['title'];
            infotext.appendChild(infotextTitle);

            // Infotext Body erstellen
            var infotextBody = document.createElement('div');
            infotextBody.setAttribute('class', 'infotextBody');
            infotextBody.innerHTML = infotextJson['body'];
            infotext.appendChild(infotextBody);
        }

        // Erstellen der Aufgaben
        for (var k = 0; k < aufgabenJson.length; k++) {

            // Aufgabe json
            var aufgabeJson = aufgabenJson[k];

            // Aufgabe
            var aufgabe = document.createElement('div');
            aufgabe.setAttribute('class', "aufgabe" + k);
            aufgabenContainer.appendChild(aufgabe);

            // Aufgabe Titel erstellen
            var aufgabeTitle = document.createElement('h4');
            aufgabeTitle.innerHTML = aufgabeJson['title'];
            aufgabe.appendChild(aufgabeTitle);

            // Aufgabe Frage erstellen
            var aufgabeQuestion = document.createElement('div');
            aufgabeQuestion.setAttribute('class', 'frage');
            aufgabeQuestion.innerHTML = aufgabeJson['question'];
            aufgabe.appendChild(aufgabeQuestion);

            // Aufgabe Antworten Container
            var aufgabeAntworten = document.createElement('div');
            aufgabeAntworten.setAttribute('class', 'antworten');
            aufgabe.appendChild(aufgabeAntworten);

            // Aufgabe Antworten erstellen
            switch (aufgabeJson['type']) {
                case "numeric" :
                    var antwort = document.createElement('input');
                    antwort.type = 'number';
                    aufgabeAntworten.appendChild(antwort);
                    break;
                case "multiple_choice":
                    var possible_answers = Object.values(aufgabeJson['possible_answers']);

                    // Jede Auswahlmöglichkeit erstellen
                    for (var l = 0; l < possible_answers.length; l++) {
                        var label = document.createElement('label');
                        label.innerHTML = possible_answers[l].answer;
                        aufgabeAntworten.appendChild(label);
                        var antwort = document.createElement('input');
                        antwort.type = 'checkbox';
                        label.appendChild(antwort);
                    }
                    break;
                case "text" :
                    var antwort = document.createElement('input');
                    antwort.type = 'text';
                    aufgabeAntworten.appendChild(antwort);
                    break;
                // TODO: Multiple-Choice-Aufgaben mit Bildern hinzufügen
                case "" :
                    break;
            }
            // Button zum Prüfen erstellen
            var button = document.createElement('button');
            button.innerHTML = 'Prüfen';
            button.setAttribute('class', 'button');
            aufgabe.appendChild(button);
            button.onclick = function (event) {

                // Aufgabendaten herauslesen
                let aufgabengruppeNummer = event.target.parentElement.parentElement.parentElement.id.replace(/\D/g, '');
                let aufgabeNummer = event.target.parentElement.className.replace(/\D/g, '');
                let antworten = event.target.parentElement.getElementsByClassName('antworten')[0].children;
                let aufgabeJson = jsonResult['task_groups'][aufgabengruppeNummer]['tasks'][aufgabeNummer];

                let korrekt = true;

                // If else zum Überprüfen der Richtigkeit
                // TODO: Bei Multiple-Choice-Aufgaben mit Bildern Lösung überprüfen
                if (aufgabeJson['type'] === 'multiple_choice') {
                    for (let y = 0; y < antworten.length; y++) {
                        if (antworten[y].children[0].checked != aufgabeJson['possible_answers']['' + (y + 1)]['is_correct']) {
                            korrekt = false;
                            break;
                        }
                    }
                } else {
                    if (antworten[0].value != aufgabeJson['correct_answer']) {
                        korrekt = false;
                    }
                }

                if (korrekt) {
                    event.target.style.backgroundColor = 'green';
                } else {
                    event.target.style.backgroundColor = 'red';
                }

            }
        }
        // }
    }

</script>

</body>
</html>
