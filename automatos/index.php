<?php

echo"<html>
    <head>
        <meta charset='utf-8'>
        <title></title>
    </head>
        <body>
    ";
    $cor_td1 = '#E0EEE0';
    $cor_td2 = '#C1FFC1';
    $arquivo = fopen('./frase.txt', 'r'); //abrinco o arquivo txt
    while (!feof($arquivo)) {
        $char .= fgetc($arquivo);
    }

//ESCREVE A FRASE SEM OS ESPAÇOS DUPLOS
    $frase = "$char";
    $frase = trim($frase);
    $frase = preg_replace('/\s(?=\s)/', '', $frase);
    $frase = preg_replace('/[\n\r\t]/', ' ', $frase);

//SEPARA E LER AS LINHAS, CONTANDO QUANTAS PALAVRAS EXIXTEM EM CADA LINHA
    $linha = explode(PHP_EOL, $frase);
    $Tpalavaras = 0;
    for ($posl = 0; $posl < count($linha); ++$posl) {
        if ($linha[$posl] != PHP_EOL) {
            $palavras = explode(' ', $linha[$posl]);
            $Tpalavras += count($palavras);
        }
    }
//CONTA OS CARACTERES DA FRASE E OS ORDENA

    $str = "$frase";
    $dst = implode('', array_unique(str_split($str)));
    $numCaracter1 = strlen($dst);
    $inicio = null;
    for ($i = 0; $i < $numCaracter1; ++$i) {
        for ($j = 0; $j < $numCaracter1; ++$j) {
            if ($dst[$i] < $dst[$j]) {
                $inicio = $dst[$i];
                $dst[$i] = $dst[$j];
                $dst[$j] = $inicio;
            }
        }
    }

    echo"
    <table border=0 align=center width=1000 bgcolor ='$cor_td3'>
			<tr align = center bgcolor =  $cor_td1>
				<td   bgcolor =  $cor_td2><b>Frase analisada</b> </td>
				<td height=30px>$frase</td>
			</tr>
			<tr align = center bgcolor = $cor_td1 >
				<td height=30px bgcolor =  $cor_td2 ><b>Número de Palavras na frase</b> </td>
				<td> $Tpalavras</td>
			</tr>
            <tr align = center bgcolor = $cor_td1 >
                <td height=30px bgcolor =  $cor_td2><b>Alfabeto</b></td>
               <td>";
//IMPRIMINDO CARA CARACTER DO ALFABETO
 $espaco = 0;
    for ($i = 0; $i < $numCaracter1; ++$i) {
        // escreve cada carecter da frase

        if ($dst[$i] != ' ') {
            echo" $dst[$i] <b><font size=5>/</font></b>  ";
        } else {
            ++$espaco;
        }
    }
    $c = $numCaracter1 - $espaco;

    echo"</td>
            <tr align = center bgcolor = $cor_td1 >
				<td height=30px bgcolor =  $cor_td2><b>Número de caracteres no alfabeto</b></td>
				<td> $c </td>
			</tr>
           </table>
           </p>
          <center>  <b>Obs : Na próxima tabela considere {} como o conjunto vazio!</b></center>
           </p>
                    <table border=0 align=center width = 1100 bgcolor ='$cor_td3'>
                        <tr align = center bgcolor = '$cor_td2'>
                            <td height=30px  width = 100> <b>Palavra </b ></td>
                            <td height=30px width = 100> <b>Nº Caracteres</b ></td>
                            <td height=30px width = 100> <b>Nº Repetições</b ></td>
                            <td height=30px width = 100 > <b>Validação </b ></td>
                            <td height=30px width = 100 ><b>Reverso </b ></td>
                            <td height=40px  width = 200> <b>Prefixo </b ></td>
                            <td height=40px  width = 200> <b>Sufixo </b ></td>

                        </tr>
                    ";

//ARMAZENA A PALAVRA EM UM VETOR E VERIFICA QUANTAS VEZES A PALAVRA SE REPETE
    $f_contents = explode(' ', $frase);
    foreach ($f_contents as $palavraw) {
        ++$ar[$palavraw];
    }

// EXECUTANDO PALAVRA POR PALAVRA
 foreach ($ar as $palavraw => $conta_palavra) {
     if (strlen($palavraw) >= 1) {
         if ($conta_palavra >= 1) {
             //PALAVRA INVERTIDA
                $reverso = strrev($palavraw);

//CONTA O NUMERO DE CARACTER EM CADA PALAVRA
                $numCaracter = strlen($palavraw);

//CHECANDO AS PALAVRAS COM AS PALAVRAS VALIDAS DO ALFABETO
            $estado = 0;
             $i = 0;
             $numeros = array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9);
             $vet[0][0] = '+';   $vet[0][1] = '-';   $vet[0][2] = 'N';           $vet[0][3] = 'N';
             $vet[1][0] = 'N';   $vet[1][1] = 'N';   $vet[1][2] = '$numeros';    $vet[1][3] = 'N';
             $vet[2][0] = 'N';   $vet[2][1] = 'N';   $vet[2][2] = '$numeros';    $vet[2][3] = '.';
             $vet[3][0] = 'N';   $vet[3][1] = 'N';   $vet[3][2] = '$numeros';    $vet[3][3] = 'N';
             $vet[4][0] = 'N';   $vet[4][1] = 'N';   $vet[4][2] = '$numeros';    $vet[4][3] = 'N';

             $qCaracter = $numCaracter;
             while ($i < $qCaracter) {
                 $simbolo = $palavraw[$i];
                 switch ($estado) {
                        case 0:
                        {
                            if ($simbolo == $vet[$estado][1]) {
                                //"-")

                                $estado = 1;
                            } elseif ($simbolo == $vet[$estado][0]) {
                                //"+")

                                $estado = 1;
                            } else {
                                $qCaracter = -1;//$qCaracter+1;
                            }
                            break;
                        }
                        case 1:
                        {
                            if (array_key_exists($simbolo, $numeros)) {
                                $estado = 2;
                            } else {
                                $qCaracter = -1;//$qCaracter+1;
                            }
                            break;
                        }
                        case 2:
                        {
                            if ($simbolo == $vet[2][3]) {
                                //".")

                                $estado = 3;
                            } elseif (array_key_exists($simbolo, $numeros)) {
                                $estado = 2;
                            } else {
                                $qCaracter = -1;// $qCaracter+1;
                            }
                            break;
                        }
                        case 3:
                         {
                            if (array_key_exists($simbolo, $numeros)) {
                                $estado = 4;
                            } else {
                                $qCaracter = -1;//$qCaracter+1;
                            }
                            break;
                        }
                        case 4:
                         {
                           if (array_key_exists($simbolo, $numeros)) {
                               $estado = 4;
                           } elseif ($simbolo == $vet[2][3]) {
                                $qCaracter = -1;//$qCaracter+1;
                                    $estado = 5;
                            } else {
                                    $qCaracter = -1;//$qCaracter+1;
                                    $estado = 5;
                                }
                            break;
                        }

                    }
                 ++$i;
             }
             if ($estado == 4) {
                 $validar = 'VÁLIDA';
             } else {
                 $validar = 'INVÁLIDA';
             }
//INICIO DA TABELA

                 echo"
                 <tr align = center bgcolor = '$cor_td1'>
                    <td height=30px  >$palavraw</td>
                    <td height=30px > $numCaracter caracteres</td>
                    <td height=30px > $conta_palavra repeticoes</td>
                    <td height=30px >$validar</td>
                    <td height=30px >$reverso</td>
                    <td height=30px >";

//ESCREVE O PREFIXO DE CADA PALAVRA
                echo'{}; ';
             for ($d = 1; $d < $numCaracter + 1; ++$d) {
                 $parte = substr($palavraw, 0, $d);
                 echo"<i>$parte ;</i> ";
             }
             echo'</td>
                     <td height=30px >';
//ESCREVE O SUFIXO DE CADA PALAVRA
                echo'{};';
             $b = $numCaracter - 1;
             while ($b >= 0) {
                 $parte2 = substr($palavraw, $b);
                 echo"<i> $parte2 ;</i>";
                 --$b;
             }
             echo'</td>
                        </tr>

                 ';
         }
     }
//CONTA O NUMERO DE CARACTERES TOTAIS NA FRASE
        $caracter = ($caracter + ($numCaracter * $conta_palavra));
 }
    echo"
        <tr align = center bgcolor =  $cor_td2>
                         <td height=30px colspan = 7><b>Número de caracteres encontrados na frase:</b> $caracter</td>
            </tr>
    </table>
<p>
</p>
    <form method = post action=buscarpalavra.php>
        <table border=0 align=center width=450 bgcolor ='$cor_td3'>
            <tr>
                <td><b> Digite a subpalavra</b> <input name=texto  type=text size=30 maxlength= 100/><input type=submit></td>
            </tr>
        </table>
    </form>
    ";

    fclose($arquivo);  //fecha o arquivo
;
