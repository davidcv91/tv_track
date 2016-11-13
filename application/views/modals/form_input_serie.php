<style>
.mdl-textfield__input {
    margin-bottom: 5px;
}
.mdl-custom-switch-container{
    padding-bottom: 20px;
}
.mdl-custom-switch-container .mdl-switch__label {
    color: rgb(63,81,181);
    font-size: 12px;
}

</style>
<div class='mdl-textfield mdl-js-textfield mdl-textfield--floating-label'>
    <label class='mdl-textfield__label' for='name'>Nombre</label>
    <input class='mdl-textfield__input' name='name' id='name' type='text'>
</div>

<div class='mdl-custom-switch-container'>
    <label class='mdl-switch mdl-js-switch mdl-js-ripple-effect' id='check'>
      <input type='checkbox' name='vo' id='vo' class='mdl-switch__input'>
      <span class='mdl-switch__label'>V.O.</span>
    </label>
</div>

<div class='mdl-textfield mdl-js-textfield mdl-textfield--floating-label'>
    <label class='mdl-textfield__label' for='season'>Temporada</label>
    <input class='mdl-textfield__input' name='season' id='season' type='number' min='0'>
</div>

<div class='mdl-textfield mdl-js-textfield mdl-textfield--floating-label'>
    <label class='mdl-textfield__label' for='episodes'>Episodios de la temporada</label>
    <input class='mdl-textfield__input' name='episodes' id='episodes' type='number' min='1'>
</div>

<div class='mdl-textfield mdl-js-textfield mdl-textfield--floating-label'>
    <label class='mdl-textfield__label' for='day_new_episode'>Día disponible</label>
    <select class='mdl-textfield__input' name='day_new_episode' id='day_new_episode'>
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
<input type='hidden' name='id_serie' value=''>