const GH_API = "https://api.github.com";
const HOOK_NAME = "web";

var github_auth = document.currentScript.getAttribute('github_auth');

var reposContainer = document.getElementById("repos");
var reposSection = document.createElement("div");
reposSection.setAttribute("class", "section");

var orgsRequest = new XMLHttpRequest();

/* Thread execution will continue after asynchronous request is made, state changes must be tracked */
orgsRequest.onreadystatechange = function() {
  /* Wait until request is complete */
  if (orgsRequest.readyState == XMLHttpRequest.DONE) {
    var response = orgsRequest.response;
    var orgs = JSON.parse(response);
    
    for (i = 0; i < orgs.length; i++) {
      var org = orgs[i];
      
      var orgHeader = document.createElement("h5");
      orgHeader.setAttribute("class", "center teal-text");
      orgHeader.innerHTML = org.login + " Repositories:";
      reposSection.appendChild(orgHeader);
      
      var repoRequest = new XMLHttpRequest();
      
      repoRequest.onreadystatechange = function() {
        if (repoRequest.readyState == XMLHttpRequest.DONE) {
          var repoResponse = repoRequest.response;
          var repos = JSON.parse(repoResponse);

          for (i = 0; i < repos.length; i++) {
            var repo = repos[i];
            var row = document.createElement("div");
            row.setAttribute("class", "row");
            orgHeader.appendChild(row);
            var toast = document.createElement("div");
            toast.setAttribute("class", "toast");
            row.appendChild(toast);
            var span = document.createElement("span");
            span.innerHTML = repo.name;
            toast.appendChild(span);

            /* Create active monitoring switch for pull requests */
            var swtch = document.createElement("div");
            swtch.setAttribute("class", "switch");
            toast.appendChild(swtch);
            var label = document.createElement("label");
            label.setAttribute("class", "white-text");
            swtch.appendChild(label);
            var offLabel = document.createTextNode("Off");
            var onLabel = document.createTextNode("Active Monitoring");
            label.appendChild(offLabel);
            var checkbox = document.createElement("input");
            checkbox.setAttribute("type", "checkbox");
            label.appendChild(checkbox);
            /* Store variables for use on checkbox button event */
            checkbox.hooksUrl = repo.hooks_url;
            checkbox.row = row;
            checkbox.addEventListener("click", function(e) {
              installWebhook(this.hooksUrl, this, this.row);
            });

            var lever = document.createElement("span");
            lever.setAttribute("class", "lever");
            label.appendChild(lever);
            label.appendChild(onLabel);
            isHookInstalled(repo.hooks_url, checkbox);

            /* Create button to launch a full repo review */
            var button = document.createElement("button");
            button.setAttribute("class", "btn waves-effect waves-light");
            button.innerHTML = "Full Review";
            toast.appendChild(button);
            var icon = document.createElement("i");
            icon.setAttribute("class", "material-icons right");
            icon.innerHTML = "send";
            button.appendChild(icon);
            /* Store variables for use on button event */
            button.repoPath = repo.full_name;
            button.repoUrl = repo.html_url;
            button.row = row;
            button.addEventListener("click", function(e) {
              runFullReview(this.repoPath, this.repoUrl, this.row);
            });
          }
        }
      }

      httpGet(org.repos_url, repoRequest);
    }

    reposContainer.innerHTML = "";
    reposContainer.appendChild(reposSection);
  }
}

httpGet(GH_API + "/user/orgs", orgsRequest);

function httpGet(url, request) {
  request.open("GET", url);
  request.setRequestHeader("Authorization", "Basic " + github_auth);
  request.setRequestHeader("Accept", "application/json");
  request.send();
}

function httpPost(url, request, body) {
  request.open("POST", url);
  request.setRequestHeader("Authorization", "Basic " + github_auth);
  request.setRequestHeader("Accept", "application/json");
  request.setRequestHeader("Content-Type", "application/json");
  request.send(body);  
}

function httpDelete(url, request) {
  request.open("DELETE", url);
  request.setRequestHeader("Authorization", "Basic " + github_auth);                                                    
  request.setRequestHeader("Accept", "application/json");                                                               
  request.send(); 
}

function runFullReview(fullRepo, repoUrl, row) {
  var cardText = "Executing a full review of this repository... "
    + "Please be patient, results will be displayed momentarily.";
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
   
  window.location.assign("/CodeHound/php/full_review.php?repo_path=" + fullRepo 
    + "&repo_url=" + repoUrl);
}

function isHookInstalled(hooksUrl, checkbox) {
  var getHook = new XMLHttpRequest();
  var installed = false;
  getHook.onreadystatechange = function() {
    if (getHook.readyState == XMLHttpRequest.DONE) {
      var hookResponse = getHook.response;
      var hooks = JSON.parse(hookResponse);
      for (i = 0; i < hooks.length; i++) { 
        var hook = hooks[i];
        if (hook.name == HOOK_NAME) {
          checkbox.checked = true;
          installed = true;
        }
      }
    }
  }
  httpGet(hooksUrl + "?" + Math.random(), getHook);
}

function installWebhook(hooksUrl, checkbox, row) {
  var getHook = new XMLHttpRequest();
  var cardText = "Searching for existing webhooks...";
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

  getHook.onreadystatechange = function() {
    if (getHook.readyState == XMLHttpRequest.DONE) {
      var hookResponse = getHook.response;
      var hooks = JSON.parse(hookResponse);
      var cardText = "";
      var removed = false;

      for (i = 0; i < hooks.length; i++) {
        var hook = hooks[i];
        if (hook.name == HOOK_NAME) {
          cardTitle.innerHTML = "Removing the Code Hound webhook...";
          var removeHook = new XMLHttpRequest();
          removeHook.onreadystatechange = function() {
            if (removeHook.readyState == XMLHttpRequest.DONE) {
              var removeResponse = removeHook.response;
              if (removeResponse.status == 204) {
                this.checkbox.checked = false;
              }
              cardPanel.remove();
            }
          }

          httpDelete(hooksUrl + "/" + hook.id, removeHook); 
          removed = true;
        }
      }

      if (!removed) {
        cardTitle.innerHTML = "Installing the Code Hound webhook...";
        var body = '{"name":"web","active":true,"events":["pull_request"],"config":'
          + '{"url":"http://tusk.pronow.net/CodeHound/php/pull_review.php","content_type":"json"}}';
  
        var createHook = new XMLHttpRequest();
        createHook.onreadystatechange = function() {
          if (getHook.readyState == XMLHttpRequest.DONE) {
            var createResponse = createHook.response;
            // Uncheck button upon successful webhook installation
            if (createResponse.states == 201) {
              checkbox.checked = true;
            }

            
            cardPanel.remove();
          }
        }

        httpPost(hooksUrl, createHook, body);
      }
    }
  }

  var noCacheUrl = hooksUrl + "?" + Math.random();
  httpGet(noCacheUrl, getHook);
}
