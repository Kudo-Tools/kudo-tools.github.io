function redirectToDiscordOAuth() {
    window.location.href = "https://discord.com/api/oauth2/authorize?client_id=799727631289155585&redirect_uri=http%3A%2F%2Fwww.kudotools.com%2Fdashboard&response_type=code&scope=identify";
}

function addAnnouncement() {
    
}

function resetDiscordLogin() {
    document.querySelector('input[name="discord_user"]').value = "";
    document.querySelector('input[name="discord_id"]').value = "";
    document.querySelector('input[name="avatar"]').value = "";
    document.getElementById('discord_username').innerHTML = "Discord not Connected";
    // document.getElementById('discord_username_numbers').innerHTML = "#0000";
    document.getElementById("discord_avatar").src = "images/DiscordPoop.png";
    document.getElementById("signout_discord").style.display = "none";
    document.getElementById("login_discord").style.display = "inline";
    setUnsavedChanges();
    
}

function setUnsavedChanges() {
    document.getElementById("changes").style.color = "#EA4444";
    document.getElementById("changes").innerHTML = "changes unsaved";
    let user = "no name";
    let id = "no id";
    let avatar = "";
    // saveDiscordInformation(user, id, avatar)
    // var xhr = new XMLHttpRequest();
    // xhr.open('POST', "dashboard.php?save=saveDiscord");
    // xhr.onload = function () {
    //     console.log(this.response);
    // };
    // xhr.send(data);
}

function getAnnouncementInformation() {
    console.log("getting announcement information");
    let messages = (document.getElementById("announcement_messages").value).split("{NEW MESSAGE}");
    console.log(messages);
    let authors = (document.getElementById("announcement_author").value).split("{NEW AUTHOR}");
    console.log(authors);
    let times = (document.getElementById("announcement_time").value).split("{NEW TIME}");
    console.log(times);
    for(let x = 0; x < times.length - 1; x++) {
    document.getElementById("announcement").innerHTML += 
    `
    <div class="info_container">
                <a>${authors[x]}</a>
                <a style="color: rgb(0,0,0,0.6);">${times[x]}</a>
                <p >${messages[x]}
                </p>
            </div>`;
    }
    console.log("finished getting information");
}
// function getAnnouncementInformation() {
//     console.log("getting announcement information");
//     let messages = (document.getElementById("announcement_messages").value).split("{NEW MESSAGE}");
//     let authors = (document.getElementById("announcement_author").value).split("{NEW AUTHOR}");
//     let times = (document.getElementById("announcement_time").value).split("{NEW TIME}");
//     for(let x = 0; x < times.length; x) {
//         document.getElementById("announcement").innerHTML += 
//         `
//         <div class="info_container">
//                     <a>${authors[x]}</a>
//                     <a style="color: rgb(0,0,0,0.6);">${times[x]}</a>
//                     <p >${messages[x]}
//                     </p>
//                 </div>`;
//     }
//     console.log('done');
    // console.log("--------------------------");
    // console.log("Getting Announcement Information");
    // $.ajax({
    //     url:"functions/announcements.php",
    //     type: "post",    
    //     dataType: 'json',
    //     data: {
    //         registration: "success"
    //     },
    //     success:function(result){
    //         console.log(result.messages);
    //     }
    // });
    // console.log("DONE GETTING");
// }

function saveUnsavedChanges() {
    document.getElementById("changes").style.color = "rgb(255,255,255,0.5)";
    document.getElementById("changes").innerHTML = "changes saved";
    // var xhr = new XMLHttpRequest();
    // xhr.open('POST', "dashboard.php?save=saveDiscord");
    // xhr.onload = function () {
    //     console.log(this.response);
    // };
    // xhr.send(data);
}


window.onload = () => {
    let url = document.location.href;
    let code = url.split("code=")[1];
    CODE = code;
    getInformation();
    getAnnouncementInformation();
}

const CLIENT_ID = '799727631289155585';
const CLIENT_SECRET = 'JfN6NHGlpoEzatpN6G8KR6d6wsLlaypo';
let CODE = '';


async function getTheToken() {
    const data = {
        client_id: CLIENT_ID,
        client_secret: CLIENT_SECRET,
        grant_type: "authorization_code",
        code: CODE,
        redirect_uri: "http://www.kudotools.com/dashboard",
        scope: "identify"
    }
    const request = await fetch('https://discord.com/api/oauth2/token', {
        method: "POST",
        body: new URLSearchParams(data),
        headers: {
            "Content-Type": "application/x-www-form-urlencoded"
        }
    })
    if(request.status >= 400 && request.status < 500) {
        return null;
    }
    const response = await request.json();
    return response;
}

async function getInformation() {
    if(CODE != null) {
        let tokenInfo = await getTheToken();
        if(tokenInfo != null) {
            let accessToken = tokenInfo.access_token;
            const data = {
                Authorization: `Bearer ${accessToken}`
            }
            const request = await fetch('https://discordapp.com/api/users/@me', {
                method: "GET",
                headers: new URLSearchParams(data)
            })
            const response = await request.json();
            if(response.id != null) {
                document.querySelector('input[name="discord_id"]').value = response.id;
                document.getElementById("discord_id").innerHTML = response.id;
                // document.getElementById('discord_button_text').innerHTML = "Sign out";
                // document.getElementById("signout_discord").style.display = "block";
                document.getElementById("login_discord").style.display = "none";
            }
            if(response.username != null && response.discriminator != null) {
                document.querySelector('input[name="discord_user"]').value = response.username + "#"+response.discriminator;
                document.getElementById("discord_username").innerHTML = response.username + ("#" + response.discriminator);
                // document.getElementById("discord_numbers").textContent = ("#" + response.discriminator);
            }
            if(response.avatar != null) {
                document.querySelector('input[name="avatar"]').value = response.avatar;
                document.getElementById("discord_avatar").src = "https://cdn.discordapp.com/avatars/"+ response.id +"/" +  response.avatar +".png"
            }
            if(response.avatar != null || response.username != null || response.id != null) {
                setUnsavedChanges();
            }
            // saveDiscordInformation(response.username + "#" + response.discriminator, response.id, response.avatar);
        } else {
            window.location = window.location.href.split("?")[0];
        }
    }
}

