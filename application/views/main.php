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
          Materialize.toast('Ha ocurrido un error', 3000, 'rounded red darken-4');
    }

    function update_row(id_serie, action, data)
    {
        //Change styles
        $('#row_'+id_serie).removeClass('highlight-row');
        $('#next_'+id_serie).removeClass('highlight-episode');
        $('#download_status_'+id_serie).removeClass().addClass('download_status ok');
        $('#postpone_'+id_serie).hide();
        
        if (action == 'postpone') return;

        $('#download_status_'+id_serie).removeClass().addClass('download_status '+data.download_status);
        $('#next_'+id_serie).attr('current-episode', data.episode_downloaded);
        $('#next_'+id_serie).attr('last-download', data.date_last_download);
        $('#next_'+id_serie).html(data.next_download);
        if (data.is_season_finale) {
            $('#actions_'+id_serie).find('.label_finished_block').show();
            $('#actions_'+id_serie).find('.buttons_block').remove();
        }

        $('#next_'+id_serie).parent().effect('highlight', '', 1000);
    }

    $(document).ready(function () {


        $('table tr').mouseleave(function () {
            $(this).find('.actions .buttons_block').css('opacity', 0);
        });
        $('table tr').mouseenter(function () {
            $(this).find('.actions .buttons_block').css('opacity', 1);
        });

        //Highlight pending rows
        $('.pending, .available').each(function() {
            $(this).parent().addClass('highlight-row');
            $(this).parent().find('.next_download').addClass('highlight-episode');
        });

        $('a[name="download"]').click(function () {
            var id_serie = get_idSerie($(this).attr('id'));

            $.post({
                url: '<?= base_url().'download_episode'; ?>',
                data: {'id_serie': id_serie},
                success: function( data ) {
                    data = $.parseJSON(data);

                    if (data.result) {
                        update_row(id_serie, 'download', data.data);
                    }
                    else show_alert_error();
                }
            });
        });

        $('a[name="postpone"]').click(function () {
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
        
        $('.next_download').click(function(event) {
            if ($(this).attr('current-episode') == 0) $(this).attr('data-content', '-');
            else {
                var header = 'Último descargado<br>';
                var current_season = $(this).attr('current-season');
                var current_episode = format_number($(this).attr('current-episode'));
                var date = $(this).attr('last-download');
                Materialize.toast(header+current_season+'x'+current_episode+'<br>'+date, 5000);
            }
        });

    });
</script>
<style>
    .name_col{
        font-weight: bold;
    }
    .name_col .links {
        vertical-align: middle;
        margin-left: 5px;
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
    .actions .buttons_block {
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
    /*Fix VO badge*/
    span.center {
        float: none;
    }
</style>
<div class="row">
    <table class='bordered'>
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
        <?php 
        if (!empty($series_following)) 
            foreach($series_following as $serie) { 
                $idSerie = $serie['id'];
        ?>
            <tr id='<?= 'row_'.$idSerie; ?>' class='hoverable'>
                <td id='<?= 'download_status_'.$idSerie; ?>' class='download_status <?= $serie['download_status']; ?>'></td>
                <td class='name_col'>
                    <?= $serie['name']; ?>
                    <span class='links'>
                    <?php if (!empty($serie['download_link'])) { ?>
                        <a href='<?= $serie['download_link']; ?>' target='_blank'><i class='tiny material-icons'>cloud_download</i></a>
                    <?php } ?>
                    <?php if (!empty($serie['subtitles_link'])) { ?>
                        <a href='<?= $serie['subtitles_link']; ?>' target='_blank'><i class='tiny material-icons'>subtitles</i></a>
                    <?php } ?>
                    </span>
                    
                    <span class="new badge blue lighten-1 center" data-badge-caption="VO" style='<?= ($serie['vo']) ? '' : 'display:none'; ?>'></span>
                </td>
                <td>
                    <span class='next_download tooltipped' id='<?= 'next_'.$idSerie; ?>' last-download='<?= $serie['date_last_download']; ?>' current-season='<?= $serie['season']; ?>' current-episode='<?= $serie['episode_downloaded']; ?>' data-position='bottom' data-tooltip='Click para ver el último capítulo descargado' data-delay='700'><?= $serie['next_download']; ?></span>
                </td>
                <td><?= $serie['day_available']; ?></td>
                <td><?= $serie['season_finale']; ?></td>
                <td id='<?= 'actions_'.$idSerie; ?>' class='actions'>
                    <span class='buttons_block' style='<?= ($serie['download_status'] != 'finished') ? '' : 'display:none'; ?>'>
                        
                        <a name='download' id='<?= 'download_'.$idSerie; ?>' class="btn-floating light-blue darken-2 waves-effect waves-light tooltipped" data-position='bottom' data-tooltip='Descargar' data-delay='50'><i class="material-icons">add</i></a>
 

                        <span class='postpone_block' style='<?= ($serie['download_status'] != 'ok') ? '' : 'display:none'; ?>'>
                            <a name='postpone' id='<?= 'postpone_'.$idSerie; ?>' class="btn-floating blue-grey waves-effect waves-light tooltipped" data-position='bottom' data-tooltip='Posponer' data-delay='50'><i class="material-icons">restore</i></a>
                        </span>
                    </span>
                    <span class='label_finished_block' style='<?= ($serie['download_status'] == 'finished') ? '' : 'display:none'; ?>'>
                        <span class="new badge red lighten-1 center" data-badge-caption=""><strong>Finalizada</strong></span>
                    </span>
                </td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
</div> <!-- .row -->
<?php $this->load->view('footer'); ?>
