var slide = 0;

function available_continue(txt) {
    if(txt !== "no licenses available") {
        window.location.href = "https://www.kudotools.com/signup";
    }
}

function showSlide(slide) {
    var slidesButton = document.getElementsByClassName("selectors");
    var titles = document.getElementsByClassName("selector_titles");
    var descriptions = document.getElementsByClassName("selector_description");
    var icons = document.getElementsByClassName("icon");
    var slides = document.getElementsByClassName("slide");
    var i;
    for(i = 0; i < slidesButton.length; i++) {
        slidesButton[i].style.backgroundColor = "rgb(235,235,240)";
        slidesButton[i].style.width = "400px";
        slidesButton[i].style.height = "220px";
        slidesButton[i].style.margin = "10px 20px";
        slides[i].style.display = "none";
        slidesButton[i].style.boxShadow = "0px 0px 0px 2.5px rgb(27,30,39, 0) inset";
        titles[i].style.color = "rgb(27,30,39)";
        descriptions[i].style.color = "rgb(27,30,39)";
        icons[i].style.filter = "invert(0%)";
        icons[i].style.maxWidth = "65px";
        // imageOutlines[i].style.boxShadow = "0px 0px 0px 2.5px rgb(27,30,39, 0.7) inset";
    }

    

    slidesButton[slide].style.backgroundColor = "rgb(209,60,82)";
    slidesButton[slide].style.boxShadow = "0px 0px 0px 2.5px rgb(209,60,82) inset";
    slidesButton[slide].style.width = "420px";
    slidesButton[slide].style.height = "240px";
    slidesButton[slide].style.margin = "0px 10px";
    icons[slide].style.filter = "invert(100%)";
    icons[slide].style.maxWidth = "85px";
    titles[slide].style.color = "rgb(255,255,255)";
    descriptions[slide].style.color = "rgb(255,255,255)";
    // imageOutlines[slide].style.boxShadow = "0px 0px 0px 2.5px rgb(255,255,255) inset";
    slides[slide].style.display = "block";
}

function signupStyle() {
    let elem = document.getElementById('beta_button');
    var txt = elem.innerHTML;
    console.log('txt =  ' +txt);
    if(txt === 'out of stock') {
        elem.style.color = "rgb(11,11,18, 0.4)";
    }
}

// document.onload = showSlide(0);

document.addEventListener('readystatechange', event => { 
    
    if (event.target.readyState === "interactive") {
        showSlide(0);
        signupStyle();
    }
    if (event.target.readyState === "complete") {}
});

