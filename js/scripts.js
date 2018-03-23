var json = document.currentScript.getAttribute("scripts");
var jsonObject = JSON.parse(json);
var scripts = jsonObject.scripts;
var container = document.getElementById("scripts");
var section = document.createElement("div");
section.setAttribute("class", "section");

for (i = 0; i < scripts.length; i++) {
  var script = scripts[i];
  var fullPath = script.path;
  console.log("FULL PATH IS " + fullPath);
  /* Remove everything but the filename */
  var path = fullPath.replace(/^.*[\\\/]/, '');
  var active = script.active;
  var scriptId = script.id;
  var row = document.createElement("div");
  row.setAttribute("class", "row");
  section.appendChild(row);
  var toast = document.createElement("div");
  toast.setAttribute("class", "toast");
  row.appendChild(toast);

  /* Create groovy script label */
  var pathContainer = document.createElement("div");
  pathContainer.setAttribute("class", "container left");
  toast.appendChild(pathContainer);
  var span = document.createElement("span");
  span.setAttribute("class", "left");
  span.innerHTML = path;
  pathContainer.appendChild(span);
  
  /* Create checkbox to toggle active scripts */
  var activeContainer = document.createElement("div");
  activeContainer.setAttribute("class", "container center");
  toast.appendChild(activeContainer);
  var checkbox = document.createElement("input");
  checkbox.setAttribute("type", "checkbox");
  checkbox.setAttribute("class", "filled-in")
  checkbox.setAttribute("id",  "check" + i); // Unique id
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
    this.active = !this.active; // Store inverse of active
  });

  /* Create button to remove a script */
  var removeContainer = document.createElement("div");
  removeContainer.setAttribute("class", "container right");
  toast.appendChild(removeContainer);
  var button = document.createElement("button");
  button.setAttribute("class", "btn waves-effect waves-light red right");
  button.innerHTML = "Uninstall";
  removeContainer.appendChild(button);
  var icon = document.createElement("i");                                                                     
  icon.setAttribute("class", "material-icons right");                                                         
  icon.innerHTML = "delete_forever";                                                                                    
  button.appendChild(icon);
  button.fullPath = fullPath;
  button.row = row;
  button.addEventListener("click", function(e) {
    uninstallScript(this.fullPath, this.row);
  });
}

container.appendChild(section);

function checkUncheck(active, row, scriptId) {
  var cardPanel;

  if (active) {
    var cardText = "Deactivating groovy script...";
    cardPanel = createDialogCard(row, cardText);
  }
  else {
    var cardText = "Activating groovy script...";
    cardPanel = createDialogCard(row, cardText);
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
    }
  });  
}

function uninstallScript(scriptPath, row, toast) {
  var cardText = "Uninstalling groovy script...";
  var cardPanel = createDialogCard(row, cardText);

  $.confirm({
      title: "Confirm Script Removal",
      content: "Are you sure? The script will be permanently removed from this user account",
      buttons: {
          confirm: function () {
            $.ajax({
              url: "/CodeHound/php/remove_script.php",
              type: "POST",
              data: {
                scriptPath: scriptPath,
              },
              success: function(data) {
                cardPanel.remove();
                row.remove();
              }
            });  
          },
          cancel: function () {
            cardPanel.remove();
          }
      }
  });
}

function createDialogCard(row, cardText) {
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
  cardTitle.innerHTML = cardText;
  cardContent.appendChild(cardTitle);

  return cardPanel;
}
