const GH_API = "https://api.github.com";

var github_auth = document.currentScript.getAttribute('github_auth');

var reposContainer = document.getElementById("repos");
reposContainer.innerHTML = "";

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
      reposContainer.appendChild(orgHeader);
      
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
            var lever = document.createElement("span");
            lever.setAttribute("class", "lever");
            label.appendChild(lever);
            label.appendChild(onLabel);

            /* Create button to launch a full repo review */
            var button = document.createElement("button");
            button.setAttribute("class", "btn waves-effect waves-light");
            button.innerHTML = "Full Review";
            toast.appendChild(button);
            var icon = document.createElement("i");
            icon.setAttribute("class", "material-icons right");
            icon.innerHTML = "send";
            button.appendChild(icon);
          }
        }
      }

      httpGet(org.repos_url, repoRequest);
    }
  }
}

httpGet(GH_API + "/user/orgs", orgsRequest);

function httpGet(url, request) {
  request.open("GET", url);
  request.setRequestHeader("Authorization", "Basic " + github_auth);
  request.setRequestHeader("Accept", "application/json");
  request.send();
}

function runFullReview(fullRepo) {
  
}
