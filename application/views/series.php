<?php $this->load->view('header'); ?>
<style type="text/css">
    /*Fix style of validation on select element*/
    .select-wrapper input.select-dropdown.valid {
        border-bottom-color: #4CAF50;
    }
    .select-wrapper input.select-dropdown.invalid {
        border-bottom-color: #F44336;
    }
</style>
<script type='text/javascript'>
    var original_value = '';
    var errors = false;

    $(document).ready(function () {
        /*Table events*/

        $('#modal_add_serie').modal();
        $('#modal_edit_serie').modal();
        $('#modal_delete_serie').modal();
        $('select').material_select();  

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
            var name_serie = edit_modal.find('#name_modal').val();
            var id_serie =  edit_modal.find('#id_serie_modal').val();
            edit_modal.modal('close');

            var delete_modal = $('#modal_delete_serie');

            delete_modal.find('.name_serie_delete').html(name_serie);
            delete_modal.find('#id_serie_delete').val(id_serie);

            delete_modal.modal('open');
        });

        $('.btn-edit').click(function() {
            var modal = $('#modal_edit_serie');
            var row = $(this).closest('tr');
            var input_value = '';

            input_value = row.find('td .name').html();
            modal.find('#name_modal').val(input_value);

            input_value = row.find('td[colname="vo"]').children().hasClass('enabled');
            modal.find('#vo_modal').prop('checked', input_value);

            input_value = row.find('td[colname="season"]').html();
            modal.find('#season_modal').val(input_value);

            input_value = row.find('td[colname="episodes"]').html();
            modal.find('#episodes_modal').val(input_value);

            input_value = row.find('td[colname="day_new_episode"]').attr('numDay');
            modal.find('#day_new_episode_modal').val(input_value).material_select();

            input_value = $(this).closest('tr').attr('id');
            modal.find('#id_serie_modal').val(input_value);

            Materialize.updateTextFields();

            modal.modal('open');
        });

        $('.modal').modal({
            complete: clear_modal,
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

    function clear_modal() 
    {
        $(this).find('input[type="text"], input[type="number"], input[type="hidden"]').val('');
        $(this).find('input[type="checkbox"]').removeAttr('checked');
        $(this).find('select').val(0).material_select();
        $(this).find('.validate, .select-dropdown').removeClass('valid invalid');
        Materialize.updateTextFields();
    }

    function has_error(element) 
    {
        $(element).removeClass('valid').addClass('invalid');
        if ($(element).is('select')) {
            $(element).parent().find('.select-dropdown').removeClass('valid').addClass('invalid');
        }
    }

    function has_success(element) 
    {
        $(element).removeClass('invalid').addClass('valid');
        if ($(element).is('select')) {
            $(element).parent().find('.select-dropdown').removeClass('invalid').addClass('valid');
        }
    }

</script>
<style>
    .status_col {
        width: 5%;
    }
    .name_col{
        font-weight: bold;
    }
    th:not(.name_col), td:not(.name_col){
        text-align: center;
    }
    .actions {
        opacity: 0;
    }
    #add_serie {
        margin-bottom: 10px;
    }
</style>
<div class="row">
    <table class='bordered hoverable'>
        <thead>
            <tr>
                <th></th>
                <th class='name_col'>Serie</th>
                <th>VO</th>
                <th>Temporada</th>
                <th>Capítulos</th>
                <th>Día disponible</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php if(!empty($series)) foreach($series as $serie) { ?>
            <tr id='<?= $serie['id']; ?>' class='hoverable'>
                <td class='status_col'>
                    <span class="new badge green center" data-badge-caption="Siguiendo" style='<?= ($serie['status'] == 1) ? '' : 'display:none'; ?>'></span>
                    <span class="new badge yellow darken-2 center" data-badge-caption="Pendiente" style='<?= ($serie['status'] != 1) ? '' : 'display:none'; ?>'></span>
                </td>
                <td class='name_col'>
                    <span class='name'><?= $serie['name']; ?></span>
                </td>
                <td colname='vo'>
                    <?php if ($serie['vo']) { ?>
                        <i class="enabled tiny material-icons">check</i>
                    <?php } else { ?>

                        <i class="disabled tiny material-icons">clear</i>
                    <?php } ?>
                    
                </td>
                <td colname='season'><?= $serie['season']; ?></td>
                <td colname='episodes'><?= $serie['episodes']; ?></td>
                <td colname='day_new_episode' numDay='<?= $serie['day_new_episode']; ?>'><?= $serie['letter_day_new_episode']; ?></td>
                <td class='actions'>
                    <?php if($serie['status'] == 1) { ?>
                        <a currentStatus='1' class="btn-floating red waves-effect waves-light tooltipped btn-change-status" data-position='bottom' data-tooltip='Finalizada' data-delay='50'><i class="material-icons">pause</i></a>

                     <?php } else { ?>
                        <a currentStatus='0' class="btn-floating green waves-effect waves-light tooltipped btn-change-status" data-position='bottom' data-tooltip='Reanudar' data-delay='50'><i class="material-icons">play_arrow</i></a>
                    <?php } ?>
                    <a class="btn-floating blue waves-effect waves-light tooltipped btn-edit" data-position='bottom' data-tooltip='Editar serie' data-delay='50'><i class="material-icons">mode_edit</i></a>
                </td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
    <div id='add_serie' class="fixed-action-btn" data-target='modal_add_serie'>
        <a class="btn-floating light-blue btn-large waves-effect waves-dark hoverable">
            <i class="large material-icons">add</i>
        </a>
    </div>
</div>

<form method='POST' action='change_status' id='form_change_status'>
    <input type='hidden' name='id_serie'>
    <input type='hidden' name='field'>
    <input type='hidden' name='value'>
</form>

<?php $this->load->view('modals/new_serie'); ?>
<?php $this->load->view('modals/edit_serie'); ?>
<?php $this->load->view('modals/delete_serie'); ?>

<?php $this->load->view('footer'); ?>
