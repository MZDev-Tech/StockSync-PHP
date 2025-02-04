document.addEventListener('DOMContentLoaded', () => {
    const header = document.getElementById('header-part');
    const main_page = document.getElementById('main-page');
    const sidebar = document.querySelector('.sidebar-part'); // Fix
    const menuIcon = document.getElementById('menuIcon');
    const crossIcon=document.getElementById('crossbtn');

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
    if(crossIcon){
     crossIcon.addEventListener('click',()=>{
     sidebar.classList.remove('active');
     });
    }
    else {
        console.error("CrossIcon not found in the DOM.");
    }
});
