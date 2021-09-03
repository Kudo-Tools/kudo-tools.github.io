var slide = 0;


function download() {
    var xmlHttp = new XMLHttpRequest();
    xmlHttp.onreadystatechange = function() {
        if (xmlHttp.readyState == 4 && xmlHttp.status == 200) {
            const json = JSON.parse(xmlHttp.responseText);
            let bLarge = 0;
            let bMid = 0;
            let bSmall = 0;
            let urlObj = null;
            for(let i = 0; i < json.length; i++) {
                let obj = json[i];
                let version = obj.tag_name;
                let version_cut = version.split(".");
                let nLarge = parseInt(version_cut[0]);
                let nMid = parseInt(version_cut[1]);
                let nSmall = parseInt(version_cut[2]);
                
                if(nLarge > bLarge) {
                    bLarge = nLarge;
                    urlObj = obj.assets;
                } else if(nMid > bMid) {
                    bMid = nMid;
                    urlObj = obj.assets;
                } else if(nSmall > bSmall) {
                    bSmall = nSmall;
                    urlObj = obj.assets;
                }
            }
            console.log(urlObj);
            if(urlObj != null) {
                for(let i = 0; i < urlObj.length; i++) {
                    let obj = urlObj[i];
                    let win = obj.browser_download_url;
                    console.log(win);
                    if(win != null) {
                        window.location.href = win;
                    }
                    
                }
            }
            window.location.href = "https://www.kudotools.com/";
        }
    }
    xmlHttp.open("GET", "https://api.github.com/repos/TeedsK/Kudo-Download/releases", true); // true for asynchronous 
    xmlHttp.send(null);
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
    if(elem != null) {
        var txt = elem.innerHTML;
        if(txt === 'out of stock') {
            elem.style.color = "rgb(11,11,18, 0.7)";
            elem.style.pointerEvents = "none";
        }
    }
}

function purchaseButton() {
    let elem = document.getElementById('purchase');
    if(elem != null) {
        var txt = elem.innerHTML;
        if(txt === "no licenses available") {
            elem.style.color = "rgb(11,11,18, 0.7)";
            elem.style.pointerEvents = "none";
        }
    }
}

// document.onload = showSlide(0);

document.addEventListener('readystatechange', event => { 
    
    if (event.target.readyState === "interactive") {
        showSlide(0);
        
    }
    if (event.target.readyState === "complete") {
        signupStyle();
        purchaseButton();
    }
});

