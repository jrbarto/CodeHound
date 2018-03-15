var github_user = document.currentScript.getAttribute('github_user');
var github_pass = document.currentScript.getAttribute('github_pass');
var github_org = document.currentScript.getAttribute('github_org');

var reposContainer = document.getElementById("repos");
reposContainer.innerHTML = "";
var head = document.createElement("h5");
head.setAttribute("class", "center teal-text");

reposContainer.appendChild(head);
head.innerHTML = "Repos for the " + github_org + " organization:";
