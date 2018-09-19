$('body').on('click', '.onglet', function(event) {
	$(".onglet").removeClass('active');
	$(this).addClass('active');
	//alert($(".dossier-parcours.active").data('dparcours'));

	callAjaxDossierParcours($(this).data('onglet'), $(".dossier-parcours.active").data('dparcours'));
});

$('body').on('click', '.dossier-parcours', function(event) {
	$(".dossier-parcours").removeClass('active');
	$(this).addClass('active');
	//alert($(this).data('dparcours'));
	callAjaxDossierParcours(-1,$(this).data('dparcours'));

});




$('body').on('click', '.ajout-champ', function(event){
	console.log("ici");
	event.preventDefault();
	$(".div-ajout-champ-global").removeClass("hidden").addClass('visibledivVerif');
});





$('body').on('click', '.annuler-champ', function(event) {
	event.preventDefault();
	$(".div-ajout-champ-global").addClass("hidden").removeClass('visibledivVerif');
});
