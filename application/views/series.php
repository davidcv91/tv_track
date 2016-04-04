<?php $this->load->view('header'); ?>

<script type='text/javascript'>
    var original_value = '';
    var errors = false;

    $(document).ready(function () {
        
        /*Table events*/
        $('[data-toggle="tooltip"]').tooltip();

        $('table tr').mouseleave(function () {
             $(this).find('.actions').css('opacity', 0);
        });

        $('table tr').mouseenter(function () {
             $(this).find('.actions').css('opacity', 1);
        });

        $('.btn-change-status').click(function () {
            var id_serie = $(this).attr('idSerie');
            var current_status = $(this).attr('currentStatus');

            var status;
            if(current_status == 1) status = 0;
            else status = 1;

            edit_field(id_serie, 'status', status);
            location.reload();
        });
        /*End table events*/

        /*Editable cells events*/
        $('td').dblclick(function () {
            if($(this).hasClass('non-editable')) return;
            original_value = $(this).html();
            $(this).attr('contenteditable', true);
            $(this).focus();
        });

        $('td').keydown(function(e) {
            if (e.keyCode == 27) { //esc
                $(this).html(original_value);
                $(this).removeAttr('contenteditable');
            }
            else if (e.keyCode == 13) { //enter
                e.preventDefault();
                save_value($(this)); //save value
            }
        });

        $('td').blur(function() {
            save_value($(this));
        });
        /*End editable cells events*/

        /*Dialog events*/
        $('#submit_new_serie').click(function () {
            var name = $('input[name="name"]').val();
            var vo = $('input[name="vo"]').is(':checked');
            var season = $('input[name="season"]').val();
            var episodes = $('input[name="episodes"]').val();
            var day_new_episode = $('select[name="day_new_episode"]').val();

            errors = false;
            if(name == '') has_error($('input[name="name"]'));
            else has_success($('input[name="name"]'));

            if(season == '' || season < 0) has_error($('input[name="season"]'));
            else has_success($('input[name="season"]'));

            if(episodes == '' || episodes <= 0) has_error($('input[name="episodes"]'));
            else has_success($('input[name="episodes"]'));

            if(day_new_episode == 0) has_error($('select[name="day_new_episode"]'));
            else has_success($('select[name="day_new_episode"]'));

            if(!errors) {
                $('form').submit();
            }
        });

        $('.btn-edit').click(function() {
            var modal = $('#modal_edit_serie');

            var row = $(this).closest('tr');

           var value = row.find('td .name').html();
           $('#modal_edit_serie').find('input[name="name"]').val(value);

           value = Boolean(parseInt(row.find('td[colname="vo"]').html()));
           $('#modal_edit_serie').find('input[name="vo"]').prop('checked', value);

           value = row.find('td[colname="season"]').html();
           $('#modal_edit_serie').find('input[name="season"]').val(value);

           value = row.find('td[colname="episodes"]').html();
           $('#modal_edit_serie').find('input[name="episodes"]').val(value);

           value = row.find('td[colname="day_new_episode"]').attr('numDay');
           $('#modal_edit_serie').find('select[name="day_new_episode"]').val(value);

            modal.modal('show');
        });

        $('#modal_add_serie').on('hidden.bs.modal', function () {
            $(this).find('input[type="text"], input[type="number"]').val('');
            $(this).find('input[type="checkbox"]').removeAttr('checked');
            $(this).find('select').val(0);
            $(this).find('.form-group').removeClass('has-error has-success');
        });
        /*End dialog events*/
    });

    function save_value(element)
    {
        element.removeAttr('contenteditable');

        var id = element.parent('tr').attr('id');
        var field = element.attr('colname');
        var new_value = element.html();

        if(original_value == new_value) return; 

        element.effect('highlight', '', 1000);

        edit_field(id, field, new_value, element);
    }

    function edit_field(id, field, value, element) 
    {
        $.post(
            '<?= base_url().'edit_field_serie'; ?>',
            {
                'id_serie': id,
                'field': field,
                'value': value
            },
            function( result ) {
                if(!result) {
                    if(element != undefined) element.html(original_value);
                    show_alert_error();
                }
            }
        );
    }

    function has_error(element) 
    {
        errors = true;
        $(element).parent().removeClass('has-success').addClass('has-error');
    }

    function has_success(element) 
    {
        $(element).parent().removeClass('has-error').addClass('has-success');
    }

    function show_alert_error()
    {
        $('#alert-error').html('Ha ocurrido un error');
        $('#alert-error').show().delay(3000).fadeOut();
    }

</script>
<style>
    .alert{
        position: fixed;
        top: 15%;
        right:40%;
        left:40%;
        width: auto;
        z-index: 1;
        text-align: center;
    }
    .name_col{
        font-weight: bold;
    }
    th:not(.name_col), td:not(.name_col){
        text-align: center;
    }
    .close{
        color: white;
        opacity: 1;
    }

    .btn-square {
      width: 30px;
      height: 30px;
      padding: 6px 0;
      font-size: 12px;
    }

    .bg-success-custom {
        background-color: #5cb85c;
        color: white;
    }
</style>
    <div class='alert alert-danger' id='alert-error' role='alert' style='display:none;'></div>
    <table class='table table-hover table-striped'>
        <thead>
            <tr>
                <th class='name_col'>Serie</th>
                <th>VO</th>
                <th>Temporada</th>
                <th>Capítulo final</th>
                <th>Día emisión</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php if(!empty($series)) foreach($series as $serie) { ?>
            <tr id='<?= $serie['id']; ?>'>
                <td colname='name' class='name_col non-editable'><?= $serie['label'];?><span class='name'><?= $serie['name']; ?></span></td>
                <td colname='vo'><?= $serie['vo']; ?></td>
                <td colname='season'><?= $serie['season']; ?></td>
                <td colname='episodes'><?= $serie['episodes']; ?></td>
                <td colname='day_new_episode' numDay='<?= $serie['day_new_episode']; ?>'><?= $serie['letter_day_new_episode']; ?></td>
                <td class='non-editable actions' style='opacity: 0;'>
                    <?php if($serie['status'] == 1) { ?>
                        <button type='button' class='btn btn-sm btn-danger btn-square btn-change-status' data-toggle='tooltip' data-container='body' data-placement='bottom' title='Finalizada' currentStatus='1' idSerie='<?= $serie['id']; ?>'>
                            <span class='glyphicon glyphicon-pause'></span>
                        </button>
                     <?php } else { ?>
                        <button type='button' class='btn btn btn-sm btn-success btn-square btn-change-status' data-toggle='tooltip' data-container='body' data-placement='bottom' title='Reanudar' currentStatus='0' idSerie='<?= $serie['id']; ?>'>
                            <span class='glyphicon glyphicon-play'></span>
                        </button>
                    <?php } ?>
                    <button type='button' class='btn btn-sm btn-default btn-square btn-edit' data-toggle='tooltip' data-container='body' data-placement='bottom' title='Editar serie' idSerie='<?= $serie['id']; ?>'>
                        <span class='glyphicon glyphicon-edit'></span>
                    </button>
                </td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
    <button type='button' class='btn btn-primary pull-right' data-toggle='modal' data-target='#modal_add_serie'>
    <span class='glyphicon glyphicon-plus'></span>&nbsp;Nueva serie</button>


<?php $this->load->view('new_serie_dialog'); ?>
<?php $this->load->view('edit_serie_dialog'); ?>

<?php $this->load->view('footer'); ?>
