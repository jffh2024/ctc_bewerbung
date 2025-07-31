// Funktion, die die Google-Suche mit dem eingegebenen Suchbegriff ausführt
function performSearch() {
  // Wert aus dem Suchfeld (Input mit id "searchInput") auslesen
  var searchTerm = document.getElementById('searchInput').value;
  
  // Google-Such-URL mit dem Suchbegriff (URL-kodiert) zusammenbauen
  var searchUrl = 'https://www.google.com/search?q=' + encodeURIComponent(searchTerm);
  
  // Neue Browser-Registerkarte öffnen und Google-Suchergebnisse anzeigen
  window.open(searchUrl, '_blank');
}
