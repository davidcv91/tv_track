<?php $this->load->view('header'); ?>
<script type="text/javascript">
    function format_number(num)
    {
        if(num < 10) return '0'+num;
        return num;
    }

    $(document).ready(function () {

        $('[data-toggle="tooltip"]').tooltip(); 

        $('table tr').mouseleave(function () {
            $(this).find('.actions').css('opacity', 0);
        });
        $('table tr').mouseenter(function () {
            $(this).find('.actions').css('opacity', 1);
        });

        $('#download').click(function () {
            var id_serie = $(this).attr('id_serie');
            var row = '#id_'+id_serie;

            $.post({
                url: '<?php echo base_url().'download_episode'; ?>',
                data: {'id_serie': id_serie},
                success: function( result ) {
                    result = $.parseJSON(result);
                    if(result) {
                        $(row).find('.status').each(function() {
                            $(this).removeClass();
                            $(this).addClass('status ok');
                        });
                        $(row).find('.last_downloaded').each(function() {
                            var data = $(this).html();
                            if(data == '-') location.reload();
                            else {
                                data = data.split('x');
                                data[1] = format_number(parseInt(data[1])+1);
                                data = data.join('x');
                                $(this).html(data);
                                $(this).parent().effect('highlight', '', 1000);
                            }
                        });
                    }
                }
            });
        });

        $('#postpone').click(function () {
            var id_serie = $(this).attr('id_serie');
            var row = '#id_'+id_serie;

            $.post({
                url: '<?php echo base_url().'postpone_episode'; ?>',
                data: {'id_serie': id_serie},
                success: function( result ) {
                    result = $.parseJSON(result);
                    if(result) {
                        $(row).find('.status').each(function() {
                            $(this).removeClass();
                            $(this).addClass('status ok');
                        });
                    }
                }
            });
        });
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
    .btn-circle {
        width: 30px;
        height: 30px;
        text-align: center;
        padding: 6px 0;
        font-size: 12px;
        border-radius: 50%;
    }
    .glyphicon{
        font-size: 15px;
    }
</style>
    <table class="table table-hover">
        <thead>
            <tr>
                <th class="status"></th>
                <th class="name_col">Serie</th>
                <th>Final</th>
                <th>Día disponible</th>
                <th>Último descargado</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php if(!empty($series_following)) foreach($series_following as $serie) { ?>
            <tr id="<?php echo 'id_'.$serie['id']; ?>">
                <td class="status <?php echo $serie['status']; ?>"></td>
                <td class="name_col"><?php echo $serie['name']; ?></td>
                <td><?php echo $serie['final_episode']; ?></td>
                <td><?php echo $serie['day_new_episode']; ?></td>
                <td><span data-toggle="tooltip" data-container="body" data-placement="right" title="<?php echo $serie['last_download']; ?>" class="last_downloaded"><?php echo $serie['last_downloaded']; ?></span></td>
                <td class='actions' style='opacity: 0;'>
                    <button type="button" id="download" class="btn btn-sm btn-primary btn-circle" data-toggle="tooltip" data-container="body" data-placement="bottom" title="Descargar" id_serie="<?php echo $serie['id']; ?>">
                        <span class="glyphicon glyphicon-plus-sign"></span>
                    </button>

                    <button type="button" id="postpone" class="btn btn-sm btn-default btn-circle" data-toggle="tooltip" data-container="body" data-placement="bottom" title="Aplazar" class="download" id_serie="<?php echo $serie['id']; ?>">
                        <span class="glyphicon glyphicon-time"></span>
                    </button>
                </td>
            </tr>
            <?php } ?>
        </tbody>
    </table>

<?php $this->load->view('footer'); ?>
