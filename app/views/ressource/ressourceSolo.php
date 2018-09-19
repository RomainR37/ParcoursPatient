<div class="container-fluid">
    <h3>Planning de <?php echo $nom_res; ?></h3>
    <div class="container solocontainer" style="margin-top: 20px; border: 1px solid black; border-bottom: none; padding: 0;">
        <div id="myschedule" style="height:700px; width: 100%;"></div>
    </div>
    <div class="container" style="border: 1px solid black; padding: 10px; margin: 0 auto; text-align: center;">
        <a href="<?php echo base_url(array('Ressource', 'solo', $id, $week - 1)); ?>">Prec.</a>
        &nbsp;&nbsp;&nbsp;&nbsp;
        <a href="<?php echo base_url(array('Ressource', 'solo', $id, $week + 1)); ?>">Suiv.</a>
    </div>
</div>
<script type="text/javascript">
    var week = <?php echo $week; ?>;

    $(".solocontainer").css("height", $("#myschedule").css("height"));
    $("#myschedule").css("overflow", "auto");

    function getEvents() {
        return <?php echo $activity; ?>;
    }
</script>