<?php
if(\Core\Auth::checkIfAuth()){
    redirect(route('user/index'));
}
?>
<h1 class="text-center">Wellcome</h1>
