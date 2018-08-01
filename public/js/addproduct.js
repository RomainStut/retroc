$(function(){

    //Ajout de champ invisible Choix
    $('#product_quality').append('<option selected hidden disabled>Choix</option>');
    $('#product_type').append('<option selected hidden disabled>Choix</option>');
    $('#product_categorie').append('<option selected hidden disabled>Choix</option>');

    //variable qui contient le titre
    var titreselect;

    //requete ajax pour recupérer les produits qui correspondent à la recherche de l'utilisateur
    $('body').on('keyup', 'input#product_name', function(e){
        e.preventDefault();
        $.ajax({
            type: 'POST',
            url: " {{ path('ajax-search-by-title') }} ",
            timeout: 3000,
            data: "title=" + $(this).val(),
            dataType: 'json',
            success: function(data){
                console.log(data);
                $('.search').empty();
                if(data.status === "ok"){
                    $.each(data.products, function(i, product){
                        $('.search').append('<div class="row mb-3 cote-res"><img width="50" height="50" src="'+ product.img +'"><p class="title-result">' + product.name  + '</p></div>')
                    })
                } else {
                    $('.search').append(data.erreur)
                }

            },
            error: function(error){
                console.log(error.responseText);
            }
        })
    })

    //pré-remplissage du champ 'titre produit' avec le choix de l'uti, supression de tout les autres résultats + suite tutoriel
    $('body').on('click', 'div.cote-res', function(){
        $('#product_name').val($(this).children('p').html())
        titreselect = $(this).children('p').html();
        $(this).addClass('choice');
        $('.search').children().not(".choice").remove();
        $('.search').append('<div class="tutorial col-5 mt-5"><p>Choisissez maintenant la qualité de votre produit</p></div>')
    })

    $('#product_image').on('change', function(){
        $('#product_image').next().html($(this).val());
    })

    //requete ajax pour calculer la moyenne du produit en fonction de tout les articles correspondant au nom du produit
    $('#product_quality').on('change', function(){
        console.log($(this).val() + titreselect)
        $.ajax({
            type: 'POST',
            url: " {{ path('ajax-calcule-cote') }} ",
            timeout: 3000,
            data: "title=" + titreselect + "&quality=" + $(this).val(),
            dataType: 'json',
            success: function(data){
                $('.search').children('.tutorial').remove();
                $('.search').children('#cote-choice').remove();
                if(data.status === "ok"){
                    $('.search').append('<div class="tutorial col-5 mt-5"><p>Voici le calcul de votre côte pour le bien ' + $('#product_name').val() + ' : <b>' + data.cote  + '€</b></p></div>');
                } else {
                    $('.search').append('<div class="tutorial col-5 mt-5"><p>' + data.erreur  + '</p></div>')
                }
            },
            error: function(error){
                console.log(error.responseText);
            }
        })
    })

})