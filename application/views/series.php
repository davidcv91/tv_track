<?php $this->load->view('header'); ?>

<script type='text/javascript'>
    var original_value = '';
    var errors = false;


    $(document).ready(function () {
        /*Table events*/

        $('table tr').mouseleave(function () {
             $(this).find('.actions').css('opacity', 0);
        });

        $('table tr').mouseenter(function () {
             $(this).find('.actions').css('opacity', 1);
        });

        $('.status_switch').click(function () {
            var id_serie = $(this).closest('tr').attr('id');
            
            var status = $(this).is(':checked');
            if (status) status = 1;
            else status = 0;
            show_loading($(this));

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
            $('#modal_edit_serie #name').get(0).parentNode.MaterialTextfield.change(value);

            value = Boolean(parseInt(row.find('td[colname="vo"]').attr('vo')));
            if (value) $('#modal_edit_serie #vo').get(0).parentNode.MaterialSwitch.on();
            else $('#modal_edit_serie #vo').get(0).parentNode.MaterialSwitch.off();

            value = row.find('td[colname="season"]').html();
           $('#modal_edit_serie #season').get(0).parentNode.MaterialTextfield.change(value);

            value = row.find('td[colname="episodes"]').html();
            $('#modal_edit_serie #episodes').get(0).parentNode.MaterialTextfield.change(value);

            value = row.find('td[colname="day_new_episode"]').attr('numDay');
            $('#modal_edit_serie #day_new_episode').get(0).parentNode.MaterialTextfield.change(value);

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

    function show_loading(element) 
    {
        var spinner = document.createElement('div');
        spinner.className = 'spinner mdl-spinner mdl-js-spinner is-active';
        componentHandler.upgradeElement(spinner);
        $(element).closest('td').append(spinner);
        $(element).closest('.switch_container').hide();
    }

    function hide_loading(element) 
    {
        $(element).closest('.spinner').remove();
        $(element).closest('.switch_container').show();
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
        $(element).parent().addClass('is-invalid');
    }

    function has_success(element) 
    {
        $(element).parent().removeClass('is-invalid');
    }

</script>
<style>
    table {
        width: 100%;
    }
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
        margin: 10px 0px;
    }
    .status_switch {
        opacity: 0;
    }
</style>
    <table class='mdl-data-table mdl-js-data-table mdl-shadow--2dp'>
        <thead>
            <tr>
                <th></th>
                <th class='mdl-data-table__cell--non-numeric name_col'>Serie</th>
                <th>VO</th>
                <th>Temporada</th>
                <th>Capítulo final</th>
                <th>Día disponible</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php 
            if (!empty($series)) foreach($series as $serie) { 
                $serie_id = $serie['id'];
            ?>
            <tr id='<?= $serie_id; ?>'>
                <td>
                    <label class='mdl-switch mdl-js-switch mdl-js-ripple-effect switch_container' for='switch-<?= $serie_id; ?>'>
                        <input type='checkbox' id='switch-<?= $serie_id; ?>' class='status_switch mdl-switch__input' <?= ($serie['status'] == 1) ? 'checked' : ''; ?>>
                    </label>
                </td>
                <td class='mdl-data-table__cell--non-numeric name_col'>
                    <span class='name'><?= $serie['name']; ?></span>
                </td>
                <td colname='vo' vo='<?= $serie['vo']; ?>'>
                    <i class='material-icons'><?= ($serie['vo'] == 1) ? 'check' : 'close' ;?>
                </td>
                <td colname='season'><?= $serie['season']; ?></td>
                <td colname='episodes'><?= $serie['episodes']; ?></td>
                <td colname='day_new_episode' numDay='<?= $serie['day_new_episode']; ?>'><?= $serie['letter_day_new_episode']; ?></td>
                <td class='actions'>
                    <button id='edit-<?= $serie_id; ?>' class='btn-edit mdl-button mdl-js-button mdl-button--icon mdl-js-ripple-effect'>
                        <i class='material-icons'>mode_edit</i>
                    </button>
                    <span class='mdl-tooltip' data-mdl-for='edit-<?= $serie_id; ?>'>Editar</span>
                </td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
    <button type='button' id='add_serie' class='mdl-button mdl-js-button mdl-button--raised  mdl-button--colored mdl-js-ripple-effect pull-right' data-toggle='modal' data-target='#modal_add_serie'>
        Nueva serie
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
