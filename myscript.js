'use strict';


function sendHideProductRequest () {
    const button = this;
    let httpRequest = new XMLHttpRequest();
    httpRequest.onreadystatechange = function(){
        if (httpRequest.readyState === 4 && httpRequest.status === 200){
            button.parentElement.parentElement.remove();
        }
    };
    let id = this.parentElement.parentElement.dataset.productid;
    httpRequest.open("POST", "ajax_handler.php");
    httpRequest.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    httpRequest.send("ajax_id="+id);
}

function sendRevealAllRequest() {
    let httpRequest = new XMLHttpRequest();
    httpRequest.onreadystatechange = function(){
        if (httpRequest.readyState === 4 && httpRequest.status === 200){
            window.location = window.location;
        }
    };
    httpRequest.open("POST", "ajax_handler.php");
    httpRequest.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    httpRequest.send("revealAll");

}

function sendChangeQuantityRequest(){
    const button = this;
    let httpRequest = new XMLHttpRequest();
    httpRequest.onreadystatechange = function(){
        if (httpRequest.readyState === 4 && httpRequest.status === 200){
        let valueContainer = button.parentElement.querySelector("span");
            if (button.className === 'plus'){
                valueContainer.innerText = (parseInt(valueContainer.innerText)+1).toString();
            } else {
                valueContainer.innerText = (parseInt(valueContainer.innerText)-1).toString();
            }
        }
    };
    let id = this.parentElement.parentElement.dataset.productid;
    httpRequest.open("POST", "ajax_handler.php");
    httpRequest.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    httpRequest.send("ajax_id="+id+"&change="+this.className);
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

