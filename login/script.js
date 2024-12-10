// Select form elements
const loginForm = document.getElementById('loginForm');
const signupForm = document.getElementById('signupForm');
const loginBtn = document.getElementById('loginBtn');
const signupBtn = document.getElementById('signupBtn');
const switchToSignup = document.getElementById('switchToSignup');
const switchToLogin = document.getElementById('switchToLogin');

// Function to switch to Signup form
signupBtn.addEventListener('click', () => {
    loginForm.classList.remove('active');
    signupForm.classList.add('active');
    loginBtn.classList.remove('active');
    signupBtn.classList.add('active');
});

// Function to switch to Login form
loginBtn.addEventListener('click', () => {
    signupForm.classList.remove('active');
    loginForm.classList.add('active');
    signupBtn.classList.remove('active');
    loginBtn.classList.add('active');
});

// Function to switch to Signup from Login
switchToSignup.addEventListener('click', () => {
    loginForm.classList.remove('active');
    signupForm.classList.add('active');
    loginBtn.classList.remove('active');
    signupBtn.classList.add('active');
});

// Function to switch to Login from Signup
switchToLogin.addEventListener('click', () => {
    signupForm.classList.remove('active');
    loginForm.classList.add('active');
    signupBtn.classList.remove('active');
    loginBtn.classList.add('active');
});

// Initial state to show login form
loginForm.classList.add('active');
loginBtn.classList.add('active');


