$(document).ready(function(){
    $('.site-header .menu-principal .menu').slicknav({
        appendTo:'.site-header',
    });

    window.onscroll = () =>{
        const scroll = window.scrollY;

        const headerNav = document.querySelector('.barra-navegacion');

        const documentBody = document.querySelector('body');

        if(scroll > 75)
        {
            headerNav.classList.add('fixed-top');
            documentBody.classList.add('ft-activo');
        }
        else
        {
            headerNav.classList.remove('fixed-top');
            documentBody.classList.remove('ft-activo');
        }
    }
});


