<?php
    $texto = $_POST['texto'];
    $arquivo = fopen("./frase.txt", "r"); //abrinco o arquivo txt
    while(!feof($arquivo))
    {
        $char .= fgetc($arquivo);
    }
//ESCREVE A FRASE SEM OS ESPAÇOS DUPLOS
    $frase = "$char";
    $frase = trim($frase);
    $frase = preg_replace('/\s(?=\s)/', '', $frase);
    $frase = preg_replace('/[\n\r\t]/', ' ', $frase);

//SEPARA E LER AS LINHAS, CONTANDO QUANTAS PALAVRAS EXIXTEM EM CADA LINHA
	$linha = explode(PHP_EOL,$frase);
	$Tpalavaras = 0;
	for($posl=0; $posl<count($linha); $posl++)
	{
        if ($linha[$posl] != PHP_EOL)
        {
            $palavras = explode(" ",$linha[$posl]);
            $Tpalavras += count($palavras);
        }
	}

//ARMAZENA A PALAVRA EM UM VETOR E VERIFICA QUANTAS VEZES A PALAVRA SE REPETE
    $f_contents = explode(" ",$frase);
    foreach ($f_contents as $palavraw)
    {
        $ar[$palavraw]++;
    }
    $contar =0;//numeros de subpalavras
  $cor_td1 = '#E0EEE0';
    $cor_td2 = '#C1FFC1';
    echo"
    <table border=0 align=center width =300 bgcolor ='$cor_td3'>
        <tr align = center bgcolor = '$cor_td2'>
            <td colspan=2> <b>Palavras relacionadas com a subpalavra $texto</b></td>
           </tr>";

// EXECUTANDO PALAVRA POR PALAVRA
    foreach ($ar as $palavraw => $conta_palavra)
    {
        if(strlen($palavraw) >= 1 )
        {
            if ($conta_palavra >= 1)
            {
//CONTA O NUMERO DE CARACTER EM CADA PALAVRA
                $numCaracter = strlen($palavraw);

//FUNCÇAO PARA ENCONTRAR SUBPALAVRAS
                $palavra = "$palavraw";
                $subpalavra  = "$texto";
                $pos1 = strstr($palavra, $subpalavra);//diferencia maiuscula e minuscula
                if ($pos1 === false)
                {
                }
                else
                {
                    echo " <tr align = center bgcolor = '$cor_td1'>
                                <td><i>$palavra</i></td>
                                <td> $subpalavra</td>
                           </tr>
                     ";
                    $contar = $contar+1;
                }
            }
        }
     }
     if ($contar != 0)
     {
        echo"<tr align = center bgcolor = '$cor_td2'>
                                <td colspan=2><B> Número de palavras encontradas :</b> $contar</td>
                           </tr>
                        </table>";
     }
     else
     {
        echo"<tr align = center bgcolor = '$cor_td1'>
                                <td colspan=2><B> Nenhuma palavra encontrada!</b></td>
                           </tr>
                        </table>";
     }

?>
