<?php
namespace app\database\model;

use Dompdf\Dompdf;
use Dompdf\Options;

class MakePdf
{   
    public static function makePdfByProducts($products)
    {
        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('defaultFont', 'Helvetica');
        $options->set('isRemoteEnabled', true);
        $dompdf = new Dompdf($options);

        $html = '<html><head><style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial, sans-serif; }
        
        /* Página inteira */
        .page {
            width: 100vw;
            height: 100vh;
            position: relative; /* Para conter a posição absoluta da imagem */
            text-align: center;
            page-break-after: always;
            padding: 20px;
        }
        
        /* Container principal */
        .container {
            width: 90%;
            height: 90%;
            padding: 20px;
            border: 2px solid black;
            position: relative; /* Necessário para o posicionamento da imagem */
        }
        
        /* Título responsivo */
        .title {
            font-size: 50px;
            font-weight: bold;
            margin-bottom: 10px;
            max-width: 100%;
            word-wrap: break-word;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        /* Se o título for muito grande, reduzimos o tamanho da fonte */
        .title.large {
            font-size: 35px;
        }

        /* Descrição responsiva */
        .desc {
            font-size: 16px;
            margin-bottom: 20px;
        }

        /* Imagem fixada na parte inferior */
        .image {
            width: 50%;
            height: auto;
            border-radius: 10px;
            position: absolute;
            bottom: 20px;
            left: 50%;
            transform: translateX(-50%);
        }

    </style></head><body>';

        foreach ($products as $product) {
            // Adapta o tamanho do título caso ele seja muito longo
            $tituloClass = (strlen($product->descricao) > 50) ? 'large' : '';

            $html .= "<div class='page'>
                    <div class='container'>
                        <div class='title $tituloClass'>{$product->descricao}</div>

                        <img class='image' src='{$product->imagem}' alt='Foto de {$product->descricao}'>
                    </div>
                  </div>";
        }

        // Fechar o HTML
        $html .= '</body></html>';

        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');

        $dompdf->render(); 
        // Envia os headers para forçar o download via AJAX
        header("Content-Type: application/pdf");
        header("Content-Disposition: attachment; filename= produtos.pdf");
        echo $dompdf->output();
        exit;
    }
}
?>