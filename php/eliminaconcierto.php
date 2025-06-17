<?php
require_once "cad.php";

$cad = new CAD();
$conciertos = $cad->traeConciertos();

if (isset($_GET['idConcierto'])) {
    if ($cad->eliminaConcierto($_GET['idConcierto'])) {
        header("Location: eliminarconcierto.php?msg=Concierto eliminado con éxito");
        exit();
    } else {
        $errorMsg = "Error al eliminar el concierto.";
    }
}
?>
