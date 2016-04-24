<!--DIALOG-->
<div class='modal fade' id='modal_edit_serie' data-backdrop='static'> 
    <div class='modal-dialog modal-sm' >
        <div class='modal-content'>
            <div class='modal-header bg-success-custom'>
                <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>×</button>
                    <h4 class='modal-title'>Editar serie</h4>
            </div>
            <div class='modal-body'>
                <form method='POST' action='edit_serie' id='form_edit_serie'>
                    <?php $this->load->view('modals/form_input_serie'); ?>
                </form>
            </div>
            <div class='modal-footer'>
                <button type='button' class='btn btn-danger pull-left btn-delete'>
                    <span class='glyphicon glyphicon-remove'></span>&nbsp;Eliminar
                </button>
                <button type='button' class='btn btn-success' id='submit_edit_serie'>
                    <span class='glyphicon glyphicon-edit'></span>&nbsp;Editar
                </button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->