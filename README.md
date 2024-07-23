***Wichtig:*** *Dieses Projekt ist unfertig und verfügt über keine gescheite Dokumentation. Dieses Projekt ist unter der MIT Lizenz lizensiert. Falls du also mit diesem Projekt anfangen möchtest, steht es dir so gut wie frei zur Verfügung.*

<br>

Abizeitung-v3
=============

Das hier ist die dritte Version der Abizeitungsapp. Die Abizeitungsapp soll für die Schulen und Abschlussklassen den Prozess der Informationssammlung für die Abizeitung vereinfachen und digitalisieren. Der Name der App sollte "Abibuzz" heißen und kommt deshalb in dem Projekt öfters vor.

Die Abizeitungsapp soll folgenden **Funktionsumfang** bieten:

1. Gruppen und Einrichtungen erstellen
2. *Beichten (unfertig)*
3. *Storys (unfertig)*
4. *Zitate (unfertig)*
5. *Abstimmungen (unfertig)*
6. *Umfragen (unfertig)*
7. *Rankings (unfertig)*
8. *Steckbriefe (unfertig)*

## Besonderheiten an dieser Version

1. Das Design dieser Version ist am Design der iOS Apple Music App orientiert.
2. Passwort verifizierung erfolgt über gespeicherte Passwort Hashes mittels bcrypt.
3. JSON Web Tokens für Authentifizierungs- und Autorisierungszwecke in dieser Webanwendung.

## Verbindung mit der Datenbank

Die Datenbank nennt sich `abibuzz`. Passwort lautet `""` (leer) und der Benutzername der Datenbank lautet `root` (Aufgrund der Default-Einstellungen des [XAMPP Servers](https://www.apachefriends.org). Konfiguriert können diese Einstellungen in der `config.php` Datei im `hypertext-processor` Verzeichnis.

Die Datenbank ist in dem Verzeichnis als `abibuzz.sql` zu finden.

## Eingeschränkte Funktionsfähigkeit

Diese Version ist noch nicht fertig und wird nicht mehr von mir fertig gestellt werden. Aufgrund von Datenschutz ist diese App noch eingeschränkter, da die Funktionierenden Tabellen gelöscht werden mussten aufgrund von noch eingetragener Daten verschiedener Schüler.

## Admin Anmeldedaten

Benutzername: `TimothyKli` <br>
Passwort: `nTSqB6hwRyJp`

<br>

## Verwendete Bibliotheken

Dieses Projekt verwendet die folgenden Drittanbieter-Bibliotheken:

- [ramsey/uuid](https://github.com/ramsey/uuid) - Eine PHP-Bibliothek zum Erzeugen von UUIDs, lizenziert unter der [MIT-Lizenz](https://github.com/ramsey/uuid/blob/master/LICENSE).
- [firebase/php-jwt](https://github.com/firebase/php-jwt) - Eine PHP-Bibliothek zur Erstellung und Verifizierung von JSON Web Tokens, lizenziert unter der [BSD-3-Clause-Lizenz](https://github.com/firebase/php-jwt/blob/master/LICENSE).
- Firebase - Verschiedene Dienste und Bibliotheken von Firebase, lizenziert unter der [Apache License 2.0](https://www.apache.org/licenses/LICENSE-2.0).
