var pid = "none";
function showhide(id) {
  var elements = document.getElementById(id).childNodes;
  var menu = elements[3];
  var arrow = ((elements[1].childNodes)[4].childNodes)[1];
  if(menu.style.display == 'block') {
    menu.style.display = "none";
    arrow.style.transform = "rotate(0deg)";
    elements[1].style.color = "black";
  }
  else {
    menu.style.display = "block";
    arrow.style.transform = "rotate(270deg)";
    elements[1].style.color = "#ff5252";
  }
  if(pid == id)
    pid = "none";
  if(pid != "none") {
    elements = document.getElementById(pid).childNodes;
    menu = (document.getElementById(pid).childNodes)[3];
    arrow = ((elements[1].childNodes)[4].childNodes)[1];
    if(menu.style.display == 'block') {
      menu.style.display = "none";
      arrow.style.transform = "rotate(0deg)";
      elements[1].style.color = "black";
    }
  }
  pid = id;
}
function showOptions() {
  var flag = document.getElementById('options');
  if(flag.style.display == 'block') {
    flag.style.display = "none";
    document.getElementById('mark').style.display = "none";
  }
  else {
    flag.style.display = "block";
    document.getElementById('mark').style.display = "block";
  }
}
function search() {
   // Prompt the user to enter a search term
   var searchTerm = prompt("Enter a search term:");
   if (searchTerm === null || searchTerm === "") {
       return; // Do nothing if the user cancels or doesn't enter a search term
   }
   
   // Find all links that contain the search term within the tosearch div
   var matchingLinks = [];
   var links = document.getElementById("tosearch").getElementsByTagName("a");
   for (var i = 0; i < links.length; i++) {
       if (links[i].textContent.includes(searchTerm)) {
           matchingLinks.push(links[i]);
       }
   }
   
   if (matchingLinks.length === 0) {
       alert("No matching links found.");
   } else if (matchingLinks.length === 1) {
       // If there's only one matching link, go to that page
       window.location = matchingLinks[0].href;
   } else {
       // If there are multiple matching links, display their names in a prompt and allow the user to choose one
       var linkNames = "";
       for (var i = 0; i < matchingLinks.length; i++) {
           linkNames += (i + 1) + ". " + matchingLinks[i].textContent + "\n";
       }
       var choice = prompt("Multiple matching links found. Enter the number of the link you want to follow:\n" + linkNames);
       if (choice === null || choice === "") {
           return; // Do nothing if the user cancels
       }
       choice = parseInt(choice);
       if (choice > 0 && choice <= matchingLinks.length) {
           window.location = matchingLinks[choice - 1].href;
       }
   }
}
