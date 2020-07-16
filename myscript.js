'use strict';

function hideProduct(workObject){
    workObject.parentElement.parentElement.remove();
}

function refreshPage(){
    document.location.reload(true);
}

function changeValue(workObject){
    let valueContainer = workObject.parentElement.querySelector("span");
    if (workObject.className === 'plus'){
        valueContainer.innerText = (parseInt(valueContainer.innerText)+1).toString();
    } else {
        valueContainer.innerText = (parseInt(valueContainer.innerText)-1).toString();
    }
}

function createRequest(actionFunc, requestBody) {
    let httpRequest = new XMLHttpRequest();
    httpRequest.onreadystatechange = function(){
        if (httpRequest.readyState === 4 && httpRequest.status === 200) {
            actionFunc();
        }
    };

    httpRequest.open("POST", "ajax_handler.php");
    httpRequest.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    httpRequest.send(requestBody);
}

function sendHideProductRequest () {
    const button = this;
    let id = this.parentElement.parentElement.dataset.productid;
    createRequest(hideProduct(button),"ajax_id="+id)
}

function sendRevealAllRequest() {
    createRequest(refreshPage,"revealAll");
}

function sendChangeQuantityRequest(){
    const workObject = this;
    let id = this.parentElement.parentElement.dataset.productid;
    createRequest(changeValue(workObject),"ajax_id="+id+"&change="+this.className);

}

function addListeners() {
    let hiderButtons = document.getElementsByClassName("hideButton");
    for (let i = 0; i < hiderButtons.length; i++) {
        hiderButtons[i].addEventListener("click", sendHideProductRequest);
    }

    let valueButtons = document.querySelectorAll(".minus, .plus");
    for (let i = 0; i < valueButtons.length; i++) {
        valueButtons[i].addEventListener("click", sendChangeQuantityRequest);
    }

    document.getElementById("revealAllButton").addEventListener("click", sendRevealAllRequest);
}

document.addEventListener("DOMContentLoaded", addListeners);

