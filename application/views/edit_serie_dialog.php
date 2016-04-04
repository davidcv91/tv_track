<!--DIALOG-->
<div class='modal fade' id='modal_edit_serie' data-backdrop='static'> 
    <div class='modal-dialog modal-sm' >
        <div class='modal-content'>
            <div class='modal-header bg-success-custom'>
                <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>×</button>
                    <h4 class='modal-title'>Editar serie</h4>
            </div>
            <div class='modal-body'>
                <form method='POST' action='edit_serie'>
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
                <button type='button' class='btn btn-danger pull-left' id='submit_delete_serie'>
                    <span class='glyphicon glyphicon-remove'></span>&nbsp;Eliminar
                </button>
                <button type='button' class='btn btn-success' id='submit_edit_serie'>
                    <span class='glyphicon glyphicon-edit'></span>&nbsp;Editar
                </button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->