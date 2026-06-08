$(document).ready(function(){
    alert("listo!");
});

$("#form_categoria").submit(function(){
    var nombre = $("#categoria").val();

    if($.trim(nombre)===""){
alert("Debe completar la categoria \nmarcos savid");
        return false;
    }
    return true;
});




$("#form_productos").submit(function(){
    var producto = $("#nombre").val();
    var imagen   = $("#imagen").val();
    var descripcion = $("#descripcion").val();
    var categoria = $("#categoria").val();
    var errores = [];

    if($.trim(producto)==""){
        errores.push("Debe ingresar el nombre del producto");
    }
    if($.trim(imagen)==""){
        errores.push("Debe ingresar la imagen del producto");
    }
    if($.trim(descripcion)==""){
        errores.push("Debe ingresar una descripcion del producto");
    }
    if($.trim(categoria)==""){
        errores.push("Debe ingresar la categoria del producto");
    }

    if(errores.length > 0){
        errores.push("Marcos savid");
        alert(errores.join("\n"));
        return false;
    }

    return true;
});
