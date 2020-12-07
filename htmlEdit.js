//these functions are used to get called upon when needed in webpages
//the addBreak function is used to add a <br> element to the input field
function addBreak() {
    document.getElementById("theInput").innerHTML += "<br>";
}
//the addLink function is used to add a <a href=''></a> element to the input field
//the element will take in the information inputed by the user
function addLink(form) {
    document.getElementById("theInput").innerHTML += "<a href='" + form.link.value + "'>" + form.name.value + "</a>";
    return false;
}