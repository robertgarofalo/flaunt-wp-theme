let menuButton = document.getElementById('menu-button');
let sideBar = document.getElementById('flaunt-sidebar');

// Sidebar button
menuButton.addEventListener('click', function(){
    sideBar.classList.toggle('sidebar-active');
    
    if(!sideBar.classList.contains('sidebar-active')){
        menuButton.className = "fa-solid fa-x";
    } else {
        menuButton.className = "fa-solid fa-bars";
    }
})

