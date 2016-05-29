<?php $this->load->view('header'); ?>
<script type='text/javascript'>
    function format_number(num)
    {
        if (num < 10) return '0'+num;
        return num;
    }

    function get_idSerie(element_id) 
    {
        var pos = element_id.lastIndexOf('_')+1;
        return element_id.substr(pos);
    }

    function show_alert_error()
    {
        $('#alert-error').html('Ha ocurrido un error');
        $('#alert-error').show().delay(3000).fadeOut();
    }

    function update_row(id_serie, action, data)
    {
        var next_download_col = $('#next_'+id_serie);

        //Change styles
        $('#row_'+id_serie).removeClass('highlight-row');
        $(next_download_col).removeClass('highlight-episode');
        $('#download_status_'+id_serie).removeClass().addClass('download_status ok');
        $('#postpone_'+id_serie).hide();
        
        if(action == 'postpone') return;

        var current_episode = parseInt($(next_download_col).attr('current-episode')) + 1;
        if (isNaN(current_episode)) current_episode = 1;

        $(next_download_col).attr('current-episode', current_episode);
        if(data) $(next_download_col).attr('last-download', data.current_date);

        var season = $(next_download_col).attr('current-season');
        $(next_download_col).html(season+'x'+format_number(current_episode + 1));


        $(next_download_col).parent().effect('highlight', '', 1000);
    }

    $(document).ready(function () {

        $('[data-toggle="tooltip"]').tooltip(); 

        $('table tr').mouseleave(function () {
            $(this).find('.actions').css('opacity', 0);
        });
        $('table tr').mouseenter(function () {
            $(this).find('.actions').css('opacity', 1);
        });

        //Highlight pending rows
        $('.pending, .available').each(function() {
            $(this).parent().addClass('highlight-row');
            $(this).parent().find('.next_download').addClass('highlight-episode');
        });

        $('button[name="download"]').click(function () {
            var id_serie = get_idSerie($(this).attr('id'));
            $(this).tooltip('hide'); //For any reason tooltip keeps visible

            $.post({
                url: '<?= base_url().'download_episode'; ?>',
                data: {'id_serie': id_serie},
                success: function( data ) {
                    data = $.parseJSON(data);

                    if (data.result) {
                        update_row(id_serie, 'download', data);
                    }
                    else show_alert_error();
                }
            });
        });

        $('button[name="postpone"]').click(function () {
            var id_serie = get_idSerie($(this).attr('id'));

            $.post({
                url: '<?= base_url().'postpone_episode'; ?>',
                data: {'id_serie': id_serie},
                success: function( data ) {
                    data = $.parseJSON(data);

                    if (data.result) {
                        update_row(id_serie, 'postpone');
                    }
                    else show_alert_error();
                }
            });
        });
        

        $('button[name="download"]').tooltip({
             'container': 'body',
             'placement': 'bottom',
             'title': 'Descargar'
        });

        $('button[name="postpone"]').tooltip({
             'container': 'body',
             'placement': 'bottom',
             'title': 'Posponer'
        });

        //Initialize behaviour of popover
        $('.next_download').popover({
            'container': 'body',
            'placement': 'right',
            'trigger': 'hover',
            'html': true,
            'title': '<strong>Último descargado</strong>'
        });

        $('.next_download').on('show.bs.popover', function(){
            if ($(this).attr('current-episode') == 0) $(this).attr('data-content', '-');
            else {
                var current_season = $(this).attr('current-season');
                var current_episode = format_number($(this).attr('current-episode'));
                var date = $(this).attr('last-download');
                $(this).attr('data-content', current_season+'x'+current_episode+'<br>'+date);
            }
        });

    });
</script>
<style>
    .download_status{
        padding: 4px !important;
        width: 0px;
    }
    .name_col{
        font-weight: bold;
    }
    .ok{
        background-color: #5cb85c;
    }
    .available{
        background-color: #f0ad4e;
    }
    .pending{
        background-color: #d9534f;
    }
    .finished {
        background-color: #555;
    }

    th:not(.name_col), td:not(.name_col){
        text-align: center;
    }
    td{
        vertical-align: middle !important;
    }
    .btn-square {
        width: 30px;
        height: 30px;
        padding: 6px 0;
        font-size: 12px;
    }
    .glyphicon{
        font-size: 15px;
    }
    .actions {
        opacity: 0;
    }
    .alert{
        position: fixed;
        top: 15%;
        right:40%;
        left:40%;
        width: auto;
        z-index: 1;
        text-align: center;
    }
    .next_download{
        cursor: pointer;
    }

    .highlight-row{
        background-color: rgba(255, 255, 0, .25) !important;
    }
    .highlight-episode{
        font-weight: bold;
        color: #d9534f;
        font-size: 18px;
    }
</style>
    <div class='alert alert-danger' id='alert-error' role='alert' style='display:none;'></div>
    <table class='table table-hover'>
        <thead>
            <tr>
                <th class='download_status'></th>
                <th class='name_col'>Serie</th>
                <th>Próximo capítulo</th>
                <th>Día disponible</th>
                <th>Final</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($series_following)) foreach($series_following as $serie) { 
                $idSerie = $serie['id'];
            ?>
            <tr id='<?= 'row_'.$idSerie; ?>'>
                <td id='<?= 'download_status_'.$idSerie; ?>' class='download_status <?= $serie['download_status']; ?>'></td>
                <td class='name_col'><?= $serie['name']; ?>
                    <?php if ($serie['vo']) { ?>
                        <span class="label label-info">VOSE</span>
                    <?php } ?>
                </td>
                <td>
                    <span class='next_download' id='<?= 'next_'.$idSerie; ?>' last-download='<?= $serie['date_last_download']; ?>' current-season='<?= $serie['season']; ?>' current-episode='<?= $serie['episode_downloaded']; ?>'><?= $serie['next_download']; ?></span>
                </td>
                <td><?= $serie['day_available']; ?></td>
                <td><?= $serie['season_finale']; ?></td>
                <td class='actions'>
                    <?php if ($serie['download_status'] != 'finished') { ?>
                        <button type='button' name='download' id='<?= 'download_'.$idSerie; ?>' class='btn btn-sm btn-primary btn-square'>
                            <span class='glyphicon glyphicon-plus-sign'></span>
                        </button>

                        <?php if ($serie['download_status'] != 'ok') { ?>
                            <button type='button' name='postpone' id='<?= 'postpone_'.$idSerie; ?>' class='btn btn-sm btn-default btn-square'>
                                <span class='glyphicon glyphicon-time'></span>
                            </button>
                        <?php } ?>
                    <?php } else { ?>
                        <span class="label label-danger">Finalizada</span>
                    <?php } ?>
                </td>
            </tr>
            <?php } ?>
        </tbody>
    </table>

<?php $this->load->view('footer'); ?>
