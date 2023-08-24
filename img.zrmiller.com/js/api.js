let apiWrapperDiv;

function scrollToTop(){
    apiWrapperDiv.scrollTo(apiWrapperDiv.scrollX, 0);
}

function init(){
    apiWrapperDiv = document.getElementById("apiWrapper")
}

window.addEventListener("DOMContentLoaded", init);