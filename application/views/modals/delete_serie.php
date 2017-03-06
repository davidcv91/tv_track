<!--DIALOG-->
<div class='modal' id='modal_delete_serie'> 
    <div class='modal-content'>
        <div class="row">
            <div class='col s12'>
                <h4 class='modal-title'>Eliminar <q><span class='name_serie_delete'></span></q></h4>
                <p>
                    Estás seguro de que quieres eliminar 
                    <q><strong><span class='name_serie_delete'></span></strong></q>
                    de la lista de series?
                </p>
                <form method='POST' action='delete_serie' id='form_delete_serie'>
                    <input type='hidden' name='id_serie' id='id_serie_delete' value=''>
                </form>
            </div>
        </div>
    </div>
    <div class='modal-footer'>
        <a class="btn-flat left waves-effect waves-light modal-action modal-close" id='cancel_delete'>Cancelar</a>
        <a class="btn red waves-effect waves-light" id='submit_delete_serie'>Eliminar</a>
    </div>
</div>