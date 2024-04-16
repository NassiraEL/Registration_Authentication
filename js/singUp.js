const form = document.querySelector("form");
let btn = document.getElementById("btn");
let rep = document.getElementById("reponce");
let section1 = document.getElementById("section1");
let section2 = document.getElementById("section2");


form.addEventListener("submit", e =>{
    e.preventDefault();
})



btn.addEventListener("click", function(){
    let nameUser = form.elements.name.value;
    let tel = form.elements.tel.value;
    let email = form.elements.email.value;
    let pass = form.elements.password.value;
    let passConf = form.elements.passwordConf.value;
    let latitude = form.elements.latitude.value;
    let longitude = form.elements.longitude.value;


    let xml = new XMLHttpRequest();
    xml.open("POST", "signUp.php", true);
    xml.setRequestHeader("Content-type", "application/x-www-form-urlencoded")
    xml.send("name="+nameUser +"&tel="+tel +"&email="+email +"&password="+pass +"&passwordConf="+passConf +"&latitude="+latitude +"&longitude="+longitude);
    xml.onload = function (){
        if(xml.readyState === XMLHttpRequest.DONE){
            if(xml.status === 200){
                if(xml.responseText === "true"){
                    rep.style.display = "none";
                    section2.style.animation = 'side 2s ease forwards';

                   setTimeout(function(){
                        let success = document.createElement("div");
                        success.classList.add("success");

                        let img = document.createElement("img");
                        img.setAttribute("src", "images/correction.png");
                        img.classList.add("iconValide");
                        success.appendChild(img);

                        let msg = document.createElement("h2");
                        let msgTxt = document.createTextNode("Thanks for the registration!");
                        msg.appendChild(msgTxt);

                        success.appendChild(img);
                        success.appendChild(msg);

                        let lien = document.createElement("a");
                        lien.setAttribute("href", "login.html");
                        let lienTxt = document.createTextNode("Login Now");
                        lien.appendChild(lienTxt);
                        lien.classList.add("lien");

                        success.appendChild(lien);
                        
                        document.body.appendChild(success);
                    }, 1000)


                }else{
                    rep.innerHTML = `<input type='text' disabled value='${xml.responseText}' style='background:#d64040e2; color:#fff;'>`;
                    console.log(xml.responseText);
                }
                
            }
          }
        
    };
    

})

