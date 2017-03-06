<!--DIALOG-->
<div class='modal' id='modal_edit_serie'> 
    <div class='modal-content'>
        <div class="row">
            <h4 class='modal-title'>Editar serie</h4>
            <form method='POST' action='edit_serie' id='form_edit_serie' class='col s12'>
                <?php $this->load->view('modals/form_input_serie'); ?>
            </form>
        </div>
    </div>
    <div class='modal-footer'>
        <a class="btn-flat left red-text waves-effect waves-light btn-delete ">Eliminar</a>
        <a class="btn blue waves-effect waves-light" id="submit_edit_serie">Guardar</a>
    </div>
</div>