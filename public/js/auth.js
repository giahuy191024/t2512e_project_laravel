const wrapper = document.querySelector('.wrapper');
const login = document.querySelector('.login-link');
const register = document.querySelector('.register-link');
const btnPoPUp = document.querySelector('.btn-login_popup');
const iconCloser = document.querySelector('.icon-close');
register.addEventListener('click', (e) => {
    wrapper.classList.add('active');
});
login.addEventListener('click', (e) => {
    wrapper.classList.remove('active');
});
btnPoPUp.addEventListener('click', (e) => {
    wrapper.classList.add('active-popup');
});
iconCloser.addEventListener('click', (e) => {
    wrapper.classList.remove('active-popup');
})
