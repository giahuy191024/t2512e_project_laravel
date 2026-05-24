const wrapper = document.querySelector('.wrapper');
const login = document.querySelector('.login-link');
const register = document.querySelector('.register-link');
const btnPoPUp = document.querySelector('.btn-login_popup');
const iconCloser = document.querySelector('.icon-close');
// const menuBtn = document.getElementById('mobileMenuBtn');
// const mobileMenu = document.getElementById('mobileMenu');

// 1. Chuyển sang form Register
if(register && wrapper){
register.addEventListener('click', (e) => {
    e.preventDefault(); // CHÈN THÊM DÒNG NÀY: Chặn thẻ <a> làm cuộn trang
    wrapper.classList.add('active');
});
}

// 2. Quay lại form Login
if( login && wrapper){
login.addEventListener('click', (e) => {
    e.preventDefault(); // CHÈN THÊM DÒNG NÀY: Chặn thẻ <a> làm cuộn trang
    wrapper.classList.remove('active');
});
}

// 3. Bấm nút Đăng nhập trên Menu để hiện Popup
if (btnPoPUp && wrapper) {
    btnPoPUp.addEventListener('click', (e) => {
        e.preventDefault(); // CHÈN THÊM DÒNG NÀY: Chặn nút nhảy/cuộn trang chủ xuống dưới
        wrapper.classList.add('active-popup');
    });
}
// 4. Bấm nút đóng [X]
if (iconCloser && wrapper) {
    iconCloser.addEventListener('click', (e) => {
        wrapper.classList.remove('active-popup');
    });
}
// =========================
// DOCTOR SECTION
// =========================

document.addEventListener('DOMContentLoaded', () => {
    // TAB REGION
    const tabs = document.querySelectorAll('.doctor-tab');

    const regions = document.querySelectorAll('.doctor-region');

    tabs.forEach(tab => {
        tab.addEventListener('click', () => {
            // reset tab
            tabs.forEach(btn => {
                btn.classList.remove('bg-blue-600', 'text-white','shadow-sm');
                btn.classList.add('text-slate-600', 'bg-transparent');
            });
            // active tab
            tab.classList.remove('text-slate-600', 'bg-transparent');
            tab.classList.add('bg-blue-600', 'text-white','shadow-sm');
            // hide region
            regions.forEach(region => {
                region.classList.add('hidden');
            });
            // show region
            const target = document.getElementById(tab.dataset.region);
            if (target) {
                target.classList.remove('hidden');
            }
        });
    });
    // SLIDER
    document.querySelectorAll('.doctor-region').forEach(region => {
        const slider = region.querySelector('.doctor-slider');
        const prev = region.querySelector('.doctor-prev');
        const next = region.querySelector('.doctor-next');
        if (!slider) return;
        const amount = 340;
        // next
        next?.addEventListener('click', () => {
            slider.scrollBy({
                left: amount, behavior: 'smooth'
            });
        });
        // prev
        prev?.addEventListener('click', () => {
            slider.scrollBy({
                left: -amount, behavior: 'smooth'
            });
        });
    });
});
// =========================
// DOCTOR MODAL
// =========================

function openDoctorModal(
    name,
    info
) {

    const modal = document.getElementById('doctorModal');
    const modalName = document.getElementById('modalDoctorName');
    const modalInfo = document.getElementById('modalDoctorInfo');
    if (!modal) return;
    modalName.innerText = name;
    modalInfo.innerText = info;
    modal.classList.remove('hidden');
    modal.classList.add('flex');
}

function closeDoctorModal() {
    const modal = document.getElementById('doctorModal');
    if (!modal) return;
    modal.classList.add('hidden');
    modal.classList.remove('flex');
}
document.addEventListener('DOMContentLoaded', () => {

    // 1. Toggle menu mobile (lấy lại element trong DOMContentLoaded cho chắc)
    const menuBtn = document.getElementById('mobileMenuBtn');
    const mobileMenu = document.getElementById('mobileMenu');
    if (menuBtn && mobileMenu) {
        menuBtn.addEventListener('click', () => {
            mobileMenu.classList.toggle('hidden');
        });
    }

    // 2. Accordion submenu mobile (Dịch vụ / Tin tức)
    document.querySelectorAll('.mobile-submenu-toggle').forEach(btn => {
        btn.addEventListener('click', () => {
            const target = document.getElementById(btn.dataset.target);
            const icon = btn.querySelector('svg');
            if (!target) return;
            target.classList.toggle('hidden');
            target.classList.toggle('flex');
            icon?.classList.toggle('rotate-180');
        });
    });

    // 3. Đổi style header khi scroll
    const header = document.getElementById('siteHeader');
    const inner  = document.getElementById('headerInner');
    const logo   = document.getElementById('siteLogo');
    if (header && inner && logo) {
        const onScroll = () => {
            if (window.scrollY > 30) {
                header.classList.add('shadow-md', 'backdrop-blur', 'bg-white/90');
                inner.classList.remove('h-24', 'md:h-32');
                inner.classList.add('h-20', 'md:h-24');
                logo.classList.remove('h-16', 'md:h-24');
                logo.classList.add('h-12', 'md:h-16');
            } else {
                header.classList.remove('shadow-md', 'backdrop-blur', 'bg-white/90');
                inner.classList.add('h-24', 'md:h-32');
                inner.classList.remove('h-20', 'md:h-24');
                logo.classList.add('h-16', 'md:h-24');
                logo.classList.remove('h-12', 'md:h-16');
            }
        };
        window.addEventListener('scroll', onScroll, { passive: true });
        onScroll();
    }
});
// File JS, đặt ở đầu hoặc cuối file - MIỄN LÀ KHÔNG TRONG bất kỳ function/wrapper nào
function showService(btn, id) {
    document.querySelectorAll('.service-tab').forEach(t => t.classList.remove('active'));
    btn.classList.add('active');

    document.querySelectorAll('.service-content').forEach(c => c.classList.remove('active-content'));
    document.getElementById(id)?.classList.add('active-content');
}

document.querySelectorAll('.branch-card').forEach(card => {
    card.addEventListener('click', () => {
        // 1. Update iframe src
        const iframe = document.getElementById('branchMap');
        if (iframe && card.dataset.map) {
            iframe.src = card.dataset.map;
        }

        // 2. Toggle active state
        document.querySelectorAll('.branch-card').forEach(c => c.classList.remove('active'));
        card.classList.add('active');

        // 3. Mobile: cuộn xuống map sau khi click
        if (window.innerWidth < 1024) {
            iframe?.scrollIntoView({ behavior: 'smooth', block: 'center' });
        }
    });
});
