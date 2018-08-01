function calculPrix(){
    $.ajax({
        url : "http://trucks-mania.bwb/api/utilisateur/"+id,
        type : "POST",
        
        data : {
            email : $("#email").val(),
            adresse : $("#user_input_autocomplete_address").val(),
            mot_de_passe : $("#motDePasse").val()
        },
        
        success : function(data){
            document.location.href = document.location.href;
        },
        
        error : function(){
            alert("essaie encore");
        }
    });
}