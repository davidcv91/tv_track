<?php $this->load->view('header'); ?>

<script type='text/javascript'>
    var original_value = '';
    var errors = false;

    $(document).ready(function () {

        $('td').dblclick(function () {
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
                $(this).blur(); //save value
            }
        });

        $('td').blur(function() {
            $(this).removeAttr('contenteditable');
            save_value($(this));
        });

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
                //$('#modal_add_serie').modal('hide');
            }
        });

        $('#modal_add_serie').on('hidden.bs.modal', function (e) {
            $(this).find('input[type="text"], input[type="number"]').val('');
            $(this).find('input[type="checkbox"]').removeAttr('checked');
            $(this).find('select').val(0);
            $(this).find('.form-group').removeClass('has-error has-success');
        });


    });

    function has_error(element) {
        errors = true;
        $(element).parent().removeClass('has-success').addClass('has-error');
    }

    function has_success(element) {
        $(element).parent().removeClass('has-error').addClass('has-success');
    }

    function save_value(element) {
        var id = element.parent('tr').attr('id');
        var field = element.attr('colname');
        var value = element.html();
        if(original_value == value) return; 

        element.effect('highlight', '', 1000);

        $.post(
            '<?php echo base_url().'edit_field_serie'; ?>',
            {
                'id_serie': id,
                'field': field,
                'value': value
            },
            function( result ) {
                if(!result) {
                    element.html(original_value);
                    $('.alert-danger').html('Ha ocurrido un error');
                    $('.alert-danger').show().delay(3000).fadeOut();
                }
            }, 'json'
        );
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


</style>
    <div class='alert alert-danger' role='alert' style='display:none;'></div>
    <table class='table table-hover'>
        <thead>
            <tr>
                <th class='name_col'>Serie</th>
                <th>VO</th>
                <th>Temporada</th>
                <th>Capítulo final</th>
                <th>Día emisión</th>
            </tr>
        </thead>
        <tbody>
            <?php if(!empty($series)) foreach($series as $serie) { ?>
            <tr id='<?php echo $serie['id']; ?>'>
                <td colname='name' class='name_col'><?php echo $serie['name']; ?></td>
                <td colname='vo'><?php echo $serie['vo']; ?></td>
                <td colname='season'><?php echo $serie['season']; ?></td>
                <td colname='episodes'><?php echo $serie['episodes']; ?></td>
                <td colname='day_new_episode'><?php echo $serie['day_new_episode']; ?></td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
    <button type='button' class='btn btn-primary pull-right' data-toggle='modal' data-target='#modal_add_serie'>
Nueva serie</button>
     
<div class='modal fade' id='modal_add_serie' data-backdrop='static'> 
    <div class='modal-dialog modal-sm' >
        <div class='modal-content'>
            <div class='modal-header bg-primary'>
                <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>×</button>
                    <h4 class='modal-title'>Nueva serie</h4>
            </div>
            <div class='modal-body'>
                <form method='POST' action='add_serie'>
                    <div class='form-group'>
                        <label class='control-label' for='name'>Nombre:</label>
                        <input class='form-control' name='name' type='text'>
                    </div>

                    <div class='checkbox'>
                        <label>
                            <input name='vo' type='checkbox'><strong>VO?</strong>
                        </label>
                    </div>

                    <div class='form-group'>
                        <label class='control-label' for='season'>Temporada:</label>
                        <input class='form-control' name='season' type='number' min='0' required>
                    </div>

                    <div class='form-group'>
                        <label class='control-label' for='episodes'>Episodios de la temporada:</label>
                        <input class='form-control' name='episodes' type='number' min='1' required>
                    </div>

                    <div class='form-group'>
                        <label class='control-label' for='day_new_episode'>Día de emisión:</label>
                        <select class='form-control' name='day_new_episode' required>
                            <option value='0'>Selecciona un día</option>
                            <option value='1'>Lunes</option>
                            <option value='2'>Martes</option>
                            <option value='3'>Miércoles</option>
                            <option value='4'>Jueves</option>
                            <option value='5'>Viernes</option>
                            <option value='6'>Sábado</option>
                            <option value='7'>Domingo</option>
                        </select>
                    </div>
                </form>
            </div>
            <div class='modal-footer'>
                <button type='button' class='btn btn-primary' id='submit_new_serie'>Ok</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
    

<?php $this->load->view('footer'); ?>
