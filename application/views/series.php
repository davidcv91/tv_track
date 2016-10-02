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
            var id_serie = $(this).closest('tr').attr('id');
            var current_status = $(this).attr('currentStatus');

            var status = 1;
            if(current_status == 1) status = 0;

            change_status(id_serie, 'status', status);
            
        });
        /*End table events*/


        /*Modal events*/
        $('#submit_new_serie').click(function () {
            var is_valid = validate_form_modal($('#form_new_serie'));

            if(is_valid) $('#form_new_serie').submit();
        });
        
        $('#submit_edit_serie').click(function () {
            var is_valid = validate_form_modal($('#form_edit_serie'));

            if(is_valid) $('#form_edit_serie').submit();
        });

        $('#submit_delete_serie').click(function () {
            
            $('#form_delete_serie').submit();
        });

        $('.btn-delete').click(function () {
            var edit_modal = $('#modal_edit_serie');
            var name_serie = edit_modal.find('input[name="name"]').val();
            var id_serie =  edit_modal.find('input[name="id_serie"]').val();
            edit_modal.modal('hide');

            var delete_modal = $('#modal_delete_serie');

            delete_modal.find('.name_serie').html(name_serie);
            delete_modal.find('input[name="id_serie"]').val(id_serie);

            delete_modal.modal('show');
        });

        $('.btn-edit').click(function() {
            var modal = $('#modal_edit_serie');

            var row = $(this).closest('tr');

            var value = row.find('td .name').html();
            modal.find('input[name="name"]').val(value);

            value = Boolean(parseInt(row.find('td[colname="vo"]').html()));
            modal.find('input[name="vo"]').prop('checked', value);

            value = row.find('td[colname="season"]').html();
            modal.find('input[name="season"]').val(value);

            value = row.find('td[colname="episodes"]').html();
            modal.find('input[name="episodes"]').val(value);

            value = row.find('td[colname="day_new_episode"]').attr('numDay');
            modal.find('select[name="day_new_episode"]').val(value);

            value = $(this).closest('tr').attr('id');
            modal.find('input[name="id_serie"]').val(value);

            modal.modal('show');
        });

        $('.modal').on('hidden.bs.modal', function () {
            hide_modal($(this))
        });

        /*End modal events*/
    });

    function change_status(id, field, value) 
    {
        var form = $('#form_change_status');

        form.find('input[name="id_serie"]').val(id);
        form.find('input[name="field"]').val(field);
        form.find('input[name="value"]').val(value);

        form.submit();
    }

    function validate_form_modal(modal) 
    {
        var name_input = $(modal).find('input[name="name"]');
        var season_input = $(modal).find('input[name="season"]');
        var episodes_input = $(modal).find('input[name="episodes"]');
        var day_new_episode_input = $(modal).find('select[name="day_new_episode"]');

        var input_error = [];
        var input_success = [];
        if (name_input.val() == '') input_error.push(name_input);
        else input_success.push(name_input);

        if (season_input.val() == '' || season_input.val() < 0) input_error.push(season_input);
        else input_success.push(season_input);

        if (episodes_input.val() == '' || episodes_input.val() <= 0) input_error.push(episodes_input);
        else input_success.push(episodes_input);

        if (day_new_episode_input.val() == 0) input_error.push(day_new_episode_input);
        else input_success.push(day_new_episode_input);

        $.each(input_error, function () {
             has_error($(this));
        });

        $.each(input_success, function () {
             has_success($(this));
        });

        if(input_error.length == 0) return true;
        else return false;
    }

    function hide_modal(modal) {
        $(modal).find('input[type="text"], input[type="number"], input[type="hidden"]').val('');
        $(modal).find('input[type="checkbox"]').removeAttr('checked');
        $(modal).find('select').val(0);
        $(modal).find('.form-group').removeClass('has-error has-success');
    }

    function has_error(element) 
    {
        $(element).parent().removeClass('has-success').addClass('has-error');
    }

    function has_success(element) 
    {
        $(element).parent().removeClass('has-error').addClass('has-success');
    }

</script>
<style>
    .name_col{
        font-weight: bold;
    }
    th:not(.name_col), td:not(.name_col){
        text-align: center;
    }
    .btn-square {
      width: 30px;
      height: 30px;
      padding: 6px 0;
      font-size: 12px;
    }
    .actions {
        opacity: 0;
    }
    .close{
        color: white;
        opacity: 1;
    }
    .bg-success-custom {
        background-color: #5cb85c;
        color: white;
    }
    .bg-danger-custom{
        background-color: #d9534f;
        color: white;
    }
    #add_serie {
        margin-bottom: 10px;
    }
</style>
    <table class='table table-hover table-striped'>
        <thead>
            <tr>
                <th class='name_col'>Serie</th>
                <th>VO</th>
                <th>Temporada</th>
                <th>Capítulo final</th>
                <th>Día disponible</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php if(!empty($series)) foreach($series as $serie) { ?>
            <tr id='<?= $serie['id']; ?>'>
                <td class='name_col'>
                    <?= $serie['label_name']; ?>
                    <span class='name'><?= $serie['name']; ?></span>
                </td>
                <td colname='vo'><?= $serie['vo_img']; ?></td>
                <td colname='season'><?= $serie['season']; ?></td>
                <td colname='episodes'><?= $serie['episodes']; ?></td>
                <td colname='day_new_episode' numDay='<?= $serie['day_new_episode']; ?>'><?= $serie['letter_day_new_episode']; ?></td>
                <td class='actions'>
                    <?php if($serie['status'] == 1) { ?>
                        <button type='button' class='btn btn-sm btn-danger btn-square btn-change-status' data-toggle='tooltip' data-container='body' data-placement='bottom' title='Finalizada' currentStatus='1'>
                            <span class='glyphicon glyphicon-pause'></span>
                        </button>
                     <?php } else { ?>
                        <button type='button' class='btn btn btn-sm btn-success btn-square btn-change-status' data-toggle='tooltip' data-container='body' data-placement='bottom' title='Reanudar' currentStatus='0'>
                            <span class='glyphicon glyphicon-play'></span>
                        </button>
                    <?php } ?>
                    <button type='button' class='btn btn-sm btn-default btn-square btn-edit' data-toggle='tooltip' data-container='body' data-placement='bottom' title='Editar serie'>
                        <span class='glyphicon glyphicon-edit'></span>
                    </button>
                </td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
    <button type='button' id='add_serie' class='btn btn-primary pull-right' data-toggle='modal' data-target='#modal_add_serie'>
        <span class='glyphicon glyphicon-plus'></span>&nbsp;Nueva serie
    </button>


<form method='POST' action='change_status' id='form_change_status'>
    <input type='hidden' name='id_serie'>
    <input type='hidden' name='field'>
    <input type='hidden' name='value'>
</form>

<?php $this->load->view('modals/new_serie'); ?>
<?php $this->load->view('modals/edit_serie'); ?>
<?php $this->load->view('modals/delete_serie'); ?>

<?php $this->load->view('footer'); ?>
