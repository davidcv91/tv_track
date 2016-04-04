<?php $this->load->view('header'); ?>
<script type='text/javascript'>
    function format_number(num)
    {
        if (num < 10) return '0'+num;
        return num;
    }

    function update_status(row, status)
    {
        $(row).find('.status').each(function() {
            $(this).removeClass();
            $(this).addClass('status '+status);
        });
    }

    function remove_postpone_btn(row)
    {
        $(row).find('button[name="postpone"]').each(function() {
            $(this).hide();
        });
    }

    function show_alert_error()
    {
        $('#alert-error').html('Ha ocurrido un error');
        $('#alert-error').show().delay(3000).fadeOut();
    }

    function update_last_downloaded_info(row, data)
    {
        $(row).find('.last_downloaded').each(function() {
            var season = $(this).attr('season');
            var episode = parseInt($(this).attr('episode')) + 1;

            if (isNaN(episode)) episode = 1;
            episode = format_number(episode);
            $(this).html(season+'x'+episode);

            $(this).parent().effect('highlight', '', 1000);
            $(this).attr('episode', episode);
            $(this).tooltip().attr('data-original-title', data.current_date)

        });
    }

    $(document).ready(function () {

        /*Table events*/
        $('[data-toggle="tooltip"]').tooltip(); 

        $('table tr').mouseleave(function () {
            $(this).find('.actions').css('opacity', 0);
        });
        $('table tr').mouseenter(function () {
            $(this).find('.actions').css('opacity', 1);
        });

        $('button[name="download"]').click(function () {
            var id_serie = $(this).attr('idSerie');
            var row = '#id_'+id_serie;
            $(this).tooltip('hide');

            $.post({
                url: '<?= base_url().'download_episode'; ?>',
                data: {'id_serie': id_serie},
                success: function( data ) {
                    data = $.parseJSON(data);
                    if (data.result) {
                        update_status(row, 'ok');
                        remove_postpone_btn(row);
                        update_last_downloaded_info(row, data);
                    }
                    else show_alert_error();
                }
            });
        });

        $('button[name="postpone"]').click(function () {
            var id_serie = $(this).attr('idSerie');
            var row = '#id_'+id_serie;
                        
            $.post({
                url: '<?= base_url().'postpone_episode'; ?>',
                data: {'id_serie': id_serie},
                success: function( data ) {
                    data = $.parseJSON(data);
                    if (data.result) {
                        update_status(row, 'ok');
                        remove_postpone_btn(row);
                    }
                    else show_alert_error();
                }
            });
        });
        /*End table events*/
    });
</script>
<style>
    .status{
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
</style>
    <div class='alert alert-danger' id='alert-error' role='alert' style='display:none;'></div>
    <table class='table table-hover'>
        <thead>
            <tr>
                <th class='status'></th>
                <th class='name_col'>Serie</th>
                <th>Final</th>
                <th>Día disponible</th>
                <th>Último descargado</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($series_following)) foreach($series_following as $serie) { ?>
            <tr id='<?= 'id_'.$serie['id']; ?>'>
                <td class='status <?= $serie['status']; ?>'></td>
                <td class='name_col'><?= $serie['name']; ?></td>
                <td><?= $serie['final_episode']; ?></td>
                <td><?= $serie['day_new_episode']; ?></td>
                <td><span data-toggle='tooltip' data-container='body' data-placement='right' title='<?= $serie['last_download']; ?>' class='last_downloaded' season='<?= $serie['season']; ?>' episode='<?= $serie['episode_downloaded']; ?>'  ><?= $serie['last_downloaded']; ?></span></td>
                <td class='actions'>
                    <button type='button' name='download' class='btn btn-sm btn-primary btn-square' data-toggle='tooltip' data-container='body' data-placement='bottom' title='Descargar' idSerie='<?= $serie['id']; ?>'>
                        <span class='glyphicon glyphicon-plus-sign'></span>
                    </button>
                    <?php if ($serie['status'] != 'ok') { ?>
                    <button type='button' name='postpone' class='btn btn-sm btn-default btn-square' data-toggle='tooltip' data-container='body' data-placement='bottom' title='Posponer' idSerie='<?= $serie['id']; ?>'>
                        <span class='glyphicon glyphicon-time'></span>
                    </button>
                    <?php } ?>
                </td>
            </tr>
            <?php } ?>
        </tbody>
    </table>

<?php $this->load->view('footer'); ?>
