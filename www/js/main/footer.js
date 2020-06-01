window.onload = function() {

    //modificar poision del footer para que siempre este abajo
    function footer() {
        //eliminando las clases para tener la medida correcta total
        $("footer").removeClass("uno"); 
        $("footer").removeClass("dos");
        let elem = $("body").find("div").first().height();//medida de todo el html
        let windowh = window.innerHeight; //medida de la ventana
        //console.log(elem);
        //console.log(windowh);
        if (elem >= windowh) {
            $("footer").addClass("dos"); //aplicar posicion relative
        } else {
            $("footer").addClass("uno"); //aplicar posicion fixed
        }
    }
    $(window).resize(footer);

    //funcion llamada cuando se cambia algun elemento en el documento
    let observer = new MutationObserver(footer); 
    observer.observe(document, {subtree: true, childList: true}); //obser5vara el documento entero y sus hijos

    footer();
}