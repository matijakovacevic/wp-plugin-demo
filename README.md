Wordpress Plugin

Potrebno je kreirati Wordpress Plugin, napisan objektno prema PSR-2 coding standardu.  Plugin mora imati slijedeće funkcionalnosti:

###GENERIRANJE SHORTCODOVA

Jedna od funkcionalnosti plugina biti će generiranje shortcodova prema konfiguraciji iz "array" varijable.

Primjer shortcode konfiguracije (jedna stavka iz liste u konfiguraciji):
```
$shortCode = [
    'name' => string,
    'icon' => string
    'content' => bool // Definira hoće li shortcode imati content i treba li se generirati close tag
    'action' => function ($atts, $content, $tag) {   // closure
    }
];
```

PHP Klasa mora pokupiti konfiguraciju te iz toga generirati shortcodove.

Za primjer staviti minimalno jedan shortcode u konfiguraciju koji će generirati <video>, <audio> tag i/ili neki drugi HTML5 tag.

###WIDGET

Plugin mora generirati  widget koji će prikazivati jednostavan HTML5 + JS kalkulator u sidebaru templatea. Widget mora biti razvijen po MVC principima.

    Kalkulator
    - mora imati osnovne računske operacije (zbrajanje, oduzimanje, množenje i dijeljenje),
    - mora imati dio za prikaz unosa
    - gumbove za unos: brojki od 0-9, simbola računskih operacija, gumb „=“ za prikaz rezultata i „C“ za resetiranje/brisanje stanja
    - mora se slijediti HTML5 sintaksa/sintagma a javascript mora biti objektno orijentiran.
    - ne smije se koristiti jQuery ili sličan library.
    - može se koristiti Twitter Bootstrap ili neki drugi CSS framework.
    - može imati proizvoljan dizajn. (Dizajn nije presudan)
