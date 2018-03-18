var json = document.currentScript.getAttribute("scripts");
console.log(json);
var jsonObject = JSON.parse(json);
var scripts = jsonObject.scripts;
console.log(document.location.href);
var container = document.getElementById("scripts");
console.log(container);
var section = document.createElement("div");
section.setAttribute("class", "section");

for (i = 0; i < scripts.length; i++) {
  var script = scripts[i];
  var path = script.path.replace(/^.*[\\\/]/, '');
  var active = script.active;
  var scriptId = script.id;
  var row = document.createElement("div");
  row.setAttribute("class", "row");
  section.appendChild(row);
  var toast = document.createElement("div");
  toast.setAttribute("class", "toast");
  row.appendChild(toast);
  var pathContainer = document.createElement("div");
  pathContainer.setAttribute("class", "container left");
  toast.appendChild(pathContainer);
  var span = document.createElement("span");
  span.innerHTML = path;
  pathContainer.appendChild(span);
  
  var activeContainer = document.createElement("div");
  activeContainer.setAttribute("class", "container right");
  toast.appendChild(activeContainer);
  var checkbox = document.createElement("input");
  checkbox.setAttribute("class", "filled-in")
  checkbox.setAttribute("id",  "check" + i);
  activeContainer.appendChild(checkbox);
  var label = document.createElement("label");
  label.setAttribute("for", "check" + i);
  label.innerHTML = "Active";
  activeContainer.appendChild(label);
  checkbox.active = active;
  checkbox.row = row;
  checkbox.scriptId = scriptId;
  checkbox.addEventListener("click", function(e) {
    checkUncheck(this, this.active, this.row, this.scriptId);
  });
}

container.appendChild(section);

function checkUncheck(checkbox, active, row, scriptId) {
  var cardPanel = document.createElement("div");
  cardPanel.setAttribute("class", "card-panel teal");
  row.insertAdjacentElement("afterend", cardPanel);
  var card = document.createElement("div");
  card.setAttribute("class", "card teal");
  cardPanel.appendChild(card);
  var cardContent = document.createElement("div");                                                                      
  cardContent.setAttribute("class", "card-content center");                                                             
  card.appendChild(cardContent);                                                                                        
  var cardTitle = document.createElement("span");                                                                       
  cardTitle.setAttribute("class", "white-text card-title");                                                             

  console.log("ACTIVE IS " + active);
  if (active) {
    var cardText = "Deactivating groovy script...";
    cardTitle.innerHTML = cardText;
    cardContent.appendChild(cardTitle);
    checkbox.checked = "false";
    checkbox.active = 0;
  }
  else {
    var cardText = "Activating groovy script...";
    cardTitle.innerHTML = cardText;                                                                                     
    cardContent.appendChild(cardTitle);                                                                                 
    checkbox.checked = "true";
    checkbox.active = 1;
  }

  $.ajax({
    url: "/CodeHound/php/deactivate.php",
    type: "POST",
    dataType: "json",
    data: {
      scriptId: this.scriptId,
      active: this.active
    }
  });  
}
