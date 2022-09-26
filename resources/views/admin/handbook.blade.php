<div class="bg-white rounded-top shadow-sm mb-3">

    <div class="row g-0">
        <div class="col col-lg-6 mt-6 p-4 pe-md-0">

            <h2 class="mt-2 text-dark fw-light">
                {{ __('Welcome to the Scenario Creator handbook!') }}
            </h2>
        </div>
        <div class="col col-lg-6 mt-6 p-4 pe-md-0">
            <img style="max-height: 100px;" class="img-fluid" src="{{ __('/img/co-financed-EU-en.png') }}"
                 alt="{{ __('Co-financed by the European Union') }}"/>
        </div>
    </div>

    <style>
        .section {
            margin-bottom: 25px;
        }
    </style>
    <div id="wrapper">
        <div class="container">
            <div class="row">
                <div class="col-md-3">
                    <nav class="docs-sidebar sticky-top" id="navbar-handbook" data-offset-top="300"
                         data-offset-bottom="200" role="navigation">
                        <ul>
                            <li><a href="#line1">Einführung</a></li>
                            <li><a href="#line2">Erstellen eines Szenarios</a></li>
                            <li><a href="#line3">Erstellen einer Aufgaben-Gruppe</a></li>
                            <li><a href="#line4">Erstellen von Info-Texten</a></li>
                            <li><a href="#line5">Erstellen von Aufgaben</a>
                                <ul>
                                    <li><a href="#line5_1">Allgemeines</a></li>
                                    <li><a href="#line5_2">Multiple-Choice Aufgaben</a></li>
                                    <li><a href="#line5_3">Multiple-Choice Bild Aufgaben</a></li>
                                    <li><a href="#line5_4">Text Aufgaben</a></li>
                                    <li><a href="#line5_5">Numerische Aufgaben</a></li>
                                </ul>
                            </li>
                        </ul>
                    </nav>
                </div>
                <div data-spy="scroll" data-target="#navbar-handbook" data-offset="0" class="col-md-9">
                    <section id="line1" class="section">
                        <h2 class="dark-text">
                            Einführung
                            <hr>
                        </h2>

                        <div class="row">
                            <div class="col-md-12">
                                <p>
                                    <h4 class="dark-text">“Scenario Games”</h4>
                                    Mit unserem Projekt greifen wir die bereits bewährte Freizeit-Aktivität der Online-Escape-Games 
                                    auf, bei denen durch schrittweises Lösen unterschiedlichster Rätsel ein
                                    übergeordneter Fall aufgeklärt werden muss. Ziel ist es, diese Idee so weiterzuentwickeln,
                                    dass auch Lernen mit einem solchen spielerischen und interaktiven Ansatz verknüpft wird, genannt “Scenario Games”.
                                    <h4 class="dark-text">Szenario</h4>
                                    Das Spiel besteht aus verschiedenen Szenarien.
                                    Hierbei besteht ein Szenario aus mehreren Aufgabenbereichen, welche sich wiederum aus unterschiedlichen Aufgaben zusammensetzen.
                                    Mögliche Aufgabenarten sind Multiple-Choice, Textaufgaben und Numerische Aufgaben.
                                    Um ein Szenario erfolgreich abzuschließen müssen die Aufgaben aus den verschiedenen Aufgabenbereichen gelöst werden.

                                </p>
                            </div>
                            <!-- end col -->
                        </div>
                        <!-- end row -->
                    </section>
                    <!-- end section -->

                    <section id="line2" class="section">
                        <h2 class="dark-text">
                            Erstellen eines Szenarios
                            <hr>
                        </h2>

                        <div class="intro2 clearfix">
                            <p>
                                <ol>
                                    <li>Klicken Sie oben links auf <b>Szenarien</b>. Dort finden Sie alle Szenarien</li>
                                    <li>Klicken Sie oben rechts auf <b>Hinzufügen</b></li>
                                    <li>Legen Sie einen Titel fest, laden sie optional ein Bild hoch und schreiben Sie eine kurze Beschreibung des entsprechenden Szenarios</li>
                                    <li>Klicken Sie oben links auf Create Scenario</li>
                                    <li>Wählen Sie mit welchen Nutzergruppen Sie dieses Szenario teilen wollen unter "Nutzergruppen, mit denen dieses Szenario geteilt wird"</li>
                                </ol>
                                Um ihre eigenen Szenarien zu sehen gehen Sie zu <b>Meine Szenarien</b>.
                                <p>
                                Dort können Sie auf die 3 Punkte rechts klicken und <b>bearbeiten</b> wählen um das Szenario zu bearbeiten oder Aufgabengruppen hinzuzufügen.
                                </p>
                            </p>
                        </div>


                    </section>
                    <!-- end section -->

                    <section id="line3" class="section">
                        <h2 class="dark-text">Erstellen einer Aufgabengruppe
                            <hr>
                        </h2>

                        <p>
                            <ol>
                                <li>Gehen Sie zunächst zu ihrem Szenario, der Sie eine neue Aufgabengruppe hinzufügen wollen wie unten in <a href="#line2"><u>Erstellen eines Szenarios</u></a> beschrieben</li>
                                <li>Scrollen Sie nach unten und klicken Sie auf <b>Aufgabengruppe hinzufügen</b></li>
                                <li>Geben Sie nun einen Titel ein</li>
                                <li>Klicken Sie oben rechts auf <b>Aufgabengruppe erstellen</b></li>
                            </ol>
                            Dort haben Sie nun zahlreiche Möglichkeiten:
                            <ol>
                                <li><a href="#line4"><u>Infotext hinzufügen</u></a></li>
                                <li><a href="#line5_2"><u>Multiple-Choice-Aufgabe hinzufügen</u></a></li>
                                <li><a href="#line5_4"><u>Textaufgabe hinzufügen</u></a></li>
                                <li><a href="#line5_3"><u>Multiple-Choice-Aufgabe mit Bildern hinzufügen</u></a></li>
                                <li><a href="#line5_5"><u>Numerische Aufgabe hinzufügen</u></a></li>
                            </ol>
                        </p>
                    </section>
                    <!-- end section -->

                    <section id="line4" class="section">
                        <h2 class="dark-text">
                            Erstellen von Info Texten
                            <hr>
                        </h2>

                        <p>
                            <ol>
                                <li>Navigieren Sie zur Aufgabengruppe in einem Szenario wo Sie den Infotext hinzufügen möchten</li>
                                <li>Klicken Sie auf <b>Infotext hinzufügen</b></li>
                                <li>Geben Sie nun einen Titel für den Infotext an und den Infotext selbst</li>
                                <li>Klicken Sie auf <b>Infotext erstellen</b> um den Infotext zu erstellen</li>
                            </ol>
                            Beim erstellen des Infotextes haben sie viele angezeigte Gestaltungsmöglichkeiten.
                        </p>
                    </section>
                    <section id="line5" class="section">
                        <h2 class="dark-text">
                            Erstellen von Aufgaben
                            <hr>
                        </h2>

                        <h3 id="line5_1">Allgemeines</h3>
                        <p>Aufgaben beinhalten immer einen Titel und eine entsprechende Frage die es zu lösen gilt.
                            Falls Sie eine Aufgabe erstellen wollen, folgen Sie den folgenden Schritten unter der jeweiligen Aufgabenkategorie.
                            Zunächst müssen Sie allerdings zu der Aufgabengruppe navigieren die Sie bearbeiten möchten.
                        </p>
                        <h3 id="line5_2">Multiple-Choice Aufgaben</h3>
                        <p>
                            <ol>
                                <li>Klicken Sie auf <b>Multiple-Choice-Aufgabe hinzufügen</b></li>
                                <li>Geben Sie dort Titel und Frage an</li>
                                <li>Drücken Sie bei den Antwortmöglichkeiten auf <b>Zeile hinzufügen</b>. Sie können dann eine Antwortmöglichkeit eingeben und angeben ob diese korrekt ist, indem sie das Kästchen daneben anklicken. Diesen Prozess können sie beliebig oft wiederholen</li>
                                <li>Klicken Sie auf <b>Aufgabe erstellen</b> um die Aufgabe zu Ihrer Aufgabengruppe hinzuzufügen</li>
                            </ol>
                            Bei diesen Aufgaben können mehrere Antworten richtig sein. Dafür kreuzen sie einfach bei <b>Korrekt</b> mehrere von Ihnen angebene Antwortmöglichkeiten an.
                        </p>
                        <h3 id="line5_3">Multiple-Choice Bild Aufgaben</h3>
                        <p>
                            <ol>
                                <li>Klicken Sie auf <b>Multiple-Choice-Aufgabe mit Bildern hinzufügen</b></li>
                                <li>Geben Sie dort Titel und Frage an</li>
                                <li>Drücken Sie bei den Antwortmöglichkeiten auf <b>Zeile hinzufügen</b>. Sie können dann auf <b>Durchsuchen</b> klicken um Bilder als Antwortmöglichkeit hochzuladen. Ob dieses Bild als richtig bei einer Auswahl gewertet werden soll, bestimmt der "Korrekt" Knopf daneben. Führen Sie diesen Schritt mehrmals aus um mehrere Antwortmöglichkeiten einzurichten</li>
                                <li>Klicken Sie auf <b>Aufgabe erstellen</b> um die Aufgabe zu Ihrer Aufgabengruppe hinzuzufügen</li>
                            </ol>
                        </p>
                        <h3 id="line5_4">Text Aufgaben</h3>
                        <p>
                            <ol>
                                <li>Klicken Sie auf <b>Textaufgabe hinzufügen</b></li>
                                <li>Geben Sie dort Titel und Frage an</li>
                                <li>Tragen Sie die korrekte Antwort in den Bereich "Korrekte Antwort" ein</li>
                                <li>Klicken Sie auf <b>Aufgabe erstellen</b> um die Aufgabe zu Ihrer Aufgabengruppe hinzuzufügen</li>
                            </ol>
                        </p>
                        <h3 id="line5_5">Numerische Aufgaben</h3>
                        <p>
                            <ol>
                                <li>Klicken Sie auf <b>Numerische Aufgabe hinzufügen</b></li>
                                <li>Geben Sie dort Titel und Frage an</li>
                                <li>Tragen Sie die korrekte numerische Antwort in den Bereich "Korrekte Antwort" ein</li>
                                <li>Klicken Sie auf <b>Aufgabe erstellen</b> um die Aufgabe zu Ihrer Aufgabengruppe hinzuzufügen</li>
                            </ol>
                        </p>

                    </section>
                    <!-- end section -->
                </div>
                <!-- // end .col -->

            </div>
            <!-- // end .row -->

        </div>
        <!-- // end container -->

    </div>
    <!-- end wrapper -->
</div>

