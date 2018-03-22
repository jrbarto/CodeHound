var json = document.currentScript.getAttribute("scripts");
var jsonObject = JSON.parse(json);
var scripts = jsonObject.scripts;
var container = document.getElementById("scripts");
var section = document.createElement("div");
section.setAttribute("class", "section");

for (i = 0; i < scripts.length; i++) {
  var script = scripts[i];
  /* Remove everything but the filename */
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
  checkbox.setAttribute("type", "checkbox");
  checkbox.setAttribute("class", "filled-in")
  checkbox.setAttribute("id",  "check" + i);

  checkbox.checked = active;

  activeContainer.appendChild(checkbox);
  var label = document.createElement("label");
  label.setAttribute("for", "check" + i);
  label.innerHTML = "Active";
  activeContainer.appendChild(label);
  checkbox.active = active;
  checkbox.row = row;
  checkbox.scriptId = scriptId;
  checkbox.addEventListener("click", function(e) {
    checkUncheck(this.active, this.row, this.scriptId);
  });
}

container.appendChild(section);

function checkUncheck(active, row, scriptId) {
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

  if (active) {
    var cardText = "Deactivating groovy script...";
    cardTitle.innerHTML = cardText;
    cardContent.appendChild(cardTitle);
  }
  else {
    var cardText = "Activating groovy script...";
    cardTitle.innerHTML = cardText;                                                                                     
    cardContent.appendChild(cardTitle);                                                                                 
  }
  
  $.ajax({
    url: "/CodeHound/php/toggle_script.php",
    type: "POST",
    data: {
      scriptId: scriptId,
      active: active
    },
    success: function(data) {
      cardPanel.remove();
      active = !active;
    }
  });  

}
