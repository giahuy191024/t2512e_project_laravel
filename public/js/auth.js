console.log("AUTH JS RUNNING");
const wrapper = document.querySelector('.wrapper');
const loginLink = document.querySelector('.login-link');
const registerLink = document.querySelector('.register-link');
const iconClose = document.querySelector('.icon-close');

// mở form
// chuyển sang register
registerLink.addEventListener('click', () => {
    wrapper.classList.add('active');
});
loginLink.addEventListener('click',()=>{
    wrapper.classList.remove('active');
});
wrapper.classList.add('active-popup');
