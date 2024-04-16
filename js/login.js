const form = document.querySelector("form");
let btn = document.getElementById("btn");
let rep = document.getElementById("reponce");

form.addEventListener("submit", e =>{
    e.preventDefault();
})

btn.addEventListener("click", function(){
    let email = form.elements.email.value;
    let password = form.elements.password.value;

    let xml = new XMLHttpRequest();
    xml.open("POST", "login.php", true);
    xml.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xml.send("email="+email +"&password="+password);
    xml.onload = function (){
        if(xml.readyState === XMLHttpRequest.DONE){
            if(xml.status === 200){
                if(xml.responseText == "true"){
                    let encodedEmail = encodeURIComponent(email);
                    window.location.href = `compteUser.html?email=${encodedEmail}`;
                }else{
                    rep.innerHTML = `<input type='text' disabled value='${xml.responseText}' style='background:#d64040e2; color:#fff;'>`;
                    console.log(xml.responseText);
                }
            }
        }
    }
})
