
<?php
$json = $scenario
?>

<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Erasmus-Projekt:: EU-Scenarien</title>
</head>

<style>

.Webseite {
background-color: #E6E6FA;
margin-left:-8px;
margin-right:-8px;
margin-bottom:-8px;
font-family: Verdana, Arial, Helvetica, sans-serif;
}

h2 {
color: navy;
text-decoration: underline;
margin-top:40px;
border:black 4px solid;
border-style: solid none none none;
padding-top:30px;
}

.image {
display: flex;
justify-content: center;
margin: 25px;
}

#titel {
margin-top:-8px;
text-align: center;
color: navy;
text-decoration: underline;
text-decoration-color: yellow;
}

.beschreibung {
border: black 3px solid;
border-radius:10px;
padding-top:15px;
padding-bottom:15px;
width:1000px;
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
margin-bottom:15px;
margin
}

.infotext {
border:navy 2px solid; 
border-radius:20px;
padding-right:10px;
padding-left:10px;
text-align: center;
background-color: white;
}

.aufgabengruppen {
margin-right:200px;
margin-left:200px;
text-align: center;
}

.Frage {
margin-bottom:5px;
}

.buttonStelle {
margin-top:10px;
}

.button {
position: relative;
margin-top:2px;
margin-left:10px;
border-radius:5px;
padding-left: 20 px;
background-color: #BDBDBD;
border-color:#000000;
border-width:1px;
font-size: 16px;
color: #FFFFFF;
padding: 10px;
width: 100px;
text-align: center;
transition-duration: 0.4s;
text-decoration:  none;

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
<div class = 'Webseite'> 
<script>
//Auslesen der Datenbank

    var path = " https://scenario.laknet.de/";
    var requestURL = path + 'scenario';
    var request = new XMLHttpRequest();
    request.open("get", requestURL);
    request.responseType = 'json';
    request.send();
    request.onload = function() {
        var jsonResult = <?php echo json_encode($scenario, JSON_HEX_TAG); ?>;
        if (Object.keys(jsonResult).length < 2){
            document.getElementById("titel").innerHTML = Object.keys(jsonResult);
            jsonResult = jsonResult[Object.keys(jsonResult)[0]];
        }

        //Allgemeine Angaben zum Scenario
        document.getElementById("titel").innerHTML = jsonResult['title'];
        document.getElementById("description").innerHTML = jsonResult['description'];
        document.getElementById('scenariobild').src = path + jsonResult['image'];
        //Anzahl der Taskgroups auslesen
        for (var i = 0; i < jsonResult['task_groups'].length; i++){
            //Gruppe (taskgroups)
            var wrapper = document.getElementById('gruppenwrapper');
            //json der aufgabengruppe
            var aufgabengruppe = jsonResult['task_groups'][i];
            var subtitle = document.createElement('h2'); 
            
            subtitle.innerHTML = aufgabengruppe['title'];
            //Formatierung
            wrapper.setAttribute('class', 'aufgabengruppen');
            wrapper.appendChild(subtitle);
            
            //Infotext
            for (var j = 0; j < aufgabengruppe['info_texts'].length; j++){
                    var infotextgruppe = aufgabengruppe['info_texts'][j]; //json der infotextgruppe
                    //Infotext Titel ausgeben
                    var infotitleElement = document.createElement('h3');
                    infotitleElement.innerHTML = infotextgruppe['title'];
                    wrapper.appendChild(infotitleElement);
                    //Infotextbeschreibung ausgeben
                    var bodyElement = document.createElement("div");
                    bodyElement.innerHTML = infotextgruppe['body'];
                    bodyElement.setAttribute('class', 'infotext');
                    wrapper.appendChild(bodyElement);
            }
            
            //Aufgaben
            for (var k = 0; k < aufgabengruppe['tasks'].length; k++){
                var loesung =  (jsonResult['task_groups'][i]['tasks'][k]['correct_answer']);
                /*if (jsonResult['task_groups'][i]['tasks'][k]['type'] == "multiple_choice"){
                    loesung = jsonResult['task_groups'][i]['tasks'][k]['possible_answers'].map(x => x.)
                }*/
                var aufgaben = aufgabengruppe['tasks'][k]; //json der aufgaben
                //Aufgabentitel ausgeben
                var aufgabentitelElement = document.createElement('h4');
                aufgabentitelElement.innerHTML = aufgaben['title'];
                wrapper.appendChild(aufgabentitelElement);
                //Frage ausgeben
                var questionElement = document.createElement("div");
                questionElement.innerHTML = aufgaben['question'];
                wrapper.appendChild(questionElement);
                questionElement.setAttribute('class', 'Frage');
                
                
                switch(aufgaben['type']){
                    case "numeric" : 
                        var input = document.createElement('input');						
                        input.type = 'number';
                        wrapper.appendChild(input);
                        input.setAttribute('id', loesung); 
                        break;
                    case "multiple_choice":
                        var possible_answers = Object.values(aufgaben['possible_answers']);
                        var container = document.createElement('div');
                        //alert(possible_answers.length);
                        for(var l = 0; l < possible_answers.length; l++) {
                            var checkbox = document.createElement('input');
                            checkbox.type = "checkbox";
                            checkbox.name = "aufgaben";
                            // Ist Antwort korrekt? '0' ist nicht korrekt, '1' ist korrekt
                            var is_correct = possible_answers[l].is_correct;
                            //alert(is_correct);
                            checkbox.value = possible_answers[l].is_correct;
                            checkbox.id = l;
                            
                            var lable = document.createElement('label');
                            lable.htmlFor = l;
                            lable.appendChild(document.createElement('br'));
                            container.appendChild(checkbox);
                            container.appendChild(document.createTextNode(possible_answers[l].answer));
                            container.appendChild(lable);
                        }
                        //container.setAttribute('id', 'input' + index);
                        wrapper.appendChild(container);
                        break;
                    case "text" : 
                        var input = document.createElement('input');
                        input.type = 'text';
                        wrapper.appendChild(input);
                        input.setAttribute('id', loesung); 
                        break;
                    
                }
                var button = document.createElement('button');
                button.innerHTML = 'Prüfen';
                button.setAttribute('id', loesung);
                button.setAttribute('class', 'button');				
                wrapper.appendChild(button);
                button.onclick = function(event) {
                    var ID = event.target.id;
                    /*
                    alert(ID);
                    alert(document.getElementById(ID).value)	
                    
                    if (jsonResult['task_groups'][i]['tasks'][k]['type'] == "multiple_choice") {
                        for (var l = 0; l < possible_answers.length; l++) {
                            if (possible_answer[l].is_correct == )
                        }
                    }
                    */
                    
                    if (document.getElementById(ID).value == ID) {
                        document.getElementById(ID).style.backgroundColor = 'green';}
                    else {
                        document.getElementById(ID).style.backgroundColor = 'red';}
                }
            }
            
        }
        
        
    } 	

</script>

<body>
    <h1 id = "titel">Der Titel des Scenario</h1>
    <div class = 'beschreibungmitte'> 
    <p id = "description" class = 'beschreibung'>Beschreibung des Scenarios</p> 
    </div>
    <div class = 'image'> <img id = "scenariobild"/> </div>
    <div id = "gruppenwrapper">
    <div id = 'info_texts'> 
        <div id = 'tasks'> 
        </div>
    </div>
    </div>
    <p>&nbsp;</p>
</body>
