console.log("AUTH JS RUNNING");
const wrapper = document.querySelector('.wrapper');
const loginLink = document.querySelector('.login-link');
const registerLink = document.querySelector('.register-link');
const btnPopup = document.querySelectorAll('.btn-login_popup');
const iconClose = document.querySelector('.icon-close');

// mở form
btnPopup.forEach(button => {
    button.addEventListener('click', () => {
        wrapper.classList.add('active-popup');
    });
});
// đóng form
iconClose.addEventListener('click', () => {
    wrapper.classList.remove('active-popup');
});

// chuyển sang register
registerLink.addEventListener('click', () => {
    wrapper.classList.add('active');
});
wrapper.classList.add('active-popup');
login.addEventListener('click', (e) => {
    wrapper.classList.remove('active');
});
iconCloser.addEventListener('click', (e) => {
    wrapper.classList.remove('active-popup');
})
