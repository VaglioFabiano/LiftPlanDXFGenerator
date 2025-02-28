<?php
/**
 * @author Fabiano Vaglio 
 */
ob_start();
require_once 'oggettidxf.php';
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>DXF_Downloading_page</title>
        
        
        
    </head>
    

   
   

        <?php

        $shape = new DXF();
       
        //variabili generiche
        $contatore=1;
        $tipo=0;
        $colore=0;
        

//VANO APERTURA SOLO FRONTALE
//VARIABILI

    //variabili cabina
        $vc_distanzasx_vano_cabina=$_POST["Distanzasx"];
     
        $c_profondita_interna=$_POST["cabina_lunghezza"];
        $c_larghezza_interna=$_POST["cabina_larghezza"];
        $c_spessore_pareti=$_POST["cabina_spessore_pareti"];
        $c_larghezza_esterna=$c_larghezza_interna+$c_spessore_pareti+$c_spessore_pareti;            
        $c_spalletta_sx=$_POST["cabina_spalletta_lunghezza_sx"];
        $c_spalletta_dx=$_POST["cabina_spalletta_lunghezza_dx"];
        $c_luce=($c_larghezza_interna-($c_spalletta_sx+$c_spalletta_dx));
        
        $c_spessore_spallette_frontali=$_POST["cabina_spessore_spalletta_porta"];
        $c_area_cabina=($c_larghezza_interna/1000)*($c_profondita_interna/1000);

    //variabili vano
        $v_posteriore= $_POST["vano_larghezza"];
        
        
        $v_spalletta_dx=$_POST["vano_spalletta_lunghezza_dx"];
        $v_spalletta_sx=$_POST["vano_spalletta_lunghezza_sx"];
        $v_destra= $_POST["vano_profondita"];
        $v_sinistra= $v_destra;
        $luce_grezza=$v_posteriore-$v_spalletta_sx-$v_spalletta_dx;
        $altezza_vano_portale_grezzo=$_POST["vano_altezza"];
        
        $v_anteriore= $v_posteriore;
        $v_spessore_pareti_vano=200;
        $luce_netta=$v_posteriore-$v_spalletta_sx-$v_spalletta_dx;

     //Tipi di contrappeso:
     //-Guide
     //-Bordiglioni
     //niente se non c'è
    

     $modello_contrappeso=$_POST["contrappeso_tipo"];
     $modello_contrappeso=strtoupper($modello_contrappeso);
     
//INSERIMENTO DATI NEL DATABASE

        $conn = new mysqli("localhost", "root","","test");
        
        if($conn->connect_error){
            die("Connessione fallita".$conn->connect_error);
        
        }
        $sql = "INSERT INTO datiNuoviImpianti (
            vano_larghezza,
            vano_profondita,
            vano_luce,
            vano_spalletta_lunghezza_dx,
            vano_spalletta_lunghezza_sx,
            vano_altezza,cabina_lunghezza,
            cabina_larghezza,
            cabina_telaio_altezza,
            cabina_luce,
            cabina_luce_mezzacabina,
            cabina_spessore_spalletta_porta,
            cabina_spessore_pareti,
            cabina_spalletta_lunghezza_dx,
            cabina_spalletta_lunghezza_sx,
            contrappeso_tipo,
            contrappeso_posizione,
            contrappeso_larghezza,
            contrappeso_dfg,
            contrappeso_distanza_vano,
            contrappeso_distanza_cabina,
            contrappeso_guida_distanza_orizzontale,
            contrappeso_guida_distanza_verticale,
            soglia_tipo,
            soglia_lunghezza_porte,
            soglia_numero_porte_cabina,
            soglia_numero_porte_piano,
            soglia_spessore_cabina,
            soglia_spessore_piano,
            soglia_distanza_soglie,
            soglia_cabina_riporto,
            soglia_piano_riporto,
            arcata_tipo,
            arcata_posizione,
            arcata_dfg,
            arcata_guida_orizzontale,
            arcata_guida_verticale,
            arcata_spessore,
            quadro_posizione,
            pulsante_piano,
            telaio_spessore,
            telaio_profondita,
            telaio_incasso_laterale)
        VALUES (
            '$v_posteriore',
            '$v_destra',
            '$luce_grezza',
            '$v_spalletta_dx',
            '$v_spalletta_sx',
            '$altezza_vano_portale_grezzo',
            '$c_profondita_interna',
            '$c_larghezza_interna',
            '$altezza_telaio',
            '$c_luce',
            0,
            '$c_spessore_spallette_frontali',
            '$c_spessore_pareti',
            '$c_spalletta_dx',
            '$c_spalletta_sx',
            '$modello_contrappeso',
            '$posizione_contrappeso',
            '$spessore_contrappeso',
            '$DFG_Contrappeso',
            0,
            0,
            '$distanzaAttacco_Guida_Contrappeso_Orizzontale',
            '$distanzaAttacco_guida_Contrappeso_verticale',
            '$appoggio',
            '$s_misura_porta',
            '$n_porte_cabina',
            '$n_porte_piano',
            '$s_spessore_soglia_di_cabina',
            '$s_spessore_soglia_di_piano',
            '$s_distanza_soglie',
            '$s_riporto_di_cabina',
            '$s_riporto_di_piano',
            '$modello_arcata',
            '$posizione_arcata_sedia',
            '$DFG_Arcata',
            '$a_distanza_guidaArcata_vano_orizzontale',
            '$a_distanza_guidaArcata_vano_verticale',
            '$a_spessore_arcata',
            '$q_parete_quadro',
            '$q_posizione_pulsante_piano',
            '$s_spessore_telaio_porta',
            '$s_profondita_telaio_porta',
            0)";
        if (mysqli_query($conn, $sql)) {
        echo "New record created successfully";
        } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
        }
        $conn->close();



//DISEGNO CABINA
        //DISEGNO CABINA
        $tipo=0;

        //parete posteriore
            
            $shape->addLine($vc_distanzasx_vano_cabina,(($c_spessore_soglia+($c_spessore_pareti)+$c_profondita_interna+$c_spessore_spallette_frontali)),0,($vc_distanzasx_vano_cabina+$c_larghezza_interna+
            (2*$c_spessore_pareti)),($c_spessore_soglia+$c_spessore_spallette_frontali+($c_spessore_pareti)+$c_profondita_interna),0,$contatore,$tipo,$colore);

            $contatore++;

            $shape->addLine(($vc_distanzasx_vano_cabina+$c_spessore_pareti),($c_spessore_soglia+
            $c_spessore_spallette_frontali+$c_profondita_interna),0,($vc_distanzasx_vano_cabina+$c_spessore_pareti+
            $c_larghezza_interna),($c_spessore_soglia+$c_spessore_spallette_frontali+$c_profondita_interna),
            0,$contatore,$tipo,$colore);

            $contatore++;

            $shape->addText($vc_distanzasx_vano_cabina+$c_spessore_pareti+($c_larghezza_interna/2)-(16*30.81),
            $s_distanza_soglia_muro+$s_spessore_soglia_di_piano+$s_distanza_soglie+$s_spessore_soglia_di_cabina+
            $c_spessore_spallette_frontali+$c_profondita_interna-100,0,"AREA CABINA MQ ".$c_area_cabina,$contatore,1);

            $contatore++;


//STAMPA TOTALE
        $shape->SaveFile("Disegno_Cabina3_0.dxf");        
        
        $dxfstring = $shape->getString();

        ?>
    </body>
</html>