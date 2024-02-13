const email = document.getElementById('email');
const password = document.getElementById('password');
const form = document.getElementById('form');
const errorMessage = document.getElementById('errorMessage');

form.addEventListener("submit", (e) => {
    const errors = [];

    if(username.value.trim() === ""){
        errors.push("Username is required")
    }

    if(password.value.length < 6){
        errors.push("Password is too short")
    }

    if (error.length > 0){
        e.preventDefault();
        errorMessage.toggleAttribute('hidden');
        errorMessage.innerHTML = errors.join(', ');
    }
})