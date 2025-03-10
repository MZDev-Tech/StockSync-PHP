document.addEventListener('DOMContentLoaded', () => {
    //code to toggle main sidebar
    const header = document.getElementById('header-part');
    const main_page = document.getElementById('main-page');
    const sidebar = document.querySelector('.sidebar-part'); // Fix
    const menuIcon = document.getElementById('menuIcon');
    const crossIcon = document.getElementById('crossbtn');

    if (menuIcon) {
        menuIcon.addEventListener('click', () => {
            console.log('btn clicked');
            header.classList.toggle('active');
            main_page.classList.toggle('active');
            sidebar.classList.toggle('active');
        });
    } else {
        console.error("menuIcon not found in the DOM.");
    }
    //code to cross sidebar in small screens
    if (crossIcon) {
        crossIcon.addEventListener('click', () => {
            sidebar.classList.remove('active');
        });
    }
    else {
        console.error("CrossIcon not found in the DOM.");
    }

    //code to navigate sidebar items in admin profile page

    const profile_items = document.querySelectorAll('.profile-sidebar-item');

    profile_items.forEach(item => {
        item.addEventListener('click', function () {
            console.log('item clicked');

            // // Remove active class from all sidebar items
            // profile_items.forEach(val => val.classList.remove('active'));

            // Add active class to the clicked item
            this.classList.toggle('active');

            // Hide all profile sections
            document.querySelectorAll(".profile-section").forEach(section => {
                section.style.display = "none";
            });

            // Get target section from data attribute and show it
            const target = this.getAttribute("data-target");
            if (target) {
                const targetElement = document.getElementById(target);
                if (targetElement) {
                    targetElement.style.display = "block";
                } else {
                    console.warn(`Element with ID "${target}" not found.`);
                }
            }
        });
    });


    document.querySelectorAll(".dropdown-toggle").forEach((toggle) => {
        toggle.addEventListener("click", function () {
            // this refers to the clicked dot button & nextElementSibling finds the next element, which is the dropdown menu
            let dropdownMenu = this.nextElementSibling;
            //.getBoundingClientRect() returns the exact position & size of the dropdown menu relative to the viewport.
            let rect = dropdownMenu.getBoundingClientRect();
            // window.innerHeight gives the total visible height of the browser window (viewport).

            let windowHeight = window.innerHeight;
            //rect.bottom calculates the Y-coordinate (vertical position) of the dropdown’s bottom edge.
            //  (screen) height = 900px
            // The dropdown starts at 750px
            // The dropdown height = 200px
            // So the bottom of the dropdown = 750px + 200px = 950px
            if (rect.bottom > windowHeight) {
                dropdownMenu.classList.add("dropdown-menu-end");
            } else {
                dropdownMenu.classList.remove("dropdown-menu-end");
            }
        });
    });


    

});
