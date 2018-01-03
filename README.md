# README
## Überlegungen
Server Anforderungen so gering wie möglich halten und unnötigen Overhead vermeiden!

**Ablauf**:  
1. CLI Command wird mit dem Suchbegriff und der maximalen Ergebnisanzahl gestartet
2. Es wird der ``GoogleCrawler`` gestartet, der per Dependency Injection  einen HttpClient (in diesem Fall eine ``GuzzleHttp\Client`` Instanz) erhält. 
(Zu Testzwecken kann hier der ``DummyClient`` übergeben werden)
3. Der ``GoogleCrawler`` kalkuliert wieviele Anfragen an Google gestellt werden müssen. 
(Google zeigt nur 10 Ergebnisse pro "Seite"). 
Der Crawler muss also die Paginierung abarbeiten. 
**Wichtig:** Unbedingt vermeiden, dass Google uns ein Captcha vorsetzt! ~> Erstmal per Timeout "Pause" lösen.
4. Die HTML Antwort wird an den ``GoogleResponseParser`` weiter gereicht
5. Der ``GoogleResponseParser`` navigiert per XPath durch die Suchergebnisse und instanziert pro Ergebnis ein ``SearchResult`` Objekt.
6. Die einzelnen ``SearchResult`` Objekte extrahieren den Titel, den Link und die Beschreibung des Suchergebnisses.
7. Ab hier wird das PDF generiert 


## Zukünftige Verbesserungen / Todos:
- Status Codes von Google prüfen und entsprechend reagieren
- Output Verbosity per Input Option steuern
- Loggin anbieten / einbauen
