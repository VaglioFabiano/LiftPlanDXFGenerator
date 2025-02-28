<?php

/**
 * @author Fabiano Vaglio
 */

  /* if (!isset($_SESSION['idUtente'])) {
            die("");
        }
        */

class DXF {

   
    function getString() {
        $strDXF = "";
        $strDXF .= $this->getHeaderString();
        $strDXF .= $this->getBodyString();
        return $strDXF;
    }

    function getHeaderString(){
        $srtDXF = "";
        
        return $srtDXF;
    }

    function getBodyString() {
        $strDXF = "";
        $strDXF .= "\nSECTION\n2\nENTITIES\n0\n";
        $strDXF .= $this->shape;
        $strDXF .= "ENDSEC\n0\nEOF";
        return $strDXF;
    }

   

    function addLine($x, $y, $z, $x2, $y2, $z2,$c,$tipo,$colore) {

        $str = "LINE\n" . "  5" . "\n" . $c."\n  8\n$c\n  6\n";
                if($tipo==0){
                    $str .="CONTINUOUS\n";
                if($colore==1){
                    $str .=" 62\n" . "     1\n";
                }elseif($colore==2){
                    $str .=" 62\n" . "     4\n";
                }
                $str .=" 10" . "\n" . $x . "\n" . " 20" . "\n" . $y . "\n" . " 30" . "\n" . $z .
                "\n" . " 11" . "\n" . $x2 . "\n" . " 21" . "\n" . $y2 . "\n" . " 31" . "\n" . $z2 . "\n 0\n";
                }elseif($tipo==1){
                $str .= "ACAD_ISO02W100\n";
                if($colore==1){
                    $str .=" 62\n" . "     1\n";
                }elseif($colore==2){
                    $str .=" 62\n" . "     4\n";
                }
                $str .=" 10" . "\n" . $x . "\n" . " 20" . "\n" . $y . "\n" . " 30" . "\n" . $z . "\n" .
                " 11" . "\n" . $x2 . "\n" . " 21" . "\n" . $y2 . "\n" . " 31" . "\n" . $z2 . "\n 0\n";
                }elseif($tipo==2){
                    $str .= "ACAD_ISO04W100\n";
                    if($colore==1){
                        $str .=" 62\n" . "     1\n";
                    }elseif($colore==2){
                        $str .=" 62\n" . "     4\n";
                    }
                    $str .=" 10" . "\n" . $x . "\n" . " 20" . "\n" . $y . "\n" . " 30" . "\n" . $z . 
                    "\n" . " 11" . "\n" . $x2 . "\n" . " 21" . "\n" . $y2 . "\n" . " 31" . "\n" . $z2 . "\n 0\n";
                }
                echo $x ." ". $y ." ". $x2 ." " . $y2 ." ";
                if($c==1){
                    $this->shape = $str; 
                    return $str;
                }else{
                    $this->shape .= $str; 
                    return $str;
                }
        
    }
    function addText($x, $y, $z, $text,$c,$colore) {
        $text = strtoupper($text);
        $str = "TEXT\n" .
                "  5" . "\n" .
                $c . "\n  8\n".$c."\n  6\nCONTINUOUS\n" ;
                if($colore==1){
                    $str.="    62". "\n".
                  "        1"."\n";
                }
                $str.=" 10\n" .
                $x . "\n" .
                " 20\n" .
                $y . "\n" .
                " 30\n" .
                $z . "\n" .
                " 40\n" .
                "30" . "\n" .
                "  1\n" .
                $text . "\n" .
                "  0\n";
        $this->shape .= $str;
        
        return $str;
    }
   
    function addCircle($x, $y, $z, $raggio,$c,$tipo) {
        $str = "CIRCLE\n" .
                "  5" . "\n" .
                $c . "\n  8\n".$c."\n  6" ;
                if($tipo==0){
                $str .= "\nCONTINUOUS\n" . " 10" . "\n" . $x . "\n" . " 20" . "\n" .
                $y . "\n" . " 30" . "\n" . $z . "\n" . " 40" . "\n" . $raggio . "\n" . " 0\n";
                }elseif($tipo==1){
                $str .="\nACAD_ISO02W100\n" . " 10" . "\n" . $x . "\n" . " 20" . "\n" . $y . "\n" . " 30" .
                "\n" . $z . "\n" . " 40" . "\n" . $raggio . "\n" . " 0\n";
                }elseif($tipo==2){
                $str .="\nACAD_ISO04W100\n" . " 10" . "\n" . $x . "\n" . " 20" . "\n" . $y . "\n" .
                " 30" . "\n" . $z . "\n" . " 40" . "\n" . $raggio . "\n" . " 0\n";
                }
        $this->shape .= $str;
        return $str;
    }
    function addSolid($x,$y,$z,$x1,$y1,$z1,$x2,$y2,$z2,$x3,$y3,$z3,$c,$colore){
        $str ="SOLID\n". "5" . "\n" . $c . "\n" ;
        if($colore==1){
        $str.="    8\n$c\n    62\n        1" . "\n" ;
        }elseif($colore==2){
            $str.="    8\n$c\n    62\n        4" . "\n" ;
        }else{
            $str.="    8\n$c\n    62\n        0" . "\n" ;
        }
        $str.="    10\n". $x . "\n" . "20" . "\n" .  $y . "\n" . "30" . "\n" .
        $z . "\n" . "11" . "\n" . $x1 . "\n" . "21" . "\n" .  $y1. "\n" . "31" . "\n" .
        $z1 . "\n" . "12"."\n". $x2 . "\n" . "22" . "\n" . $y2 . "\n" . "32" . "\n" .
        $z2 . "\n". "13"."\n". $x3 . "\n" . "23" . "\n" . $y3 . "\n" . "33" . "\n" . $z3 . "\n0\n";
        $this->shape .= $str;
        return $str;
    }
    function addArc($x,$y,$z,$raggio,$angoloinizio,$angolofine,$c){
        $str = "ARC\n". "  5\n". $c ."\n". "  8\n". "0\n". "10\n". $x ."\n". "20\n".
        $y . "\n". "30\n". $z . "\n". "40\n". $raggio . "\n" .  "50\n" . 
        $angoloinizio ."\n". "51\n" .$angolofine. "\n". "0\n";
        $this->shape .= $str;
        return $str;
    }
    function addSogliaTelpia_Centrale($spallettasx_vano,$luce,$soglia_piano,$distanza_muro_soglia,$misura_porte,$n_porte,$lunghezza_soglia,$c){
        $spessore=$soglia_piano+$distanza_muro_soglia;
        $larghezza_completa=$lunghezza_soglia;
        $inizio_soglia=($spallettasx_vano-$misura_porte-20);
        $sovrapposizione=((($misura_porte*$n_porte)-$luce)/$n_porte);//misura porte*n_porte deve essere maggiore di luce
        $distanza_scorrimento_pia=(($soglia_piano*20)/100)/($n_porte+1);//3.333
        $spessore_porte_pia=(($soglia_piano/($n_porte/2))-($distanza_scorrimento_pia+($distanza_scorrimento_pia/2)));
        $spessore_guida_porte_pia=($spessore_porte_pia-($distanza_scorrimento_pia*2));
        $vuotomezzo=0;
       
        //disegno soglia di cabina
        //disegnocontorno
                //lineaalta
                $str=$this->addLine(($inizio_soglia),$spessore,0,(($inizio_soglia)+$larghezza_completa),$spessore,0,$c,0,0);
                $c++;
            //linee laterali
                $str.=$this->addLine(($inizio_soglia),$spessore,0,($inizio_soglia),($spessore-$soglia_piano),0,$c,0,0);
                $c++;
                $str.=$this->addLine((($inizio_soglia)+$larghezza_completa),$spessore,0,(($inizio_soglia)+$larghezza_completa),($spessore-$soglia_piano),0,$c,0,0);
                $c++;
            //linea Bassa
                $str.=$this->addLine(($inizio_soglia),($spessore-$soglia_piano),0, (($inizio_soglia)+$larghezza_completa),($spessore-$soglia_piano),0,$c,0,0);
                $c++;
        //disegno porte e guide sinistra
        for($i=0;$i<($n_porte/2);$i++){
            if($i==(($n_porte/2)-1)){
                $vuotomezzo=8;
            }
            $distanza_sinistra=$spallettasx_vano-($sovrapposizione)+($misura_porte*$i)-(($sovrapposizione)*$i);
            $distanza_alto=$distanza_muro_soglia+$distanza_scorrimento_pia+($spessore_porte_pia*$i)+($distanza_scorrimento_pia*$i);
            //linea bassa
            $str.=$this->addLine(($distanza_sinistra),$distanza_alto,0,($distanza_sinistra+$misura_porte-$vuotomezzo),$distanza_alto,0,$c,0,0);
            $c++;
            //linea alta
            $str.=$this->addLine(($distanza_sinistra),($distanza_alto+$spessore_porte_pia),0,($distanza_sinistra+$misura_porte-$vuotomezzo),($distanza_alto+$spessore_porte_pia),0,$c,0,0);
            $c++;
            //linee laterali
            $str.=$this->addLine(($distanza_sinistra),$distanza_alto,0,($distanza_sinistra),($distanza_alto+$spessore_porte_pia),0,$c,0,0);
            $c++;
            $str.=$this->addLine(($distanza_sinistra+$misura_porte-$vuotomezzo),$distanza_alto,0,($distanza_sinistra+$misura_porte-$vuotomezzo),($distanza_alto+$spessore_porte_pia),0,$c,0,0);
            $c++;
            //disegno guide (2 linee e basta alta e bassa)
            //linea bassa 
            $str.=$this->addLine(($inizio_soglia),($distanza_alto+$distanza_scorrimento_pia),0,$distanza_sinistra,($distanza_alto+$distanza_scorrimento_pia),0,$c,0,0);
            $c++;
            //linea alta
            $str.=$this->addLine(($inizio_soglia),($distanza_alto+$distanza_scorrimento_pia+$spessore_guida_porte_pia),0,$distanza_sinistra,($distanza_alto+$distanza_scorrimento_pia+$spessore_guida_porte_pia),0,$c,0,0);
            $c++;
        }
        $vuotomezzo=0;
         //disegno porte e guide destra
         for($i=0;$i<($n_porte/2);$i++){
            if($i==(($n_porte/2)-1)){
                $vuotomezzo=8;
            }
            $distanza_destra=$spallettasx_vano+$luce+$sovrapposizione-($misura_porte*$i)+(($sovrapposizione)*$i);
            $distanza_alto=$distanza_muro_soglia+$distanza_scorrimento_pia+($spessore_porte_pia*$i)+($distanza_scorrimento_pia*$i);
            //linea bassa
            $str.=$this->addLine($distanza_destra,$distanza_alto,0,($distanza_destra-$misura_porte+$vuotomezzo),$distanza_alto,0,$c,0,0);
            $c++;
            //linea alta
            $str.=$this->addLine($distanza_destra,($distanza_alto+$spessore_porte_pia),0,($distanza_destra-$misura_porte+$vuotomezzo),($distanza_alto+$spessore_porte_pia),0,$c,0,0);
            $c++;
            //linee laterali
            $str.=$this->addLine(($distanza_destra),$distanza_alto,0,($distanza_destra),($distanza_alto+$spessore_porte_pia),0,$c,0,0);
            $c++;
            $str.=$this->addLine(($distanza_destra-$misura_porte+$vuotomezzo),$distanza_alto,0,($distanza_destra-$misura_porte+$vuotomezzo),($distanza_alto+$spessore_porte_pia),0,$c,0,0);
            $c++;
            //disegno guide (2 linee e basta alta e bassa)
            //linea bassa
            $str.=$this->addLine($distanza_destra,($distanza_alto+$distanza_scorrimento_pia),0,($lunghezza_soglia+$inizio_soglia),($distanza_alto+$distanza_scorrimento_pia),0,$c,0,0);
            $c++;
            //linea alta
            $str.=$this->addLine($distanza_destra,($distanza_alto+$distanza_scorrimento_pia+$spessore_guida_porte_pia),0,($lunghezza_soglia+$inizio_soglia),($distanza_alto+$distanza_scorrimento_pia+$spessore_guida_porte_pia),0,$c,0,0);
            $c++;
        }

         //quotazioni
            //sinistra
            $str.=$this->addQuotasx($inizio_soglia,$distanza_muro_soglia,$soglia_piano,1,$soglia_piano,$c);
            $c=$c+6;
            $str.=$this->addQuotasx($inizio_soglia,0,$distanza_muro_soglia,1,$distanza_muro_soglia,$c);
            $c=$c+6;
    }
    

    function SaveFile($filename) {
        while (false !== ob_get_clean());
        header("Content-Type: image/vnd.dxf");
        header("Content-Disposition: inline; filename=$filename");
        echo $this->getString();
        die();
    }

}
?>
