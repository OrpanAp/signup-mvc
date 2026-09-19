const loginForm = document.getElementById("loginForm");
const signupForm = document.getElementById("signupForm");

const showSignup = document.getElementById("showSignup");
const showLogin = document.getElementById("showLogin");


showSignup.addEventListener("click", function () {

    loginForm.classList.remove("active");
    signupForm.classList.add("active");

});


showLogin.addEventListener("click", function () {

    signupForm.classList.remove("active");
    loginForm.classList.add("active");

});
        