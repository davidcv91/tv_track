<!--DIALOG-->
<div class='modal fade' id='modal_delete_serie' data-backdrop='static'> 
    <div class='modal-dialog modal-lg' >
        <div class='modal-content'>
            <div class='modal-header bg-danger-custom'>
                <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>×</button>
                    <h4 class='modal-title'>Eliminar serie?</h4>
            </div>
            <div class='modal-body'>
                <p>Estás seguro de que quieres eliminar <q><strong><span class='name_serie'></span></strong></q></p>
                <form method='POST' action='delete_serie' id='form_delete_serie'>
                    <input type='hidden' name='id_serie' value=''>
                </form>
            </div>
            <div class='modal-footer'>
                <button type='button' class='btn btn-danger' id='submit_delete_serie'>
                    <span class='glyphicon glyphicon-remove'></span>&nbsp;Eliminar
                </button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->