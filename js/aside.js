var path = window.location.pathname;

// find the active link in the sidebar
var links = document.querySelectorAll('.main-menu a');
for (var i = 0; i < links.length; i++) {
  var linkPath = "/atdc/"+String(links[i].getAttribute('href'));
  if (linkPath === path) {
    links[i].parentElement.classList.add('active');
    
  }
}