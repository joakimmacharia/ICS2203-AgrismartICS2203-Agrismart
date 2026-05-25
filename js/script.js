const form = document.getElementById("registerForm");

if(form){

form.addEventListener("submit", function(e){

const fullname =
document.querySelector(
'input[name="fullname"]'
).value;

const email =
document.querySelector(
'input[name="email"]'
).value;

const password =
document.querySelector(
'input[name="password"]'
).value;

const role =
document.querySelector(
'select[name="role"]'
).value;

if(
fullname==="" ||
email==="" ||
password==="" ||
role===""
){

alert("Fill all fields.");

e.preventDefault();

}

if(password.length < 6){

alert(
"Password must be at least 6 characters."
);

e.preventDefault();

}

});

}
/* ---------- PRODUCT SEARCH ---------- */

const searchInput =
document.getElementById(
"searchInput"
);

if(searchInput){

searchInput.addEventListener(
"keyup",

function(){

let filter =
this.value.toLowerCase();

let cards =
document.querySelectorAll(
".product-card"
);

cards.forEach(card=>{

let text =
card.innerText
.toLowerCase();

card.style.display =
text.includes(filter)
? "block"
: "none";

});

});

}