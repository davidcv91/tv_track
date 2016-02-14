<?php $this->load->view('header'); ?>
<script type="text/javascript">
    function format_number(num)
    {
        if(num < 10) return '0'+num;
        return num;
    }

    $(document).ready(function () {
        $('tbody tr').each(function () {

        });

        $('.download').click(function () {
            var id_serie = $(this).attr('id_serie');
            var row = '#id_'+id_serie;

            $.post({
                url: '<?php echo base_url().'download_episode'; ?>',
                data: {'id_serie': id_serie},
                success: function( resp ) {
                    $(row).find('.status').each(function() {
                        $(this).removeClass();
                        $(this).addClass('status ok');
                    });
                    $(row).find('.last_downloaded').each(function() {
                        var data = $(this).html();
                        data = data.split('x');
                        data[1] = format_number(parseInt(data[1])+1);
                        data = data.join('x');
                        $(this).html(data);
                    });
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
        background-color: #6aa84f;
    }
    .warning{
        background-color: darkorange;
    }
    .pending{
        background-color: #cc4125;
    }

    th:not(.name_col), td:not(.name_col){
        text-align: center;
    }
    td{
        vertical-align: middle !important;
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
            <tr id="<?php echo 'id_'.$serie['id']; ?>" class="test">
                <td class="status <?php echo $serie['status']; ?>"></td>
                <td class="name_col"><?php echo $serie['name']; ?></td>
                <td><?php echo $serie['final_episode']; ?></td>
                <td><?php echo $serie['day_new_episode']; ?></td>
                <td class="last_downloaded"><?php echo $serie['last_downloaded']; ?></td>
                <td>
                    <a class="download" style="font-size:25px;" href="#" id_serie="<?php echo $serie['id']; ?>">
                        <span class="glyphicon glyphicon glyphicon-cloud-download" aria-hidden="true"></span>
                    </a>
                </td>
            </tr>
            <?php } ?>
        </tbody>
    </table>

<?php $this->load->view('footer'); ?>
