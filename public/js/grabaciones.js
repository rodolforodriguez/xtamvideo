
//!--Busqueda avanzada-- >
function redirect() {
    window.location.replace("../../public/admin/searchadvanced");
}

// sidevar collapsed
document.body.className = "skin-red sidebar-collapse";
// sidevar collapsed

// <!--Function check export video - change name-- >
function checkformat(value) {
    if (value == true) {
        // habilitamos
        document.getElementById("id_select").disabled = false;
    } else if (value == false) {
        // deshabilitamos
        document.getElementById("id_select").disabled = true;
    }
}

function checkname(value) {
    if (value == true) {
        // habilitamos
        document.getElementById("chkname").disabled = false;
    } else if (value == false) {
        // deshabilitamos
        document.getElementById("chkname").disabled = true;
    }
}

//    <!--sidebar -->
var dropdown = document.getElementsByClassName("dropdown-btn");
var i;
for (i = 0; i < dropdown.length; i++) {
    dropdown[i].addEventListener("click", function () {
        this.classList.toggle("active");
        var dropdownContent = this.nextElementSibling;
        if (dropdownContent.style.display === "block") {
            dropdownContent.style.display = "none";
        } else {
            dropdownContent.style.display = "block";
        }
    });
}

// Le añadimos función de borrar al botón
function limpiaCampo() {
    // para una selección más general, se puede usar solo 'input'
    var elements = document.querySelectorAll("input[type='text']");
    // Por cada input field le añadimos una funcion 'onFocus'
    for (var i = 0; i < elements.length; i++) {
        elements[i].value = "";
    }
}