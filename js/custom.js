document.addEventListener("DOMContentLoaded", function () {
    const wrapper = document.getElementById('wrapper');
    const menuToggle = document.getElementById('menu-toggle');
    const navLinks = document.querySelectorAll('.list-group-item[data-bs-toggle="collapse"]');
    const allCollapses = document.querySelectorAll('.collapse');

    // 1. Sidebar Toggle (Mobile & Desktop)
    if (menuToggle) {
        menuToggle.addEventListener('click', (e) => {
            e.preventDefault();
            wrapper.classList.toggle('toggled');
        });
    }

    // 2. Accordion Logic (Strict: Ek khulne par dusra band)
    allCollapses.forEach(collapseEl => {
        collapseEl.addEventListener('show.bs.collapse', function () {
            allCollapses.forEach(otherEl => {
                if (otherEl !== collapseEl) {
                    const bsCollapse = bootstrap.Collapse.getInstance(otherEl);
                    if (bsCollapse) {
                        bsCollapse.hide();
                    }
                }
            });
        });
    });

    // 3. Active Class Management
    // Jab koi link click ho, pehle sabse active hatao, phir naye par lagao
    const allSidebarLinks = document.querySelectorAll('#sidebar-wrapper .list-group-item');

    allSidebarLinks.forEach(link => {
        link.addEventListener('click', function () {
            // Sirf wahi active rahe jo click hua hai
            allSidebarLinks.forEach(item => item.classList.remove('active'));
            this.classList.add('active');
        });
    });
});


// Date and time
function updateClock() {
    const now = new Date();
    document.getElementById("time").innerText =
        now.toLocaleTimeString('en-IN', { hour12: true });

    document.getElementById("date").innerText =
        now.toLocaleDateString('en-IN', {
            day: '2-digit',
            month: 'long',
            year: 'numeric'
        });
}

setInterval(updateClock, 1000);
updateClock();


// counter staff payroll
const counters = document.querySelectorAll('.counter');
counters.forEach(counter => {
    const updateCount = () => {
        const target = +counter.getAttribute('data-target');
        const count = +counter.innerText.replace(/,/g, '');
        const increment = target / 200;

        if (count < target) {
            counter.innerText = Math.ceil(count + increment).toLocaleString();
            setTimeout(updateCount, 10);
        } else {
            counter.innerText = target.toLocaleString();
        }
    }
    updateCount();
});